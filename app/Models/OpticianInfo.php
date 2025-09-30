<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpticianInfo extends Model
{
    protected $table = 'optician_info';

    protected $fillable = [
        'user_id',
        'shift_start',
        'shift_end',
        'clinic_id'
    ];

    public function user() {
       return $this->belongsTo(User::class);
    }

    public function clinic(){
        return $this->belongsTo(Clinic::class);
    }
}
