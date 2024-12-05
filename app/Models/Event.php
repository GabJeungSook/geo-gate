<?php

namespace App\Models;

use App\Models\EventSchedule;
use App\Models\PreRegistration;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $guarded = [];
    protected $casts = [

        'is_active' => 'boolean',
    ];


    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }

    public function eventSchedules(){
        return $this->hasMany(EventSchedule::class);
    }
   

   
   public function scopeActiveEvent($query)
{
       return $query->where('is_active', true);
   }

     public function scopeWithRelations($query)
   {
       return $query->with(['campus','eventSchedules.attendances.user','eventSchedules.preRegistrations.user']);
   }

   public function firstActiveSchedule()
    {
        return $this->eventSchedules()->firstActiveSchedule(); 
    }
}
