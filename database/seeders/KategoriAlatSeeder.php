<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriAlatSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('kategori_alat')->insert([
            [
                'nama_kategori' => 'Tenda dan Alat Tidur',
                'deskripsi' => 'Peralatan untuk mendirikan tenda dan tidur di alam terbuka',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Kebutuhan Tracking-Carrier',
                'deskripsi' => 'Solusi penyimpanan utama saat mendaki, kuat, ergonomis, dan muat banyak barang.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Kebutuhan Tracking-Daypack',
                'deskripsi' => 'Mudah dibawa, cukup untuk perlengkapan sehari-hari di gunung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Kebutuhan Tracking-Hydropack',
                'deskripsi' => 'Praktis dibawa, air minum selalu siap sepanjang perjalanan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Kebutuhan Tracking-Tracking Pole',
                'deskripsi' => 'Membantu keseimbangan saat trekking di medan sulit',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Kebutuhan Tracking-Headlamp',
                'deskripsi' => 'Terang dan ringan, nyaman dipakai saat trekking malam',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Kebutuhan Tracking-Powerbank',
                'deskripsi' => 'Cadangan daya praktis untuk gadget saat di gunung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Kebutuhan Tracking-Kacamata Gunung',
                'deskripsi' => 'Melindungi mata dari sinar matahari dan debu saat hiking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Kebutuhan Tracking-Timbangan Portable',
                'deskripsi' => 'Mengecek berat tas atau perlengkapan dengan mudah',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Peralatan Masak',
                'deskripsi' => 'Praktis dan aman, cocok untuk camping dan tracking”',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Outfit Outdoor-Sepatu Hiking',
                'deskripsi' => 'Sepatu kuat dan nyaman untuk trekking di berbagai medan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Outfit Outdoor-Jaket Gorpcore',
                'deskripsi' => 'Jaket outdoor stylish dan tahan cuaca',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Outfit Outdoor-Jaket Gelembung',
                'deskripsi' => 'Nyaman dipakai, cocok untuk cuaca ekstrem di gunung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Outfit Outdoor-Jaket Anti UV',
                'deskripsi' => 'Jaket outdoor stylish dan tahan cuaca',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Outfit Outdoor-Celana Cargo',
                'deskripsi' => 'Celana outdoor dengan banyak kantong, praktis dibawa hiking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama_kategori' => 'Perlengkapan Tambahan',
                'deskripsi' => 'Perlengkapan tambahan untuk keamanan tubuh & kebersihan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
