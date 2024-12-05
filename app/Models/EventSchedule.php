<?php

namespace App\Models;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;

class EventSchedule extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];
    
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    


    public function attendances(){
        return $this->hasMany(Attendance::class);
    }


    public function scopeWithRelations($query){
        $query->with(['event','attendances','preRegistrations.user',]);
    }
    public function preRegistrations()
    {
        return $this->hasMany(PreRegistration::class);
    }
    

    
   
   public function scopeActiveSchedule($query)
   {
          return $query->where('is_active', true);
      }

      public function scopeFirstActiveSchedule($query)
    {
        return $query->activeSchedule()->first(); 
    }
}
