<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreRegistration extends Model
{
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function event_schedule()
    {
        return $this->belongsTo(EventSchedule::class);
    }
}
