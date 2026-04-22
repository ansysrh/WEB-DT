<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Admin - Detail Pesanan #{{ $pesanan->id }}</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <style>
        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial;
            background: #f4f6f8;
            color: #222;
            margin: 0;
            padding: 24px;
        }

        .nota {
            max-width: 880px;
            margin: 0 auto;
            background: #fff;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 8px 30px rgba(10, 20, 30, 0.06);
        }

        .top {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 18px;
        }

        .brand h1 {
            margin: 0;
            font-size: 1.25rem;
            color: #004466;
        }

        .meta {
            text-align: right;
            font-size: 0.9rem;
            color: #555;
        }

        .section {
            margin-top: 18px;
        }

        .info-grid {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            background: #f8fafc;
            padding: 12px 14px;
            border-radius: 8px;
            flex: 1 1 220px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th,
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #eee;
            font-size: 0.95rem;
        }

        th {
            background: #fafafa;
            font-weight: 600;
        }

        .totals {
            margin-top: 14px;
            display: flex;
            justify-content: flex-end;
        }

        .totals .box {
            width: 360px;
            background: #fafafa;
            padding: 14px;
            border-radius: 8px;
        }

        .line {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
        }

        .line.final {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .actions {
            margin-top: 25px;
            display: flex;
            gap: 12px;
            justify-content: flex-start;
        }

        .btn {
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .btn-print {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-print:hover {
            background: #cbd5e1;
        }

        /* Tombol Oke Baru */
        .btn-oke {
            background: #004466;
            color: #fff;
        }

        .btn-oke:hover {
            background: #00334d;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .actions {
                display: none;
            }

            .nota {
                box-shadow: none;
                border-radius: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="nota">

        {{-- Notifikasi Sukses / Error untuk Admin --}}
        @if (session('success'))
            <div style="background:#28a745; color:white; padding:10px 15px; border-radius:8px; margin-bottom:15px; font-weight:bold;">
                ✅ {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div style="background:#dc3545; color:white; padding:10px 15px; border-radius:8px; margin-bottom:15px; font-weight:bold;">
                ❌ {{ session('error') }}
            </div>
        @endif

        {{-- HEADER: nama brand & metadata nota --}}
        <div class="top">
            <div class="brand">
                <h1>Panel Admin DT Adventure</h1>
                <div class="muted">
                    Detail Pesanan Masuk
                </div>
            </div>

            {{-- Informasi nota: tanggal, status --}}
            <div class="meta">
                <div><strong>Pesanan #{{ $pesanan->id }}</strong></div>
                <div class="muted">Dibuat: {{ \Carbon\Carbon::parse($pesanan->created_at)->format('d M Y H:i') }}</div>
                <div class="muted" style="color: #d97706; font-weight:bold; margin-top: 4px;">Status: {{ $pesanan->status ?? 'Menunggu Konfirmasi' }}</div>
            </div>
        </div>

        {{-- SECTION: data pemesan & metode pembayaran --}}
        <div class="section info-grid">

            {{-- Data pemesan --}}
            <div class="card">
                <strong>Data Penyewa</strong>
                <div class="muted" style="margin-top:6px;">
                    Nama: <strong>{{ $pesanan->nama }}</strong> <br>
                    WhatsApp: {{ $pesanan->whatsapp }} <br>
                    Email: {{ $pesanan->email ?? '-' }} <br>
                    Durasi: {{ $pesanan->hari }} hari <br>
                    Tgl Sewa: {{ \Carbon\Carbon::parse($pesanan->tanggal_mulai)->format('d M Y') }} s.d {{ \Carbon\Carbon::parse($pesanan->tanggal_kembali)->format('d M Y') }}
                </div>
            </div>

            {{-- Metode pembayaran --}}
            <div class="card">
                <strong>Metode Pembayaran</strong>

                @php
                    // Ambil data pembayaran dari relasi pesanan
                    $pembayaran = $pesanan->pembayaran; 
                    $metode = $pembayaran->metode_pembayaran ?? ($pesanan->metode_pembayaran ?? null);
                @endphp

                <div class="muted" style="margin-top:6px;">
                    @if ($metode === 'Cash')
                        💵 <strong>Cash</strong> — Bayar di lokasi.
                    @elseif ($metode === 'QRIS')
                        📱 <strong>QRIS</strong>

                        {{-- Jika ada bukti pembayaran, tampilkan --}}
                        @if ($pembayaran && !empty($pembayaran->bukti))
                            <div style="margin-top:10px;">
                                <a href="{{ asset('storage/' . $pembayaran->bukti) }}" target="_blank" title="Klik untuk memperbesar">
                                    <img src="{{ asset('storage/' . $pembayaran->bukti) }}" alt="Bukti Pembayaran"
                                        width="150" style="border-radius:8px; border: 1px solid #ccc; cursor: pointer;">
                                </a>
                            </div>
                            <div class="muted" style="font-size: 0.8rem;">(Klik gambar untuk memperbesar)</div>
                            <div class="muted" style="margin-top: 5px;">Kode: {{ $pembayaran->kode_pembayaran }}</div>

                            {{-- 🔥 FITUR VERIFIKASI ADMIN --}}
                            @if ($pesanan->status === 'Menunggu Verifikasi')
                                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd;">
                                    <strong style="display:block; margin-bottom: 8px;">Aksi Admin:</strong>
                                    <form action="{{ route('admin.pesanan.verifikasi', $pesanan->id) }}" method="POST" style="display: flex; gap: 10px;">
                                        @csrf
                                        <button type="submit" name="aksi" value="Setujui" class="btn btn-success" style="background-color: #28a745; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; width: 100%;">
                                            ✅ Setujui
                                        </button>
                                        
                                        <button type="submit" name="aksi" value="Tolak" class="btn btn-danger" onclick="return confirm('Yakin ingin menolak pembayaran ini?')" style="background-color: #dc3545; color: white; border: none; padding: 8px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; width: 100%;">
                                            ❌ Tolak
                                        </button>
                                    </form>
                                </div>
                            @endif

                        @else
                            <div class="muted" style="color: red; margin-top: 8px;">
                                ⚠️ User belum / gagal mengupload bukti bayar.
                            </div>
                        @endif
                    @else
                        <em>Belum memilih metode pembayaran</em>
                    @endif
                </div>
            </div>

        </div>

        {{-- SECTION: tabel barang --}}
        <div class="section">
            <strong>Rincian Barang yang Disewa</strong>

            <table>
                <thead>
                    <tr>
                        <th style="text-align: left;">Nama Barang</th>
                        <th style="text-align: left;">Harga / hari</th>
                        <th style="text-align: center;">Jumlah</th>
                        <th style="text-align: right;">Subtotal / hari</th>
                        <th style="text-align: right;">Total (x {{ $pesanan->hari }} hari)</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        // Ambil daftar item dari database (lewat relasi)
                        $lines = $pesanan->items;

                        $subtotalPerDay = $lines->sum(function ($item) {
                            return $item->subtotal ?? ($item->harga * $item->jumlah);
                        });

                        $total = $subtotalPerDay * max(1, $pesanan->hari);
                    @endphp

                    @forelse ($lines as $item)
                        @php
                            $perDay = $item->subtotal ?? ($item->harga * $item->jumlah);
                            $lineTotal = $perDay * $pesanan->hari;
                        @endphp

                        <tr>
                            <td>{{ $item->nama_alat }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td style="text-align: center;">{{ $item->jumlah }}</td>
                            <td style="text-align: right;">Rp {{ number_format($perDay, 0, ',', '.') }}</td>
                            <td style="text-align: right; font-weight: bold;">Rp {{ number_format($lineTotal, 0, ',', '.') }}</td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="muted text-center" style="text-align: center; padding: 20px;">
                                Rincian barang kosong.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- SECTION: total pembayaran --}}
        <div class="totals">
            <div class="box">
                <div class="line">
                    <div class="muted">Subtotal (per hari)</div>
                    <div>Rp {{ number_format($subtotalPerDay, 0, ',', '.') }}</div>
                </div>

                <div class="line">
                    <div class="muted">Durasi</div>
                    <div>{{ $pesanan->hari }} hari</div>
                </div>

                <div class="line final">
                    <div>Total Tagihan</div>
                    <div style="color: #004466;">Rp {{ number_format($total, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- Tombol aksi (Khusus Admin) --}}
        <div class="actions">
            {{-- Tombol Oke untuk kembali ke Dashboard Admin --}}
            <a href="{{ route('adminn.barang.index') }}" class="btn btn-oke">✅ Oke</a>
            
            <button type="button" class="btn btn-print" onclick="window.print()">🖨️ Print Data</button>
        </div>
        
    </div>
</body>

</html>