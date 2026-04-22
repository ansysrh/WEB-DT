<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">

    <style>
        body {
            background: linear-gradient(180deg, #2f4f6f, #3f6a8c);
            font-family: Arial, sans-serif;
            color: white;
        }

        .container {
            width: 85%;
            margin: 30px auto;
        }

        h1 {
            color: #ffd54f;
        }

        .card {
            background: rgba(255,255,255,0.05);
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .produk {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .produk img {
            width: 70px;
            border-radius: 10px;
        }

        .row-between {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            background: #6fcf97;
            border: none;
            padding: 12px 25px;
            border-radius: 10px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        .btn:hover {
            background: #57b982;
        }

        .radio {
            margin: 10px 0;
        }

        .qris-img {
            width: 250px;
            margin-top: 10px;
            border-radius: 10px;
        }

        .total {
            font-weight: bold;
            font-size: 18px;
        }
    </style>
</head>

<body>

<div class="container">

    <div class="row-between">
        <a href="{{ route('admin.keranjang') }}" class="btn">Batalkan</a>
        <h1>Checkout</h1>
    </div>

    {{-- DATA PEMESAN --}}
    <div class="card">
        <h3>Data Pemesan</h3>
        <p>Nama: {{ $pesanan->nama }}</p>
        <p>WhatsApp: {{ $pesanan->whatsapp }}</p>
        <p>Email: {{ $pesanan->email }}</p>
        <p>Durasi (hari): {{ $pesanan->durasi }}</p>
    </div>

    {{-- PRODUK --}}
    <div class="card">
        @foreach($pesanan->items as $item)
            <div class="produk">
                <img src="{{ asset('storage/' . $item->tipeAlat->gambar) }}">
                <div>
                    <h4>{{ $item->tipeAlat->nama_alat }}</h4>
                    <p>Rp {{ number_format($item->harga,0,',','.') }}</p>
                    <p>Jumlah: {{ $item->jumlah }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- TOTAL --}}
    <div class="card row-between">
        <div>Total {{ $pesanan->items->count() }} Produk × {{ $pesanan->durasi }} Hari</div>
        <div class="total">
            Rp {{ number_format($pesanan->total_harga,0,',','.') }}
        </div>
    </div>

    {{-- FORM PEMBAYARAN --}}
    <form action="{{ route('checkout.proses') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">

        <div class="card">
            <h3 style="color:#ffd54f;">Metode Pembayaran</h3>

            <div class="radio">
                <input type="radio" name="metode" value="cash" checked>
                Cash (Bayar di tempat)
            </div>

            <div class="radio">
                <input type="radio" name="metode" value="qris">
                QRIS (Scan / Upload bukti)
            </div>

            <img src="{{ asset('qris.png') }}" class="qris-img">

            <div style="margin-top:10px;">
                <label>Upload Bukti</label><br>
                <input type="file" name="bukti">
            </div>
        </div>

        <div style="text-align:center;">
            <button type="submit" class="btn">Buat Pesanan</button>
        </div>

    </form>

</div>

</body>
</html>