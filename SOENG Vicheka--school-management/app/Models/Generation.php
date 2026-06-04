<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    protected $fillable = [
        'name'
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function terms()
    {
        return $this->hasMany(Term::class);
    }
}
