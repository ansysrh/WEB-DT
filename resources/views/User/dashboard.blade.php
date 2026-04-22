<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Title halaman pada tab browser --}}
    <title>DT Adventure</title>

    {{-- Memuat file CSS dari public/style.css dengan versioning manual agar cache browser ter-reset --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}?v=2">
</head>

<body>

    {{-- HEADER: berisi logo dan navigasi utama --}}
    <header>
        <div class="header-container">

            {{-- Menampilkan logo utama dari folder public --}}
            <div class="logo-container">
                <img src="{{ asset('logo.png') }}" alt="DT Adventure Logo" class="logo">
            </div>

            {{-- Navigasi menggunakan named route Laravel --}}
            <nav>
                <a href="{{ route('User.dashboard') }}">BERANDA</a>
                <a href="{{ route('admin.pricelist') }}">PRICELIST</a>
                <a href="{{ route('admin.carasewa') }}">CARA SEWA</a>
                <a href="{{ route('admin.hubungi') }}">HUBUNGI KAMI</a>
                <a href="{{ route('adminn.login') }}">ADMIN</a>
            </nav>

        </div>
    </header>

    {{-- HERO SECTION: bagian utama yang berfungsi sebagai pengenalan halaman --}}
    <section class="hero">
        <div class="hero-content">

            <h1>HI, PETUALANG!</h1>

            {{-- Deskripsi singkat sebagai kalimat pembuka --}}
            <p>
                DT Adventure hadir dengan perlengkapan mendaki terbaik, lengkap dengan berbagai pilihan ukuran dan warna
                untuk kenyamanan aktivitas alam kamu.
            </p>

            <p>Yuk, Temukan perlengkapan yang cocok untukmu!</p>

            {{-- Tombol CTA menuju halaman pricelist --}}
            <button onclick="window.location='{{ route('admin.pricelist') }}'">
                Sewa Sekarang
            </button>

        </div>
    </section>

    {{-- KATEGORI: menu shortcut ke halaman penting --}}
    <section class="kategori">
        <h2>KATEGORI</h2>

        <div class="kategori-grid">

            {{-- Link ke halaman daftar harga --}}
            <a href="{{ route('admin.pricelist') }}" class="kategori-item">
                <img src="https://img.icons8.com/ios-filled/100/ffffff/price-tag.png">
                <p>Pricelist</p>
            </a>

            {{-- Link ke halaman cara penyewaan --}}
            <a href="{{ route('admin.carasewa') }}" class="kategori-item">
                <img src="https://img.icons8.com/ios-filled/100/ffffff/open-book--v1.png">
                <p>Cara Penyewaan</p>
            </a>

            {{-- Link ke halaman syarat & ketentuan --}}
            <a href="{{ route('admin.syarat') }}" class="kategori-item">
                <img src="https://img.icons8.com/ios-filled/100/ffffff/agreement.png">
                <p>Syarat & Ketentuan</p>
            </a>

            {{-- Link ke halaman data pemesanan --}}
            <a href="{{ route('admin.keranjang') }}" class="kategori-item">
                <img src="https://img.icons8.com/ios-filled/100/ffffff/shopping-bag.png">
                <p>Data Pemesanan</p>
            </a>

        </div>
    </section>

    {{-- QUOTES: menampilkan kutipan motivasi --}}
    <section class="quotes">
        <h2>QUOTES</h2>

        <div class="quotes-grid">
            <div class="quote-box">
                “Gunung mengajarkan kita arti dari langkah kecil menuju puncak tertinggi.”
            </div>

            <div class="quote-box">
                “Petualangan sejati dimulai ketika kamu keluar dari zona nyamanmu.”
            </div>

            <div class="quote-box">
                “Setiap perjalanan adalah kisah baru yang menunggu untuk diceritakan.”
            </div>
        </div>
    </section>

    {{-- ABOUT: menjelaskan profil DT Adventure secara singkat --}}
    <section class="about">
        <h2>DT Adventure</h2>

        <p>Teman Setia Aktivitas Outdoor mu</p>

        {{-- Penjelasan perusahaan atau brand --}}
        <p>
            DT Adventure menyediakan perlengkapan outdoor lengkap untuk menemani petualanganmu.
            Kami berkomitmen memberikan pengalaman terbaik bagi setiap pelanggan, dengan produk berkualitas
            dan layanan terpercaya.
        </p>
    </section>

</body>

</html>
