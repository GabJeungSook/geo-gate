<?php

namespace App\Models;

use App\Models\User;
use App\Models\EventSchedule;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $casts = [

        'is_present' => 'boolean',
    ];

    public function eventSchedule(){
        return $this->belongsTo(EventSchedule::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }


    public function scopeWithRelations($query)
    {
        return $query->with(['user','eventSchedule']);
    }
     
}
