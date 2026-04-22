<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {{-- Judul halaman --}}
    <title>DT Adventure</title>

    {{-- File CSS utama --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>

    {{-- HEADER: logo + navigasi utama --}}
    <header>
        <div class="header-container">

            {{-- Logo toko --}}
            <div class="logo-container">
                <img src="{{ asset('logo.png') }}" alt="DT Adventure Logo" class="logo">
            </div>

            {{-- Menu navigasi --}}
            <nav>
                <a href="{{ route('User.dashboard') }}">BERANDA</a>
                <a href="{{ route('admin.pricelist') }}">PRICELIST</a>
                <a href="{{ route('admin.carasewa') }}">CARA SEWA</a>
                <a href="{{ route('admin.hubungi') }}">HUBUNGI KAMI</a>
                <a href="{{ route('adminn.login') }}">ADMIN</a>
            </nav>
        </div>
    </header>

    {{-- Header judul halaman --}}
    <section class="page-header">
        <h1>Hubungi Kami</h1>
    </section>

    {{-- SECTION: informasi kontak --}}
    <section class="contact-section">

        {{-- Kolom informasi utama --}}
        <div class="contact-info">

            {{-- Alamat toko --}}
            <p>
                <strong>🏠 Alamat Toko:</strong><br>
                Dusun Sepatan RT 09 RW 05 No. 8, Kecamatan Rawang, Kabupaten Pekalongann<br>
                <a href="https://maps.app.goo.gl/V4xexuZGeQUpcFpg7" target="_blank" class="link">
                    Lihat di Google Maps
                </a>
            </p>

            {{-- Nomor WA / telepon --}}
            <p>
                <strong>📞 Nomor WhatsApp / Telepon Admin:</strong><br>
                <a href="https://wa.me/6288232778958" target="_blank" class="link">
                    +62 812-3456-7890
                </a>
            </p>

            {{-- Jam operasional --}}
            <p>
                <strong>🕒 Jam Operasional:</strong><br>
                Senin – Sabtu : 08.00 – 20.00 WIB<br>
                Minggu : 09.00 – 15.00 WIB
            </p>

            {{-- Media sosial --}}
            <p>
                <strong>📱 Media Sosial:</strong><br>
                Instagram:
                <a href="https://instagram.com/dtadventure" target="_blank" class="link">@dtadventure</a><br>
                TikTok:
                <a href="https://tiktok.com/@dtadventure" target="_blank" class="link">@dtadventure</a>
            </p>

            {{-- Catatan penutup --}}
            <p class="catatan">
                Jika ada pertanyaan atau ingin mendapatkan informasi penyewaan lebih lengkap,
                silakan hubungi kami melalui salah satu kontak di atas. Kami siap membantu!
            </p>
        </div>

        {{-- Gambar pendukung --}}
        <div class="contact-img">
            <img src="{{ asset('syarat.jpg') }}" alt="Hubungi Kami">
        </div>

    </section>

    {{-- Footer --}}
    <footer>
        <p>&copy; 2025 DT Adventure. All rights reserved.</p>
    </footer>

</body>

</html>
