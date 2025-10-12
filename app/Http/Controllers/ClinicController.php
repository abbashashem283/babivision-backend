<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    public function clinics(){
        $clinics = Clinic::all();
        return compact('clinics');
    }
}
