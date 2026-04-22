<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Jalankan semua seeder utama aplikasi.
     */
    public function run(): void
    {
        // Jalankan seeder Admin dan User
        $this->call([
            AdminSeeder::class,
            KategoriAlatSeeder::class,
            TipeAlatSeeder::class,
            UserSeeder::class,
            PembayaranSeeder::class,
        ]);
    }
}
