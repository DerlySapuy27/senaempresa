<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $table = 'students';

    protected $fillable = [
        'name',
        'last_name',
        'document_type',
        'document_number',
        'expedition_date',
        'expedition_place',
        'technologist_id',
        'senaempresa_id',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'student_role', 'student_id', 'role_id');
    }
    public function technologist()
    {
        return $this->belongsTo(Technologist::class);
    }

    public function senaempresa()
    {
        return $this->belongsTo(Senaempresa::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
