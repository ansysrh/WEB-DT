<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT Adventure - Katalog Alat</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

    {{-- HEADER --}}
    <header>
        <div class="header-container">
            <div class="logo-container">
                <img src="{{ asset('logo.png') }}" alt="DT Adventure Logo" class="logo">
            </div>
            <nav>
                <a href="{{ route('User.dashboard') }}">BERANDA</a>
                <a href="{{ route('admin.pricelist') }}">PRICELIST</a>
                <a href="{{ route('admin.carasewa') }}">CARA SEWA</a>
                <a href="{{ route('admin.hubungi') }}">HUBUNGI KAMI</a>
                <a href="{{ route('adminn.login') }}">ADMIN</a>
            </nav>
        </div>
    </header>

    {{-- SECTION PRODUK --}}
    <section class="produk-container">

        <div class="produk-header">
            <div>
                <h2>Kacamata Gunung</h2>
                <p>Melindungi mata dari sinar matahari dan debu saat hiking.</p>
            </div>

            {{-- IKON KERANJANG DINAMIS --}}
            <a href="{{ route('admin.keranjang') }}" class="cart-icon-link">🛒
                @php
                    $sessionId = request()->session()->getId();
                    $cartCount = \App\Models\Keranjang::where('session_id', $sessionId)->sum('jumlah');
                @endphp
                <span class="cart-badge">{{ $cartCount }}</span>
            </a>
        </div>

        {{-- GRID PRODUK --}}
        <div class="produk-grid">
            @forelse($items as $item)
                <div class="produk-card">
                    <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_alat }}" width="100">
                    <div class="produk-info">
                        <h3>{{ $item->nama_alat }}</h3>
                        <p>{{ $item->deskripsi }}</p>
                        <div class="stok-info">
                            <small>Sisa Stok: <strong>{{ $item->stok }}</strong></small>
                        </div>
                        <div class="harga">
                            Rp {{ number_format($item->harga, 0, ',', '.') }} / hari
                        </div>

                        {{-- LOGIKA TOMBOL BERDASARKAN STOK --}}
                        @if($item->stok > 0)
                            <button class="tambah-btn" onclick="tambahKeranjang({{ $item->id }})">
                                Tambah
                            </button>
                        @else
                            <button class="tambah-btn btn-habis" disabled style="background-color: #ccc; cursor: not-allowed;">
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-center" style="grid-column: 1 / -1; margin-top: 20px;">
                    Belum ada alat pada kategori ini.
                </p>
            @endforelse
        </div>

    </section>

    {{-- JAVASCRIPT AJAX --}}
    <script>
    function tambahKeranjang(id) {
        fetch(`/tambah-ke-keranjang/${id}`, { 
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(async res => {
            const data = await res.json();
            
            // Jika server mengirimkan error (stok habis/melebihi batas)
            if (!res.ok || !data.success) {
                throw new Error(data.message || "Gagal menambahkan ke keranjang.");
            }
            return data;
        })
        .then(data => {
            if(data.success) {
                updateCartBadge();
                alert(data.message); // Menampilkan pesan sukses dari Controller
            }
        })
        .catch(err => {
            console.error("Terjadi kesalahan:", err);
            alert(err.message); // Menampilkan pesan error dari Controller (misal: "Stok habis")
        });
    }

    function updateCartBadge() {
        fetch('/cart/count')
        .then(res => res.json())
        .then(data => {
            const badge = document.querySelector('.cart-badge');
            if (badge) badge.innerText = data.count;
        })
        .catch(err => console.error("Gagal update badge:", err));
    }
    </script>

</body>
</html>