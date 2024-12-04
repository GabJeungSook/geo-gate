<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];

    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function schedules()
    {
        return $this->hasMany(EventSchedule::class);
    }
}
