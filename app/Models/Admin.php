<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// =============================================================
// MODEL ADMIN
// =============================================================
// Model ini merepresentasikan tabel "admins" di database.
// Karena mewarisi Authenticatable, model ini dapat digunakan
// sebagai akun login (seperti user biasa), tetapi khusus admin.
// =============================================================
class Admin extends Authenticatable
{
    // Trait HasFactory memungkinkan kita membuat data dummy (factory)
    // untuk keperluan testing atau seeding.
    use HasFactory;

    // Trait Notifiable membuat model ini bisa menerima notifikasi,
    // seperti email, broadcast, dsb.
    use Notifiable;

    // Nama tabel yang digunakan. Default Laravel pakai nama jamak
    // dari nama model, tapi di sini kita tentukan secara manual.
    protected $table = 'admins';

    // Field yang boleh diisi secara mass-assignment
    // (misalnya melalui Admin::create([...]) )
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Field yang disembunyikan saat model dikonversi ke array/JSON.
    // Password harus selalu disembunyikan demi keamanan.
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
