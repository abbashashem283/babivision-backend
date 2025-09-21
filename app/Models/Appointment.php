<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function optician(){
        return $this->belongsTo(User::class, 'optician_id');
    }

    public function service(){
        return $this->belongsTo(Service::class);
    }
}
