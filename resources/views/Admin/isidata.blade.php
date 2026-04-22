<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- Judul halaman --}}
    <title>Form Pemesanan - Adventure</title>

    {{-- File CSS utama --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}" />

    {{-- Styling lokal khusus form (bisa dipindah ke style.css jika ingin) --}}
    <style>
        .form-container {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-title {
            font-size: 1.8rem;
            color: #ffffff;
            margin-bottom: 5px;
        }

        .form-subtitle {
            font-size: 0.95rem;
            color: #e0e0e0;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #f2f2f2;
        }

        .input-field {
            width: 100%;
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(0, 0, 0, 0.2);
            color: white;
            font-size: 1rem;
            box-sizing: border-box;
        }

        .input-field:focus {
            outline: none;
            border-color: #00b894;
            background: rgba(0, 0, 0, 0.3);
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: #00b894;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .submit-btn:hover {
            background-color: #019875;
            transform: translateY(-2px);
        }

        body {
            background: linear-gradient(180deg, #004466 0%, #006688 100%);
            background-attachment: fixed;
            color: white;
            overflow-x: hidden;
            padding: 20px 0;
        }
    </style>
</head>

<body>

    {{-- Tombol kembali ke keranjang (fallback ke route jika session previous_url tidak ada) --}}
    <a href="{{ session('previous_url', route('admin.keranjang')) }}" class="back-btn">
        <span class="arrow">←</span> Kembali Ke Keranjang
    </a>

    <div class="form-container">
        <div class="header">
            <h1 class="form-title">ISI DATA BUAT PEMESANAN</h1>
            <p class="form-subtitle">Lengkapi data dirimu untuk memudahkan proses pemesanan</p>
        </div>

        {{-- Menampilkan error validasi (jika ada) --}}
        @if ($errors->any())
            <div class="errors" style="background:#ff4d4d; padding:10px; border-radius:8px; margin-bottom:15px;">
                <ul>
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Flash error / success --}}
        @if (session('error'))
            <div class="error" style="background:#ff6b6b; padding:10px; border-radius:8px; margin-bottom:15px;">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="success" style="background:#00b894; padding:10px; border-radius:8px; margin-bottom:15px;">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORM: kirim data pemesanan ke route checkout --}}
        <form action="{{ route('admin.checkout.store') }}" method="POST">
            @csrf

            {{-- Nama lengkap --}}
            <div class="form-group">
                <label for="nama" class="label">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" class="input-field"
                    placeholder="Masukkan nama lengkap Anda" required>
            </div>

            {{-- Nomor WhatsApp --}}
            <div class="form-group">
                <label for="whatsapp" class="label">Nomor WhatsApp</label>
                <input type="tel" id="whatsapp" name="whatsapp" class="input-field"
                    placeholder="Masukkan nomor WhatsApp Anda" required>
            </div>

            {{-- Email --}}
            <div class="form-group">
                <label for="email" class="label">Email</label>
                <input type="email" id="email" name="email" class="input-field"
                    placeholder="Masukkan email Anda" required>
            </div>

            {{-- Lama peminjaman (hari) --}}
            <div class="form-group">
                <label for="hari" class="label">Berapa hari peminjaman?</label>
                <input type="number" id="hari" name="hari" class="input-field"
                    placeholder="Masukkan jumlah hari" min="1" required>
            </div>

            {{-- Tanggal mulai --}}
            <div class="form-group">
                <label for="tanggal_mulai" class="label">Tanggal Mulai Sewa</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="input-field" required>
            </div>

            {{-- Tanggal kembali dihitung otomatis (readonly) --}}
            <div class="form-group">
                <label for="tanggal_kembali" class="label">Tanggal Kembali (otomatis)</label>
                <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="input-field" readonly>
            </div>

            <button type="submit" class="submit-btn">Submit</button>
        </form>

        {{-- JavaScript kecil untuk menghitung tanggal kembali --}}
        <script>
            (function() {
                // Ambil elemen hanya kalau ada di DOM — menghindari error jika script dipakai pada layout lain
                const hariEl = document.getElementById('hari');
                const startEl = document.getElementById('tanggal_mulai');
                const outEl = document.getElementById('tanggal_kembali');

                if (!hariEl || !startEl || !outEl) return;

                // hitung tanggal kembali = tanggal_mulai + hari
                function computeReturnDate() {
                    const hari = parseInt(hariEl.value || 0, 10);
                    const startVal = startEl.value;

                    if (!startVal || !hari || hari < 1) {
                        outEl.value = '';
                        return;
                    }

                    // Buat objek Date dari string yyyy-mm-dd (gunakan T00:00:00 agar konsisten)
                    const startDate = new Date(startVal + 'T00:00:00');

                    // Tambah jumlah hari (mis. hari=1 berarti kembali keesokan hari)
                    startDate.setDate(startDate.getDate() + hari);

                    // Format ke yyyy-mm-dd untuk input[type=date]
                    const year = startDate.getFullYear();
                    const month = String(startDate.getMonth() + 1).padStart(2, '0');
                    const day = String(startDate.getDate()).padStart(2, '0');
                    outEl.value = `${year}-${month}-${day}`;
                }

                // Pasang event listener
                hariEl.addEventListener('input', computeReturnDate);
                startEl.addEventListener('change', computeReturnDate);

                // Inisialisasi kemungkinan nilai default
                computeReturnDate();
            })();
        </script>

    </div>

</body>

</html>
