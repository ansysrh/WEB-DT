@extends('layouts.app')

@section('title', 'Manajemen Alat Camping')

@section('content')
    <div class="container py-5">

        <h2 class="fw-bold mb-4 text-center">Manajemen Alat Camping & Pesanan</h2>

        <div class="mb-3 text-end">
            <a href="{{ route('User.dashboard') }}" class="btn btn-outline-primary">
                <i class="bi bi-house"></i> Ke Halaman Utama (Publik)
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger text-center">
                <strong>{{ $errors->first() }}</strong>
            </div>
        @endif

        <div class="card mb-5 border-0 shadow">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Tambah Alat Baru</h5>
            </div>

            <div class="card-body">
                <form action="{{ route('adminn.barang.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kategori</label>
                            <select name="kategori_id" class="form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $kat)
                                    <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Alat</label>
                            <input type="text" name="nama_alat" class="form-control" required placeholder="Contoh: Sleeping Bag">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stok" class="form-control" min="0" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Harga Sewa (Rp)</label>
                            <input type="number" name="harga" class="form-control" min="0" required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-semibold">Gambar</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="3" placeholder="Tuliskan deskripsi alat..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-semibold">+ Tambah Alat</button>
                </form>
            </div>
        </div>


        <div class="card mb-5 border-0 shadow">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Daftar Alat Camping (Inventaris)</h5>
            </div>

            <div class="card-body">
                @if ($items->count())
                    <div class="table-responsive">
                        <table class="table-bordered table text-center align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>No</th>
                                    <th>Gambar</th>
                                    <th>Nama Alat</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>Harga Sewa</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>
                                            @if ($item->gambar)
                                                <img src="{{ asset('storage/' . $item->gambar) }}" width="80" class="rounded">
                                            @else
                                                <small class="text-muted">Tidak ada</small>
                                            @endif
                                        </td>
                                        <td>{{ $item->nama_alat }}</td>
                                        <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                                        <td>{{ $item->stok }}</td>
                                        <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-sm mb-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">Edit</button>
                                            
                                            <form action="{{ route('adminn.barang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus item ini?')" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm mb-1">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form action="{{ route('adminn.barang.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit: {{ $item->nama_alat }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row text-start">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Kategori</label>
                                                                <select name="kategori_id" class="form-select" required>
                                                                    @foreach ($kategori as $kat)
                                                                        <option value="{{ $kat->id }}" {{ $kat->id == $item->kategori_id ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Nama Alat</label>
                                                                <input type="text" name="nama_alat" class="form-control" value="{{ $item->nama_alat }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="row text-start">
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Stok</label>
                                                                <input type="number" name="stok" class="form-control" value="{{ $item->stok }}" min="0" required>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Harga Sewa (Rp)</label>
                                                                <input type="number" name="harga" class="form-control" value="{{ $item->harga }}" min="0" required>
                                                            </div>
                                                            <div class="col-md-4 mb-3">
                                                                <label class="form-label">Gambar Baru (opsional)</label>
                                                                <input type="file" name="gambar" class="form-control">
                                                                @if ($item->gambar)
                                                                    <img src="{{ asset('storage/' . $item->gambar) }}" width="80" class="mt-2 rounded">
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 text-start">
                                                            <label class="form-label">Deskripsi</label>
                                                            <textarea name="deskripsi" class="form-control" rows="3">{{ $item->deskripsi }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted text-center">Belum ada alat camping yang ditambahkan.</p>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow mt-5 mb-5">
            <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Pesanan Masuk (Live)</h5>
                <button class="btn btn-sm btn-light text-success fw-bold" onclick="loadDataPesanan()">
                    🔄 Refresh Data
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table text-center align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Tgl Mulai Sewa</th>
                                <th>Total Tagihan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabel-pesanan">
                            <tr>
                                <td colspan="5" class="text-center text-muted">Memuat data pesanan...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        function loadDataPesanan() {
            const tbody = document.getElementById('tabel-pesanan');
            
            tbody.innerHTML = '<tr><td colspan="5" class="text-center text-muted">Mengambil data terbaru...</td></tr>';

            fetch('/admin-data-pesanan-ajax', {
                headers: {
                    'Accept': 'application/json',
                    // Optional: You can inject CSRF here if needed for POST later, but GET is fine without it.
                    'X-Requested-With': 'XMLHttpRequest' 
                }
            })
            .then(response => {
                if (!response.ok) throw new Error("Gagal menarik data");
                return response.json();
            })
            .then(data => {
                tbody.innerHTML = ''; 

                if(data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center">Belum ada pesanan yang masuk.</td></tr>';
                    return;
                }

                data.forEach(order => {
                    let totalTagihan = order.pembayaran ? order.pembayaran.jumlah : 0;
                    let totalRupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalTagihan);

                    let statusBadge = 'bg-warning text-dark'; 
                    if(order.status === 'Selesai' || order.status === 'Lunas' || order.status === 'Disetujui') {
                        statusBadge = 'bg-success';
                    } else if(order.status === 'Dibatalkan' || order.status === 'Ditolak') {
                        statusBadge = 'bg-danger';
                    }

                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><strong>#${order.id}</strong></td>
                        <td>${order.tanggal_mulai || '-'}</td>
                        <td class="text-success fw-bold">${totalRupiah}</td>
                        <td><span class="badge ${statusBadge}">${order.status || 'Pending'}</span></td>
                        <td>
                            <a href="/adminn/detailpesanan/${order.id}" class="btn btn-sm btn-info text-white">
                                Lihat Detail
                            </a>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => {
                console.error("Gagal memuat pesanan:", error);
                tbody.innerHTML = '<tr><td colspan="5" class="text-center text-danger">Gagal terhubung ke database pesanan. Pastikan Route API sudah dibuat di web.php.</td></tr>';
            });
        }

        document.addEventListener('DOMContentLoaded', loadDataPesanan);
        
    </script>
@endsection