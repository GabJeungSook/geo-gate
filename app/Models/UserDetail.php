<?php

namespace App\Models;

use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
{
    $firstName = $this->first_name ?? '';
    $lastName = $this->last_name ?? '';

    return $firstName . ' ' . $lastName;
}

public function course()
{
    return $this->belongsTo(Course::class, 'course_id');
}
public function scopeWithRelations($query)
    {
        return $query->with([
            'course.campus' 
        ]);
    }


}
