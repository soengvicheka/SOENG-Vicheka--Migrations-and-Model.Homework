<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherClassSubject extends Model
{
    protected $fillable = [
        'subject_id',
        'class_id',
        'teacher_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function class()
    {
        return $this->classRoom();
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
