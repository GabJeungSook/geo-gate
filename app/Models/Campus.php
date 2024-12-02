<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $fillable = ['name', 'latitude', 'longitude', 'radius'];

    protected $casts = [
        'name' => 'string',
        'latitude' => 'double',
        'longitude' => 'double',
        'radius' => 'double'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
