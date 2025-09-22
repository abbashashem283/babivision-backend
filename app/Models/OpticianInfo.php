<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpticianInfo extends Model
{

    protected $fillable = [
        'user_id',
        'shift_start',
        'shift_end'
    ];

    public function user() {
        $this->belongsTo(User::class);
    }
}
