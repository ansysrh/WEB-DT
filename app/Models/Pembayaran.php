<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// MODEL PEMBAYARAN
// Model ini mewakili tabel "pembayaran" yang menyimpan transaksi
// pembayaran untuk pesanan. Model ini menangani:
// - kode pembayaran otomatis
// - relasi ke pesanan & user
// - status pembayaran
class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'user_id',              // ID user (jika login)
        'pesanan_id',           // ID pesanan yang dibayar
        'kode_pembayaran',      // kode unik pembayaran
        'jumlah',               // total jumlah yang harus dibayar
        'metode_pembayaran',    // Cash / QRIS
        'status',               // pending / selesai / menunggu verifikasi
        'tanggal_pembayaran',   // waktu pembayaran dilakukan
        'bukti',                // path bukti pembayaran (jika ada)
    ];

    // Casting otomatis
    protected $casts = [
        'tanggal_pembayaran' => 'datetime',
    ];

    // Nilai default
    protected $attributes = [
        'status' => 'pending',  // status awal ketika pembayaran dibuat
    ];

    // BOOTED: otomatis menghasilkan kode pembayaran jika belum ada
    protected static function booted()
    {
        static::creating(function ($model) {
            // Jika belum ada kode, buat otomatis
            if (empty($model->kode_pembayaran)) {
                $model->kode_pembayaran = static::generateKode();
            }
        });
    }

    // GENERATE KODE PEMBAYARAN UNIK
    // Format: PAY-YYYYMMDD-XXXXXX
    // - Prefix bisa diganti jika diperlukan
    // - Menggunakan UUID agar unik
    public static function generateKode(string $prefix = 'PAY'): string
    {
        $date = now()->format('Ymd');
        $uniq = strtoupper(substr(Str::uuid()->toString(), 0, 6));

        return "{$prefix}-{$date}-{$uniq}";
    }

    // RELASI: Pembayaran → Pesanan (Many to One)
    // Setiap pembayaran pasti terkait dengan satu pesanan.
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }
}
