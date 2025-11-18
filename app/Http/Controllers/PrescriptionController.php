<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function prescriptions(){
        $user = auth()->user();
        $prescriptions = $user->prescriptions ;
        return compact('prescriptions');
    }
}
