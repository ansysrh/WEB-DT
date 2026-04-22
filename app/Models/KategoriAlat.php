<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// MODEL KATEGORI ALAT
// Model ini mewakili tabel "kategori_alat" di database.
// Setiap kategori dapat memiliki banyak tipe alat.
// Model ini sederhana dan sering dipakai untuk keperluan
// pengelompokan barang di halaman admin.
class KategoriAlat extends Model
{
    use HasFactory; // memungkinkan pembuatan factory untuk keperluan seeding/testing

    // Nama tabel yang digunakan
    protected $table = 'kategori_alat';

    // Kolom yang boleh diisi menggunakan mass assignment
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    // RELASI: 1 Kategori → Banyak TipeAlat
    // Setiap kategori dapat memiliki daftar tipe alat yang berbeda.
    // Relasi ini memudahkan kita mengambil semua tipe alat yang
    // termasuk dalam kategori tertentu.
    public function tipeAlat(): HasMany
    {
        return $this->hasMany(TipeAlat::class, 'kategori_id');
    }
}
