<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// MODEL TIPE ALAT
// Model ini mewakili tabel "tipe_alat" yang menyimpan daftar alat
// yang dapat disewa. Setiap tipe alat memiliki:
// - kategori
// - nama alat
// - gambar
// - stok
// - harga sewa
// - deskripsi
class TipeAlat extends Model
{
    use HasFactory; // memungkinkan penggunaan factory untuk testing & seeding

    protected $table = 'tipe_alat';

    // Kolom yang dapat diisi secara mass assignment
    protected $fillable = [
        'kategori_id',  // kategori alat (relasi ke KategoriAlat)
        'nama_alat',    // nama alat yang ditampilkan pada UI
        'gambar',       // path file gambar
        'stok',         // jumlah stok tersedia
        'harga',   // harga sewa per hari
        'deskripsi',    // deskripsi alat
    ];

    // RELASI: TipeAlat → KategoriAlat (Many to One)
    // Setiap tipe alat pasti berada dalam satu kategori.
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriAlat::class, 'kategori_id');
    }
}
