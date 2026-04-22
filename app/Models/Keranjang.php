<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Model Keranjang
 *
 * @property int|null $id
 * @property string|null $session_id
 * @property int|null $tipe_alat_id
 * @property string|null $nama_alat
 * @property string|null $gambar
 * @property float $harga
 * @property int $jumlah
 *
 * @property-read float $subtotal       // atribut virtual: harga * jumlah
 * @property-read int   $quantity       // alias untuk $jumlah (compatibility)
 */
class Keranjang extends Model
{
    // Nama tabel yang digunakan
    protected $table = 'keranjang';

    // Kolom yang boleh diisi menggunakan mass assignment
    protected $fillable = [
        'session_id',
        'tipe_alat_id',
        'nama_alat',
        'gambar',
        'harga',
        'jumlah',
    ];

    // Casting tipe data otomatis
    protected $casts = [
        'harga' => 'float',
        'jumlah' => 'integer',
    ];

    // RELASI: Setiap item keranjang → milik satu TipeAlat
    public function tipeAlat(): BelongsTo
    {
        return $this->belongsTo(TipeAlat::class, 'tipe_alat_id');
    }

    /**
     * Subtotal untuk item ini (harga * jumlah).
     *
     * Contoh penggunaan: $keranjang->subtotal
     */
    public function getSubtotalAttribute(): float
    {
        $harga = $this->harga ?? 0.0;
        $jumlah = $this->jumlah ?? 0;

        return (float) ($harga * $jumlah);
    }

    /**
     * Alias quantity untuk kompatibilitas kode yang memakai bahasa Inggris.
     *
     * Contoh: $keranjang->quantity
     */
    public function getQuantityAttribute(): int
    {
        return (int) ($this->jumlah ?? 0);
    }
}
