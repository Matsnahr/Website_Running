<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'event_id', 'event_run_category_id', 'user_id',
        'no_bib', 'nama_lengkap', 'email', 'no_hp', 'nik',
        'jenis_kelamin', 'ukuran_jersey', 'kode_kupon',
        'total_bayar', 'nominal_bayar', 'diskon', 'status_bayar',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function runCategory()
    {
        return $this->belongsTo(EventRunCategory::class, 'event_run_category_id');
    }
}