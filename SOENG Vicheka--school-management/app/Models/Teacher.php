<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'profile',
        'password',
    ];

    public function teacherClassSubjects()
    {
        return $this->hasMany(TeacherClassSubject::class);
    }
}
