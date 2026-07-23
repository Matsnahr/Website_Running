<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventFacility extends Model
{
    protected $fillable = ['event_id', 'nama_fasilitas', 'icon'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}