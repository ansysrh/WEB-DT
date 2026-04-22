<?php

namespace App\Http\Controllers;

use App\Models\TipeAlat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ManajemenAlatController extends Controller
{
    public function index()
    {
        $kategori = \App\Models\KategoriAlat::all();
        $items = TipeAlat::with('kategori')->latest()->get();

        return view('adminn.barang', compact('kategori', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:kategori_alat,id',
            'nama_alat'   => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = $request->hasFile('gambar')
            ? $request->file('gambar')->store('gambar_alat', 'public')
            : null;

        // PAKAI ARRAY DULU BIAR KELIHATAN JELAS
        $data = [
            'kategori_id' => $request->kategori_id,
            'nama_alat'   => $request->nama_alat,
            'stok'        => $request->stok,
            'harga'       => $request->harga,
            'deskripsi'   => $request->deskripsi,
            'gambar'      => $path,
        ];

        // DEBUG (hapus kalau sudah aman)
        // dd($data);

        TipeAlat::create($data);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $item = TipeAlat::findOrFail($id);

        $request->validate([
            'kategori_id' => 'required|exists:kategori_alat,id',
            'nama_alat'   => 'required|string|max:255',
            'stok'        => 'required|integer|min:0',
            'harga'       => 'required|numeric|min:0',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'deskripsi'   => 'nullable|string',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('gambar_alat', 'public');

            if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
                Storage::disk('public')->delete($item->gambar);
            }

            $item->gambar = $path;
        }

        $item->kategori_id = $request->kategori_id;
        $item->nama_alat   = $request->nama_alat;
        $item->stok        = $request->stok;
        $item->harga       = $request->harga;
        $item->deskripsi   = $request->deskripsi;

        $item->save();

        return redirect()->route('adminn.barang.index')
            ->with('success', 'Data alat berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $item = TipeAlat::findOrFail($id);

        if ($item->gambar && Storage::disk('public')->exists($item->gambar)) {
            Storage::disk('public')->delete($item->gambar);
        }

        $item->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus!');
    }
}