<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Senaempresa extends Model
{
    protected $fillable = [
        'name',
        'location',
        'start_date',
        'end_date',
        'instructor_id',
        
    ];

    public function instructor(){
        return $this->belongsTo(Instructor::class);
    }

    public function students(){
        return $this->hasMany(Student::class);
    }

    public function certificates(){
        return $this->hasMany(Certificate::class);
    }
}
