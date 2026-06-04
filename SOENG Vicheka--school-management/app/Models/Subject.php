<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function teacherClassSubjects()
    {
        return $this->hasMany(TeacherClassSubject::class);
    }
}
