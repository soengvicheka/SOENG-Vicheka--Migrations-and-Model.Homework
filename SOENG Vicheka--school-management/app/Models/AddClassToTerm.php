<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AddClassToTerm extends Model
{
    protected $fillable = [
        'term_id',
        'class_id',
    ];

    public function term()
    {
        return $this->belongsTo(Term::class);
    }

    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class, 'class_id');
    }

    public function class()
    {
        return $this->classRoom();
    }
}
