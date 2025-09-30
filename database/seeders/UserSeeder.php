<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run()
    {
        $password = '$2y$12$NPysK8ES1BUcyQIB6ArPw.oDKm0ptN38pqlYdYOh6CDhTUY7RNipC';
        $verifiedAt = '2025-08-15 10:00:00';

        $names = [
            'Bob Smith', 'Alice Johnson', 'Charlie Brown', 'Diana Prince', 'Ethan Hunt',
            'Fiona Gallagher', 'George Clooney', 'Hannah Baker', 'Ian McKellen', 'Julia Roberts',
            'Kevin Hart', 'Laura Palmer', 'Michael Jordan', 'Nina Simone', 'Oscar Wilde',
            'Pam Beesly', 'Quentin Tarantino', 'Rachel Green', 'Steve Rogers', 'Tina Fey',
            'Uma Thurman', 'Victor Hugo', 'Wendy Darling'
        ];

        // Create 20 customers
        foreach (array_slice($names, 0, 20) as $name) {
            DB::table('users')->insert([
                'name' => $name,
                'email' => Str::slug($name, '.') . '@example.com',
                'password' => $password,
                'role' => 'customer',
                'email_verified_at' => $verifiedAt,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

        }

        // Create 3 opticians
        foreach (array_slice($names, 20, 3) as $name) {
            DB::table('users')->insert([
                'name' => $name,
                'email' => Str::slug($name, '.') . '@example.com',
                'password' => $password,
                'role' => 'optician',
                'email_verified_at' => $verifiedAt,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
