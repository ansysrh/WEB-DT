<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PembayaranSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('pembayaran')->insert([
            [
                'user_id' => 1, // Budi Santoso
                'kode_pembayaran' => 'PAY'.now()->format('YmdHis').'01',
                'jumlah' => 150000.00,
                'metode_pembayaran' => 'Transfer Bank',
                'status' => 'lunas',
                'tanggal_pembayaran' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Sinta Dewi
                'kode_pembayaran' => 'PAY'.now()->format('YmdHis').'02',
                'jumlah' => 200000.00,
                'metode_pembayaran' => 'Transfer Bank',
                'status' => 'pending',
                'tanggal_pembayaran' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3, // Rizky Pratama
                'kode_pembayaran' => 'PAY'.now()->format('YmdHis').'03',
                'jumlah' => 100000.00,
                'metode_pembayaran' => 'COD',
                'status' => 'gagal',
                'tanggal_pembayaran' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
