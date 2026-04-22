<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Judul halaman (tampil di tab browser) --}}
    <title>Cara Sewa | DT Adventure</title>

    {{-- Stylesheet utama --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

    {{-- HEADER: logo + navigasi utama --}}
    <header>
        <div class="header-container">

            {{-- Logo (dari folder public) --}}
            <div class="logo-container">
                <img src="{{ asset('logo.png') }}" alt="DT Adventure Logo" class="logo">
            </div>

            {{-- Navigasi: gunakan named routes supaya mudah maintenance --}}
            <nav>
                <a href="{{ route('User.dashboard') }}">BERANDA</a>
                <a href="{{ route('admin.pricelist') }}">PRICELIST</a>
                <a href="{{ route('admin.carasewa') }}">CARA SEWA</a>
                <a href="{{ route('admin.hubungi') }}">HUBUNGI KAMI</a>
                <a href="{{ route('adminn.login') }}">ADMIN</a>
            </nav>
        </div>
    </header>

    {{-- SECTION: judul & deskripsi singkat --}}
    <section class="page-header">
        <h1>Cara Penyewaan</h1>
        <p>DT Adventure memberikan dua metode penyewaan perlengkapan outdoor, kamu bisa pilih sesuai kebutuhanmu.</p>
    </section>

    {{-- SECTION: penjelasan cara sewa + ilustrasi --}}
    <section class="cara-sewa">
        <div class="cara-content">

            {{-- Daftar langkah: Offline & Online --}}
            <ol>
                <li>
                    <strong>Sewa Offline (Datang Langsung ke Toko)</strong><br>
                    {{-- Penjelasan singkat proses offline --}}
                    Kamu bisa datang langsung ke toko kami untuk melihat pilihan perlengkapan secara langsung. Setelah
                    menentukan barang yang ingin disewa, cukup isi formulir penyewaan di tempat dan lakukan pembayaran
                    sesuai ketentuan.
                </li>

                <li>
                    <strong>Sewa Online (Melalui Website / WhatsApp)</strong><br>
                    {{-- Penjelasan singkat proses online --}}
                    Untuk kemudahan, kamu juga dapat melakukan pemesanan melalui website atau chat WhatsApp resmi DT
                    Adventure. Pilih barang yang diinginkan dari halaman <em>Pricelist</em>, isi form pemesanan,
                    kemudian lakukan konfirmasi lewat WhatsApp.
                </li>
            </ol>

            {{-- Catatan penting untuk penyewa --}}
            <p class="catatan">
                <strong>Catatan:</strong><br>
                - Harap membawa kartu identitas saat pengambilan barang.<br>
                - Untuk sewa online, proses pengambilan, konfirmasi pengembalian, serta pembayaran dapat dilakukan
                setelah barang siap diambil di toko.<br>
                - Barang wajib dikembalikan sesuai jadwal agar tidak dikenakan denda keterlambatan.
            </p>
        </div>

        {{-- Ilustrasi / gambar pendukung --}}
        <div class="cara-img">
            <img src="{{ asset('carasewa.png') }}" alt="Cara Sewa DT Adventure">
        </div>
    </section>

    {{-- FOOTER --}}
    <footer>
        <p>&copy; 2025 DT Adventure. All rights reserved.</p>
    </footer>

</body>

</html>
