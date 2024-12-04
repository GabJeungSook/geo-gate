<?php

namespace App\Models;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Eloquent\Model;

class PreRegistration extends Model
{
    


    public function event_schedule(){
        return $this->belongsTo(EventSchedule::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
