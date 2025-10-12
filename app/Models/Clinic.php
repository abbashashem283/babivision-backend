<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'open_time',
        'close_time',
        'workdays',
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
