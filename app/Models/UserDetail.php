<?php

namespace App\Models;

use App\Models\User;
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

}
