<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    {{-- Judul nota memakai ID pesanan --}}
    <title>Nota - Detail Pesanan #{{ $pesanan->id }}</title>

    {{-- File CSS utama --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    {{-- Styling khusus untuk layout nota --}}
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
            margin-top: 18px;
            display: flex;
            gap: 10px;
        }


        .btn {
            padding: 10px 14px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-print {
            background: #0066aa;
            color: #fff;
            border: none;
        }

        .btn-back {
            background: transparent;
            color: #0066aa;
            border: 1px solid #dbe9f6;
            padding: 10px 14px;
        }

        .btn-whatsapp {
            background-color: #25D366;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            border: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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

        {{-- HEADER: nama brand & metadata nota --}}
        <div class="top">
            <div class="brand">
                <h1>DT Adventure</h1>
                <div class="muted">
                    Alamat: Dusun Sepatan RT 09 RW 05 No. 8, Rawang, Pekalongan • Telp: 0812-3456-7890
                </div>
            </div>

            {{-- Informasi nota: tanggal, status --}}
            <div class="meta">
                <div><strong>Nota #{{ $pesanan->id }}</strong></div>
                <div class="muted">Tanggal: {{ now()->format('d M Y H:i') }}</div>
                <div class="muted" style="color: #d97706; font-weight:bold;">Status: {{ $pesanan->status ?? 'Menunggu Konfirmasi' }}</div>
            </div>
        </div>

        {{-- SECTION: data pemesan & metode pembayaran --}}
        <div class="section info-grid">

            {{-- Data pemesan --}}
            <div class="card">
                <strong>Data Pemesan</strong>
                <div class="muted" style="margin-top:6px;">
                    Nama: {{ $pesanan->nama }} <br>
                    WhatsApp: {{ $pesanan->whatsapp }} <br>
                    Email: {{ $pesanan->email ?? '-' }} <br>
                    Durasi: {{ $pesanan->hari }} hari <br>
                    Tanggal Mulai: {{ \Carbon\Carbon::parse($pesanan->tanggal_mulai)->format('d M Y') }} <br>
                    Tanggal Kembali: {{ \Carbon\Carbon::parse($pesanan->tanggal_kembali)->format('d M Y') }} <br>
                </div>
            </div>

            {{-- Metode pembayaran --}}
            <div class="card">
                <strong>Metode Pembayaran</strong>

                @php
                    $pembayaran = $pesanan->pembayaran; 
                    $metode = $pembayaran->metode_pembayaran ?? ($pesanan->metode_pembayaran ?? null);
                @endphp

                <div class="muted" style="margin-top:6px;">
                    @if ($metode === 'Cash')
                        💵 Cash — pembayaran dilakukan di tempat pengambilan barang.
                    @elseif ($metode === 'QRIS')
                        📱 QRIS — pembayaran via scan QR.

                        {{-- Jika ada bukti pembayaran, tampilkan --}}
                        @if ($pembayaran && !empty($pembayaran->bukti))
                            <div style="margin-top:10px;">
                                <img src="{{ asset('storage/' . $pembayaran->bukti) }}" alt="Bukti Pembayaran"
                                    width="220" style="border-radius:8px; border: 1px solid #ccc;">
                            </div>
                            <div class="muted">Kode Pembayaran: {{ $pembayaran->kode_pembayaran }}</div>

                            {{-- Peringatan Menunggu Verifikasi untuk User --}}
                            @if ($pesanan->status === 'Menunggu Verifikasi')
                                <div style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd; color: #d97706; font-weight: 600;">
                                    ⏳ Bukti pembayaran Anda sedang dicek oleh Admin.
                                </div>
                            @endif

                        @else
                            <div class="muted" style="color: red; margin-top: 8px;">
                                Belum ada bukti pembayaran. Silakan upload via WhatsApp & simpan nota ini.
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
            <strong>Rincian Barang</strong>

            {{-- Tabel daftar barang --}}
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

                    {{-- Loop item --}}
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
                            <td style="text-align: right;">Rp {{ number_format($lineTotal, 0, ',', '.') }}</td>
                        </tr>

                    @empty
                        {{-- Jika tidak ada data item --}}
                        <tr>
                            <td colspan="5" class="muted text-center" style="text-align: center;">
                                Tidak ada rincian barang.
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
                    <div>Total Pembayaran</div>
                    <div>Rp {{ number_format($total, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>

        {{-- Catatan konfirmasi --}}
        <div style="margin-top:20px; background:#e8fff0; padding:15px; border-radius:8px; color:#0a6b2a;">
            ⚠️ <strong>Simpan nota ini & segera konfirmasi melalui WhatsApp</strong>
        </div>

        {{-- Tombol aksi --}}
        <div class="actions">
            <button type="button" class="btn btn-print" onclick="window.print()">Print / Simpan PDF</button>

            <a href="{{ route('User.dashboard') }}" class="btn btn-back" role="button">Kembali ke Beranda</a>

            <a href="https://wa.me/6288232778958?text=Halo%20Admin%20Adventure!%20Saya%20ingin%20konfirmasi%20pesanan%20saya%20dengan%20ID%20Pesanan%20%23{{ $pesanan->id }}."
                target="_blank" class="btn btn-whatsapp" style="text-decoration:none;">
                💬 Chat WhatsApp
            </a>
        </div>
    </div>
</body>

</html>