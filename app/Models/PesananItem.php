<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// MODEL PESANAN ITEM
// Model ini menyimpan snapshot item yang ada dalam keranjang
// pada saat user melakukan checkout. Tujuannya agar data item
// tetap tercatat meskipun harga/stok alat berubah di masa depan.
class PesananItem extends Model
{
    // Nama tabel
    protected $table = 'pesanan_items';

    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'pesanan_id',   // ID pesanan induk
        'product_id',   // ID tipe alat saat transaksi (snapshot)
        'nama_alat',    // Nama alat ketika transaksi
        'jumlah',       // Jumlah unit yang dipesan
        'harga',        // Harga sewa per unit per hari
        'subtotal',     // harga * jumlah (per hari)
    ];

    // RELASI: PesananItem → Pesanan (Many to One)
    // Setiap item hanya dimiliki oleh satu pesanan.
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
