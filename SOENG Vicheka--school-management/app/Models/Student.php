<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'student_id',
        'profile',
        'first_name',
        'last_name',
        'gender',
        'email',
        'password',
        'province',
        'generation_id'
    ];

    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }

    public function studentClasses()
    {
        return $this->hasMany(StudentClass::class);
    }
}
