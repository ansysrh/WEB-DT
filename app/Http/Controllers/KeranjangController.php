<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipeAlat;
use App\Models\Keranjang;

class KeranjangController extends Controller
{
    public function index(Request $request)
    {
        $sessionId = $request->session()->getId();
        $cart = Keranjang::where('session_id', $sessionId)->get();
        $total = $cart->sum(fn($i) => $i->harga * $i->jumlah);

        return view('Admin.keranjang', compact('cart', 'total'));
    }

    /**
     * Menambahkan alat ke dalam keranjang dengan validasi stok
     */
    public function tambah(Request $request, $id)
    {
        $sessionId = $request->session()->getId();
        $item = TipeAlat::findOrFail($id);

        // 1. Validasi: Cek apakah stok di database masih ada
        if ($item->stok <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, stok barang ini sudah habis.'
            ], 422);
        }

        $existing = Keranjang::where('session_id', $sessionId)
            ->where('tipe_alat_id', $item->id)
            ->first();

        if ($existing) {
            // 2. Validasi: Cek apakah penambahan jumlah melebihi stok yang ada
            if ($existing->jumlah + 1 > $item->stok) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambah. Jumlah di keranjang sudah mencapai batas stok tersedia (' . $item->stok . ').'
                ], 422);
            }
            $existing->increment('jumlah', 1);
        } else {
            Keranjang::create([
                'session_id'   => $sessionId, 
                'tipe_alat_id' => $item->id,
                'nama_alat'    => $item->nama_alat,
                'gambar'       => $item->gambar,
                'harga'        => $item->harga,
                'jumlah'       => 1,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil ditambahkan ke keranjang'
        ]);
    }

    /**
     * Update jumlah via AJAX dengan validasi stok
     */ 
    public function updateQty(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $itemKeranjang = Keranjang::find($id);
        if (!$itemKeranjang) {
            return response()->json(['success' => false, 'pesan' => 'Item tidak ditemukan'], 404);
        }

        // Ambil data asli alat dari database untuk cek stok terbaru
        $alat = TipeAlat::find($itemKeranjang->tipe_alat_id);

        // 3. Validasi: Cek apakah jumlah baru melebihi stok database
        if ($request->jumlah > $alat->stok) {
            return response()->json([
                'success' => false, 
                'pesan' => 'Jumlah melebihi stok tersedia. Stok saat ini: ' . $alat->stok
            ], 422);
        }

        $itemKeranjang->jumlah = $request->jumlah;
        $itemKeranjang->save();

        return response()->json(['success' => true, 'pesan' => 'Jumlah berhasil diupdate']);
    }

    public function hapus(Request $request, $id)
    {
        $sessionId = $request->session()->getId();
        $item = Keranjang::findOrFail($id);

        if ($item->session_id !== $sessionId) {
            abort(403, 'Aksi tidak diperbolehkan.');
        }

        $item->delete();

        return redirect()->route('admin.keranjang')
            ->with('success', 'Item berhasil dihapus!');
    }

    public function clear(Request $request)
    {
        $sessionId = $request->session()->getId();
        Keranjang::where('session_id', $sessionId)->delete();

        return back()->with('success', 'Keranjang dibersihkan.');
    }
}