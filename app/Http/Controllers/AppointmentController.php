<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\OpticianInfo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function appointments(Request $request)
    {
        $upto = $request->query("upto");
        $clinic = $request->query("clinic");
        $startDay = $request->query("startDay");
        if (!$upto || !$clinic || !$startDay)
            return response()->json(["message" => "No query parameters", "type" => "error"]);
        $startDayDate = Carbon::parse($startDay);
        $tillDayStr = $startDayDate->addDay((int) $upto)->format('Y-m-d');

        $appointments = Appointment::select('start_time', 'end_time', 'day', 'optician_id')
            ->where('clinic_id', $clinic)
            ->where('day', '>=', $startDay)
            ->orderBy('start_time')
            ->get()
            ->groupBy('day')
            ->map(function ($dailyAppointments) {
                return $dailyAppointments->groupBy('optician_id');
            });

        if ($appointments->isEmpty())
            return response()->json(["message" => "No appointments found $clinic $startDay $upto", "type" => "error"]);

        $optician_info = OpticianInfo::select('user_id', 'shift_start', 'shift_end')->where('clinic_id', $clinic)->get()->groupBy('user_id');

        $clinic = Clinic::find($clinic)->first();

        return compact('appointments', 'optician_info', 'clinic');
    }


    public function bookAppointment(Request $request)
    {

       // return response()->json(["type"=>"error", "message"=>"just testing and {$request['clinic_id']}"]);


        $validator = Validator::make($request->all(), [
            "user_id" => "required|exists:users,id",
            "optician_id" => "required|exists:optician_info,user_id",
            "service_id" => "required|exists:services,id",
            "clinic_id" => "required|exists:clinics,id",
            "day" => "required|date_format:Y-m-d|after_or_equal:today",
            "start_time" => "required|date_format:H:i",
            "end_time" => "required|date_format:H:i|after:start_time"
        ]);

        $validator->after(function ($validator) use ($request) {
            try {
                $startTimeWDay = Carbon::createFromFormat('Y-m-d H:i', "{$request->input('day')} {$request->input('start_time')}");
                if ($startTimeWDay->lessThan(Carbon::now())) {
                    $validator->errors()->add('start_time', 'Start time must be after now');
                }
            } catch (\Exception $e) {
                $validator->errors()->add('start_time', 'Invalid date or time format.');
            }
        });

        $validated = $validator->validate();

        $optician = OpticianInfo::where('user_id', $validated['optician_id'])->first();

        if ($optician['clinic_id'] != $validated['clinic_id'])
            return response()->json(["type" => "error", "message" => "optician clinic mismatch"]);

        try {
            Appointment::create($validated);
        } catch (\Exception $e) {
            return response()->json(["type" => "error", "message" => "couldn't create appointment {$e->getMessage()}"]);
        }

        return response()->json(["type" => "success", "message" => "Appointment Added!"]);
    }
}
