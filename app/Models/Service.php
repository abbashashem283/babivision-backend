<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        "name","discription","duration_min","price","image"
    ];

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
