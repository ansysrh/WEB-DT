<?php

use Illuminate\Support\Facades\Route;
use App\Models\TipeAlat;

Route::get('/test', function () {
    return response()->json(['message' => 'API jalan']);
});

Route::get('/tipe-alat', function () {
    return TipeAlat::all();
});