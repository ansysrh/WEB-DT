<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

// Controller dasar aplikasi
// File ini adalah kelas controller utama yang diwarisi oleh semua controller
// lain di aplikasi (mis. AdminController, KeranjangController, dll.).
// Di sini kita memasang beberapa trait bawaan Laravel yang sering berguna
// untuk menangani otorisasi, queue job, dan validasi request.
class Controller extends BaseController
{
    // Trait ini menambahkan helper untuk pengecekan otorisasi (policies/gates),
    // contohnya: $this->authorize('update', $model);
    use AuthorizesRequests,

        // Trait ini memberikan kemampuan untuk mengdispatch (mengirim) job ke queue,
        // misalnya: dispatch(new \App\Jobs\SomeJob($data));
        DispatchesJobs,

        // Trait ini menyediakan helper validasi sederhana pada controller,
        // misalnya: $this->validate($request, [...]);
        ValidatesRequests;
}
