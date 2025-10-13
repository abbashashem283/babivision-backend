<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    //

    protected $fillable = [
        'user_id',
        'optician_id',
        'service_id',
        'day',
        'start_time',
        'end_time'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function optician(){
        return $this->belongsTo(User::class, 'optician_id');
    }

    public function service(){
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function clinic(){
        return $this->belongsTo(Clinic::class, 'clinic_id');
    }
}
