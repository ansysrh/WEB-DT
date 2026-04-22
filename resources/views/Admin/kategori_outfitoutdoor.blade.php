<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DT Adventure - Outfit Outdoor</title>
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

    {{-- SECTION: Kategori Outfit Outdoor --}}
    <section class="produk-container">

        {{-- Header kategori --}}
        <div class="produk-header">
            <div>
                <h2>Outfit Outdoor</h2>
                <p>Lengkapi gaya petualanganmu dengan pakaian outdoor yang nyaman dan aman.</p>
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

        {{-- GRID: daftar sub-kategori sebagai card-link --}}
        <div class="produk-grid">

            <a href="{{ route('admin.kategori_sepatuhiking') }}" class="card-link">
                <div class="product-card">
                    <img src="{{ asset('sepatuhiking.jpg') }}" alt="Sepatu Hiking">
                    <p>Sepatu Hiking</p>
                </div>
            </a>

            <a href="{{ route('admin.kategori_jaketgorpcore') }}" class="card-link">
                <div class="product-card">
                    <img src="{{ asset('jaketgorpcore.jpg') }}" alt="Jaket Gorpcore">
                    <p>Jaket Gorpcore</p>
                </div>
            </a>

            <a href="{{ route('admin.kategori_jaketgelembung') }}" class="card-link">
                <div class="product-card">
                    <img src="{{ asset('jaketgelembung.jpg') }}" alt="Jaket Gelembung">
                    <p>Jaket Gelembung</p>
                </div>
            </a>

            <a href="{{ route('admin.kategori_jaketantiuv') }}" class="card-link">
                <div class="product-card">
                    <img src="{{ asset('JAKETANTIUV.jpg') }}" alt="Jaket Anti UV">
                    <p>Jaket Anti UV</p>
                </div>
            </a>

            <a href="{{ route('admin.kategori_celanacargo') }}" class="card-link">
                <div class="product-card">
                    <img src="{{ asset('celanacargo.jpg') }}" alt="Celana Cargo">
                    <p>Celana Cargo</p>
                </div>
            </a>

        </div>
    </section>

</body>
</html>