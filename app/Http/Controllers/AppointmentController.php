<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\OpticianInfo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    public function appointments(Request $request)
    {
        $upto = $request->query("upto");
        $clinic = $request->query("clinic");
        if (!$upto || !$clinic)
            return response()->json(["message" => "No query parameters", "type" => "error"]);
        $today = Carbon::today();

        $todayStr = $today->format('Y-m-d');
        $tillDayStr = $today->addDay((int) $upto)->format('Y-m-d');

        $appointments = Appointment::select('start_time', 'end_time', 'day', 'optician_id')
            ->where('clinic_id', $clinic)
            ->whereBetween('day', [$todayStr, $tillDayStr])
            ->orderBy('start_time')
            ->get()
            ->groupBy('day')
            ->map(function ($dailyAppointments) {
                return $dailyAppointments->groupBy('optician_id');
            });

        if($appointments->isEmpty())
            return response()->json(["message"=>"No appointments found", "type"=>"error"]);    

        $optician_info = OpticianInfo::select('user_id', 'shift_start', 'shift_end')->where('clinic_id',$clinic)->get()->groupBy('user_id');

        $clinic = Clinic::find($clinic)->first();

        return compact('appointments', 'optician_info', 'clinic');
    }
}
