<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = [
    'patient_id',
    'date',
    'sph_od',
    'sph_os',
    'cyl_od',
    'cyl_os',
    'axis_od',
    'axis_os',
    'add_od',
    'add_os',
    'pd',
    'type',
    'notes',
];

protected $casts = [
    'sph_od' => 'float',
    'sph_os' => 'float',
    'cyl_od' => 'float',
    'cyl_os' => 'float',
    'axis_od' => 'integer',
    'axis_os' => 'integer',
    'add_od' => 'float',
    'add_os' => 'float',
    'pd'     => 'float',
];



public function user(){
    return $this->belongsTo(User::class);
}
}
