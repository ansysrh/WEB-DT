<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipeAlatSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk tabel tipe_alat.
     */
    public function run(): void
    {
        DB::table('tipe_alat')->insert([
            // Kategori 1: Tenda dan Alat Tidur
            [
                'kategori_id' => 1,
                'nama_alat' => 'Tenda Dome 4 Orang',
                'stok' => 10,
                'harga' => 75000,
                'deskripsi' => 'Tenda kapasitas 4 orang, tahan angin dan hujan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 1,
                'nama_alat' => 'Sleeping Bag Hangat',
                'stok' => 20,
                'harga' => 25000,
                'deskripsi' => 'Sleeping bag tebal untuk cuaca dingin.',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori 2: Kebutuhan Tracking
            [
                'kategori_id' => 2,
                'nama_alat' => 'Sepatu Tracking Anti Air',
                'stok' => 15,
                'harga' => 50000,
                'deskripsi' => 'Sepatu dengan sol kuat dan bahan waterproof.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_id' => 2,
                'nama_alat' => 'Carrier 60L',
                'stok' => 12,
                'harga' => 40000,
                'deskripsi' => 'Tas carrier berkapasitas besar dengan back support.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
