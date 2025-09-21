<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        "name","discription","duration_min","price"
    ];

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
