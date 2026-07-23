<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventRunCategory extends Model
{
    protected $fillable = [
        'event_id', 'nama', 'jarak_km', 'harga', 'kuota', 'terisi', 'deskripsi', 'urutan',
    ];

    protected $casts = [
        'harga'    => 'decimal:2',
        'jarak_km' => 'decimal:2',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function getPersenTerisiAttribute(): int
    {
        return $this->kuota > 0 ? round(($this->terisi / $this->kuota) * 100) : 0;
    }

    public function getIsPenuhAttribute(): bool
    {
        return $this->terisi >= $this->kuota;
    }
}
