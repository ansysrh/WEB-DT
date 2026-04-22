<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

// MODEL PESANAN
// Model ini mewakili tabel "pesanan" yang digunakan untuk menyimpan
// data pemesanan alat oleh pengguna. Di dalamnya terdapat informasi:
// - identitas pemesan
// - lama sewa
// - tanggal mulai & tanggal kembali
// - status pesanan & metode pembayaran
// - session_id (untuk menghubungkan dengan keranjang)
class Pesanan extends Model
{
    protected $table = 'pesanan';

    // Kolom yang dapat diisi dengan mass assignment
    protected $fillable = [
        'nama',               // nama pemesan
        'whatsapp',           // nomor whatsapp untuk kontak
        'email',              // email pemesan (opsional)
        'hari',               // jumlah hari sewa
        'tanggal_mulai',      // tanggal mulai sewa
        'tanggal_kembali',    // tanggal alat harus dikembalikan
        'session_id',         // menghubungkan pesanan dengan session keranjang
        'metode_pembayaran',  // Cash / QRIS
        'status',             // status pesanan (pending, menunggu verifikasi, dsb.)
    ];

    // RELASI: 1 PESANAN → BANYAK ITEM (PesananItem)
    // Setelah user selesai checkout, snapshot keranjang disimpan
    // dalam bentuk PesananItem sehingga data item tetap aman
    // meskipun harga atau stok berubah.
    public function items(): HasMany
    {
        return $this->hasMany(PesananItem::class, 'pesanan_id');
    }

    // RELASI: 1 PESANAN → 1 PEMBAYARAN (HasOne)
    // Setiap pesanan memiliki satu pembayaran yang terkait.
    // Jika di masa depan ingin mendukung banyak pembayaran,
    // relasi ini bisa diubah menjadi hasMany.
    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'pesanan_id');
    }
}
