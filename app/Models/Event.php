<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama', 'kota', 'kategori', 'jarak_km', 'tanggal', 'waktu_mulai',
        'harga', 'early_bird_harga', 'early_bird_deadline',
        'kuota', 'terisi', 'status', 'deskripsi', 'thumbnail', 'lokasi_detail',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function facilities()
    {
        return $this->hasMany(EventFacility::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function runCategories()
    {
        return $this->hasMany(EventRunCategory::class)->orderBy('urutan')->orderBy('harga');
    }

    /**
     * Apakah event ini menggunakan sistem multi-kategori.
     */
    public function getHasRunCategoriesAttribute(): bool
    {
        return $this->runCategories()->exists();
    }

    public function getPersenTerisiAttribute()
    {
        return $this->kuota > 0 ? round(($this->terisi / $this->kuota) * 100) : 0;
    }
}