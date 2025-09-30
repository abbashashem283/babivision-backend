<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;



class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $opticianIds = [2, 24, 25, 26];
        $userIds = range(3, 23);

        $services = [
            1 => 30,
            2 => 45,
            3 => 20,
            4 => 40,
            5 => 15,
        ];

        $usedSlots = []; // Tracks optician_id + day + start_time combinations
        $appointments = [];

        $maxAttempts = 200; // Prevent infinite loops
        $count = 0;

        while (count($appointments) < 50 && $count < $maxAttempts) {
            $count++;

            $opticianId = $opticianIds[array_rand($opticianIds)];
            $serviceId = array_rand($services);
            $duration = $services[$serviceId];

            $day = Carbon::today()->addDays(rand(0, 30));
            $latestStart = Carbon::createFromTime(17, 0)->subMinutes($duration);
            $startHour = rand(8, $latestStart->hour);
            $startMinute = [0, 15, 30, 45][array_rand([0, 15, 30, 45])];
            $startTime = Carbon::createFromTime($startHour, $startMinute);
            $endTime = (clone $startTime)->addMinutes($duration);

            $slotKey = "{$opticianId}_{$day->toDateString()}_{$startTime->format('H:i')}";

            if (isset($usedSlots[$slotKey])) {
                continue; // Skip duplicate slot
            }

            $usedSlots[$slotKey] = true;

            $appointments[] = [
                'user_id' => $userIds[array_rand($userIds)],
                'optician_id' => $opticianId,
                'service_id' => $serviceId,
                'day' => $day->toDateString(),
                'start_time' => $startTime->format('H:i:s'),
                'end_time' => $endTime->format('H:i:s'),
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('appointments')->insert($appointments);
    }
}

