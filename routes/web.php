<?php

use App\Http\Controllers\Admin\CheckoutController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\ManajemenAlatController;
use App\Models\KategoriAlat;
use App\Models\TipeAlat;
use Illuminate\Support\Facades\Route;
use App\Models\Keranjang;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
|
| File ini berisi route untuk bagian publik (user) dan admin (login/CRUD)
| Catatan: beberapa route menggunakan prefix '/admin' di URL tetapi
| sekaligus menampilkan view di folder 'Admin' atau 'adminn'.
| Perhatikan konsistensi URL dan nama route (contoh: admin vs adminn).
|
*/

// Root -> redirect ke dashboard user (public)
Route::get('/', function () {
    return redirect()->route('User.dashboard');
});

// Halaman publik "hubungi" / dashboard user
Route::get('/admin/hubungin', function () {
    return view('User.dashboard');
})->name('User.dashboard');

// Halaman admin hubungi (publik)
Route::get('/admin/hubungi', function () {
    return view('Admin.hubungi');
})->name('admin.hubungi');

// Halaman publik lain: cara sewa, pricelist, syarat
Route::get('/admin/carasewa', function () {
    return view('Admin.carasewa');
})->name('admin.carasewa');

Route::get('/admin/pricelist', function () {
    return view('Admin.pricelist');
})->name('admin.pricelist');

Route::get('/admin/syarat', function () {
    return view('Admin.syarat');
})->name('admin.syarat');

Route::get('/admin/kategori_kebutuhantracking', function () {
    return view('Admin.kategori_kebutuhantracking');
})->name('admin.kategori_kebutuhantracking');

Route::get('/admin/kategori_outfitoutdoor', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Outfit Outdoor')->first();

    $items = $kategori 
        ? TipeAlat::where('kategori_id', $kategori->id)->get() 
        : collect();

    return view('Admin.kategori_outfitoutdoor', compact('items', 'kategori'));
})->name('admin.kategori_outfitoutdoor');

Route::get('/admin/isidata', function () {
    return view('Admin.isidata');
})->name('admin.isidata');

Route::get('/cart/count', function (\Illuminate\Http\Request $request) {
    $sessionId = $request->session()->getId();
    $count = \App\Models\Keranjang::where('session_id', $sessionId)->sum('jumlah');
    
    return response()->json(['count' => $count]);
});

// --------------------------------------------------
// KATEGORI SPESIFIK (public)
// --------------------------------------------------
// Catatan: banyak route hampir sama hanya berbeda nama kategori dan view.
// Bisa dipertimbangkan untuk dijadikan satu route dinamis agar lebih ringkas.

Route::get('/admin/kategori_tenda', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Tenda dan Alat Tidur')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_tenda', compact('items', 'kategori'));
})->name('admin.kategori_tenda');

Route::get('/admin/kategori_carrier', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Kebutuhan Tracking-Carrier')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_carrier', compact('items', 'kategori'));
})->name('admin.kategori_carrier');

Route::get('/admin/kategori_daypack', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Kebutuhan Tracking-Daypack')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_daypack', compact('items', 'kategori'));
})->name('admin.kategori_daypack');

Route::get('/admin/kategori_hydropack', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Kebutuhan Tracking-Hydropack')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_hydropack', compact('items', 'kategori'));
})->name('admin.kategori_hydropack');

Route::get('/admin/kategori_trackingpole', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Kebutuhan Tracking-Tracking Pole')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_trackingpole', compact('items', 'kategori'));
})->name('admin.kategori_trackingpole');

Route::get('/admin/kategori_headlamp', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Kebutuhan Tracking-Headlamp')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_headlamp', compact('items', 'kategori'));
})->name('admin.kategori_headlamp');

Route::get('/admin/kategori_powerbank', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Kebutuhan Tracking-Powerbank')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_powerbank', compact('items', 'kategori'));
})->name('admin.kategori_powerbank');

Route::get('/admin/kategori_kacamatagunung', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Kebutuhan Tracking-Kacamata Gunung')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_kacamatagunung', compact('items', 'kategori'));
})->name('admin.kategori_kacamatagunung');

Route::get('/admin/kategori_timbanganportable', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Kebutuhan Tracking-Timbangan Portable')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_timbanganportable', compact('items', 'kategori'));
})->name('admin.kategori_timbanganportable');

Route::get('/admin/kategori_peralatanmasak', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Peralatan Masak')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_peralatanmasak', compact('items', 'kategori'));
})->name('admin.kategori_peralatanmasak');

Route::get('/admin/kategori_sepatuhiking', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Outfit Outdoor-Sepatu Hiking')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_sepatuhiking', compact('items', 'kategori'));
})->name('admin.kategori_sepatuhiking');

Route::get('/admin/kategori_jaketgorpcore', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Outfit Outdoor-Jaket Gorpcore')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_jaketgorpcore', compact('items', 'kategori'));
})->name('admin.kategori_jaketgorpcore');

Route::get('/admin/kategori_jaketgelembung', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Outfit Outdoor-Jaket Gelembung')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_jaketgelembung', compact('items', 'kategori'));
})->name('admin.kategori_jaketgelembung');

Route::get('/admin/kategori_jaketantiuv', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Outfit Outdoor-Jaket Anti UV')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_jaketantiuv', compact('items', 'kategori'));
})->name('admin.kategori_jaketantiuv');

Route::get('/admin/kategori_celanacargo', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Outfit Outdoor-Celana Cargo')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_celanacargo', compact('items', 'kategori'));
})->name('admin.kategori_celanacargo');

Route::get('/admin/kategori_perlengkapantambahan', function () {
    $kategori = KategoriAlat::where('nama_kategori', 'Perlengkapan Tambahan')->first();
    $items = $kategori ? TipeAlat::where('kategori_id', $kategori->id)->get() : collect();

    return view('Admin.kategori_perlengkapantambahan', compact('items', 'kategori'));
})->name('admin.kategori_perlengkapantambahan');

// Route untuk tombol verifikasi pembayaran
Route::post('/admin/pesanan/{id}/verifikasi', [CheckoutController::class, 'verifikasi'])->name('admin.pesanan.verifikasi');

/*
|--------------------------------------------------------------------------
| KERANJANG & CHECKOUT (publik / user)
|--------------------------------------------------------------------------
*/
Route::get('/admin/keranjang', [KeranjangController::class, 'index'])->name('admin.keranjang');
Route::post('/tambah-ke-keranjang/{id}', [KeranjangController::class, 'tambah'])->name('tambah.keranjang');
Route::delete('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');

Route::get('/admin/checkout', [CheckoutController::class, 'checkout'])->name('admin.checkout');
Route::post('/admin/checkout', [CheckoutController::class, 'store'])->name('admin.checkout.store');
Route::post('/admin/order', [CheckoutController::class, 'placeOrder'])->name('admin.order.store');

Route::get('/pesanan/{id}', [CheckoutController::class, 'detail'])->name('pesanan.detail');

// Route untuk mengubah jumlah barang di keranjang
Route::patch('/keranjang/update/{id}', [KeranjangController::class, 'updateQty'])->name('keranjang.updateQty');
// DETAIL PESANAN — PUBLIC (sesuai permintaan)
Route::get('/admin/detailpesanan/{id}', [CheckoutController::class, 'detail'])
    ->name('admin.detailpesanan');

/*
|--------------------------------------------------------------------------
| ADMIN AUTH (login / logout)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('adminn.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('adminn.login.submit');
// Hotfix alias supaya middleware yang expect route('login') tidak error.
// (Bisa dihapus nanti jika Authenticate::redirectTo() diperbaiki)
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');

/*
|--------------------------------------------------------------------------
| ADMIN-PROTECTED ROUTES (hanya admin via guard 'admin')
|--------------------------------------------------------------------------
*/
Route::middleware('auth:admin')->group(function () {

    // CRUD barang (ManajemenAlatController) — hanya admin
    Route::get('/adminn/barang', [ManajemenAlatController::class, 'index'])->name('adminn.barang.index');
    Route::post('/adminn/barang', [ManajemenAlatController::class, 'store'])->name('adminn.barang.store');
    Route::put('/adminn/barang/{id}', [ManajemenAlatController::class, 'update'])->name('adminn.barang.update');
    Route::delete('/adminn/barang/{id}', [ManajemenAlatController::class, 'destroy'])->name('adminn.barang.destroy');
    // detail pesanan di dashboard admin
    Route::get('/adminn/detailpesanan/{id}', [CheckoutController::class, 'detail'])->name('adminn.detailpesanan.khusus');

    // Detail pesanan admin-only jika kalian ingin proteksi (opsional)
    // Route::get('/admin/detailpesanan/{id}', [CheckoutController::class, 'detail'])
    //     ->name('admin.detailpesanan');

});

/*
|--------------------------------------------------------------------------
| OPTIONAL: jika ada route lain yang ingin dipetakan, tambahkan di bawah
|--------------------------------------------------------------------------
*/
Route::get('/api/produk', function () {
    $produk = TipeAlat::all();
    return response()->json($produk);
});

// Route khusus AJAX untuk ambil data pesanan
Route::get('/admin-data-pesanan-ajax', function () {
    try {
        // 👉 FIXED: Tambahkan with('pembayaran') agar data tagihan ikut terbawa
        $pesanan = \App\Models\Pesanan::with('pembayaran')->latest()->get();
        return response()->json($pesanan);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
