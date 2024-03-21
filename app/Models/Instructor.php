<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{

    protected $fillable = [
        'name',
        'last_name',
        'ocupation',
        'position',
        'document_type',
        'document_number',
        'expedition_place',
        'phone_number',
        'signature',
    ];

    public function senaempresas(){
        return $this->hasMany(Senaempresa::class);
    }

    public function certificates(){
        return $this->hasMany(Certificate::class);
    }
}
