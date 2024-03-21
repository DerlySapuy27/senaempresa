<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    public function senaempresa(){
        return $this->belongsTo(Senaempresa::class);
    }

    public function instructor(){
        return $this->belongsTo(Instructor::class);
    }

    public function student(){
        return $this->belongsTo(Student::class);
    }
}
