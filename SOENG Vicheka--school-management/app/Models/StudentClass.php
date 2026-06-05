<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $fillable = [
        'class_id',
        'student_id',
    ];

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function class()
    {
        return $this->classRoom();
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
