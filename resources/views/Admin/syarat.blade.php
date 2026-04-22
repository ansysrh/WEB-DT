<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Judul halaman yang tampil di tab browser --}}
    <title>DT Adventure - Syarat & Ketentuan</title>

    {{-- Memuat file CSS dari folder public (asset helper Laravel) --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

    {{-- HEADER: logo dan navigasi utama --}}
    <header>
        <div class="header-container">
            <div class="logo-container">
                {{-- Logo situs, ambil dari public/logo.png --}}
                <img src="{{ asset('logo.png') }}" alt="DT Adventure Logo" class="logo">
            </div>

            {{-- Menu navigasi mengarah ke named route Laravel --}}
            <nav>
                <a href="{{ route('User.dashboard') }}">BERANDA</a>
                <a href="{{ route('admin.pricelist') }}">PRICELIST</a>
                <a href="{{ route('admin.carasewa') }}">CARA SEWA</a>
                <a href="{{ route('admin.hubungi') }}">HUBUNGI KAMI</a>
                <a href="{{ route('adminn.login') }}">LOGIN</a>
            </nav>
        </div>
    </header>

    {{-- PAGE HEADER: judul halaman --}}
    <section class="page-header">
        <h1>Syarat & Ketentuan</h1>
    </section>

    {{-- MAIN SECTION: berisi syarat, aturan pengembalian, dan ilustrasi gambar --}}
    <section class="contact-section">
        <div class="contact-info">

            {{-- Bagian syarat umum --}}
            <p>
                <strong>Syarat & Ketentuan di DT Adventure:</strong><br>

                Wajib meninggalkan kartu identitas asli (KTP, SIM, Kartu Pelajar, dll).<br><br>

                Booking alat minimal dengan DP 25%.<br><br>

                Pengambilan alat minimal membayar uang muka 75%.<br><br>

                Keterlambatan pengembalian alat dikenakan biaya tambahan sesuai waktu keterlambatan.<br><br>

                Jika terjadi kerusakan, penyewa dikenakan biaya ganti rugi atau mengganti alat sesuai kondisi saat
                menyewa.<br><br>

                Jika alat yang disewakan tidak berfungsi, penyewa berhak mendapatkan potongan harga.
            </p>

            {{-- Bagian aturan pengembalian --}}
            <p>
                <strong>Aturan Pengembalian :</strong><br><br>

                Waktu pengembalian harus sama dengan waktu pengambilan.<br><br>

                Keterlambatan kurang dari 5 jam → tidak dikenakan biaya tambahan.<br><br>

                Keterlambatan 5–10 jam → dikenakan biaya tambahan sebesar ½ (setengah) harga sewa.<br><br>

                Keterlambatan lebih dari 10 jam → dikenakan biaya tambahan sebesar 1 hari (24 jam) harga sewa.
            </p>

            {{-- Catatan singkat --}}
            <p class="catatan">
                Perhitungan sewa berlaku per 24 jam (1 hari).
            </p>
        </div>

        {{-- Ilustrasi: gambar syarat --}}
        <div class="contact-img">
            <img src="{{ asset('syarat.jpg') }}" alt="Syarat & Ketentuan">
        </div>
    </section>

    {{-- FOOTER: informasi hak cipta --}}
    <footer>
        <p>&copy; 2025 DT Adventure. All rights reserved.</p>
    </footer>

</body>

</html>
