<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OpticianInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
    {
        $timestamp = '2025-09-01 09:00:00';

        $opticianShifts = [
            ['user_id' => 2,  'shift_start' => '08:00:00', 'shift_end' => '12:00:00'],
            ['user_id' => 24, 'shift_start' => '09:00:00', 'shift_end' => '13:00:00'],
            ['user_id' => 25, 'shift_start' => '12:00:00', 'shift_end' => '16:00:00'],
            ['user_id' => 26, 'shift_start' => '13:00:00', 'shift_end' => '17:00:00'],
        ];

        foreach ($opticianShifts as $shift) {
            DB::table('optician_info')->insert([
                'user_id' => $shift['user_id'],
                'shift_start' => $shift['shift_start'],
                'shift_end' => $shift['shift_end'],
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ]);
        }
    }
}
