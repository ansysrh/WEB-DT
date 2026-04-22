<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'Budi Santoso',
                'email' => 'budi@dtadventure.com',
                'password' => Hash::make('budi123'),
                'phone' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Sinta Dewi',
                'email' => 'sinta@dtadventure.com',
                'password' => Hash::make('sinta123'),
                'phone' => '082345678901',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'Rizky Pratama',
                'email' => 'rizky@dtadventure.com',
                'password' => Hash::make('rizky123'),
                'phone' => '083456789012',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
