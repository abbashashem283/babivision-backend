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
        $userId = $request->query('user');

        if ($userId) {
            $atDay = $request->query('at_day');
            if ($atDay) {
                $appointments = Appointment::with('clinic:id,name', 'service:id,name')->where('user_id', $userId)->where('day', $atDay)->get();
            } else {
                $appointments = Appointment::with('user', 'service', 'clinic')->where('user_id', $userId)->get();
            }
            return compact('appointments');
        }


        $clinic = $request->query("clinic");
        $startDay = $request->query("startDay");
        if (!$clinic || !$startDay)
            return response()->json(["message" => "No query parameters", "type" => "error"]);
        $startDayDate = Carbon::parse($startDay);


        $appointments = Appointment::select('start_time', 'end_time', 'day', 'optician_id')
            ->where('clinic_id', $clinic)
            ->where('day', '>=', $startDay)
            ->orderBy('start_time')
            ->get()
            ->groupBy('day')
            ->map(function ($dailyAppointments) {
                return $dailyAppointments->groupBy('optician_id');
            });

        // dd($appointments);    



        $optician_info = OpticianInfo::select('user_id', 'shift_start', 'shift_end')->where('clinic_id', $clinic)->get()->groupBy('user_id');

        $clinic = Clinic::find($clinic)->first();

        if ($appointments->isEmpty())
            return compact('optician_info', 'clinic');

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
        } catch (\Exception) {
            return response()->json(["type" => "error", "message" => "couldn't create appointment"]);
        }

        return response()->json(["type" => "success", "message" => "Appointment Added!"]);
    }


    public function deleteAppointment(Request $request)
    {

        $appointmentId = $request['id'];
        $userId = $request['user_id'];
        $csrfToken = $request['csrf_token'];

        if (!$csrfToken)
            return response()->json(["type" => "error", "message" => "UnAuthorized"], 403);

        $validatedTokens = auth()->validate(["tokens" => ["csrf" => $csrfToken]]);
        $csrfIsValid = !!$validatedTokens['csrf'];
        if (!$csrfIsValid)
            return response()->json(["type" => "error", "message" => "untrusted identity"], 403);

        if (!$appointmentId || !$userId)
            return response()->json(["type" => "error", "message" => "Invalid user/appointment"]);

        $appointment = Appointment::find($appointmentId);

        if (!$appointment)
            return response()->json(["type" => "error", "message" => "No appointment for given Id"]);

        if ($appointment->user->id != $userId)
            return response()->json(["type" => "error", "message" => "Wrong User for appointment!"]);


        try {
            $appointment->delete();
        } catch (\Exception) {
            return response()->json(["type" => "error", "message" => "couldn't delete appointment"]);
        }

        return response()->json(["type" => "success", "message" => "Appointment Deleted!"]);
    }
}
