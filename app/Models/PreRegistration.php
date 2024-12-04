<?php

namespace App\Models;

use App\Models\User;
use App\Models\Event;
use App\Models\EventSchedule;
use Illuminate\Database\Eloquent\Model;

class PreRegistration extends Model
{
    


    public function eventSchedule(){
        return $this->belongsTo(EventSchedule::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
