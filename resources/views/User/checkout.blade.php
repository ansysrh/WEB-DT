<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Checkout</title>

    {{-- File CSS utama --}}
    <link rel="stylesheet" href="{{ asset('style.css') }}">
</head>

<body>
    <div class="cart-page">

        {{-- Header: tombol batal / kembali dan judul --}}
        <div class="cart-header">
            <a href="{{ route('admin.keranjang') }}" class="back-btn">Batalkan</a>
            <h2>Checkout</h2>
        </div>

        @if (session('error'))
            <div style="background:#ff4d4d; color:white; padding:10px 15px; border-radius:8px; margin-bottom:15px; font-weight:bold;">
                 {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="background:#ff4d4d; color:white; padding:10px 15px; border-radius:8px; margin-bottom:15px; font-weight:bold;">
                 Terjadi kesalahan:
                <ul style="margin-top: 5px; margin-bottom: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (!empty($pesanan))
            <div class="buyer-card"
                style="background: rgba(255,255,255,0.05); padding:15px; border-radius:12px; margin-bottom:15px;">
                <h3>Data Pemesan</h3>
                <p><strong>Nama:</strong> {{ $pesanan->nama }}</p>
                <p><strong>WhatsApp:</strong> {{ $pesanan->whatsapp }}</p>
                <p><strong>Email:</strong> {{ $pesanan->email }}</p>
                <p><strong>Durasi (hari):</strong> {{ $pesanan->hari }}</p>
            </div>
        @else
            <div style="background:#f51919; padding:10px; border-radius:8px; margin-bottom:15px;">
                <p style="color: white">Silakan lengkapi <a href="{{ route('admin.isidata') }}" style="color: #FFD700; text-decoration: underline;">data pemesan</a> terlebih dahulu.</p>
            </div>
        @endif

        <div class="cart-container">
            @if (count($cart) > 0)
                @foreach ($cart as $item)
                    <div class="cart-item">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_alat }}" width="80">
                        <div class="cart-info">
                            <h4>{{ $item->nama_alat }}</h4>
                            <p>Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            <p>Jumlah: {{ $item->jumlah }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Keranjang masih kosong.</p>
            @endif
        </div>

        <div class="cart-footer" style="margin-top: 12px;">
            <div style="display:flex; justify-content:space-between; width:100%; padding:10px 0;">
                <span>Total {{ $cart->count() }} Produk
                    @if (!empty($pesanan))
                         {{ $pesanan->hari }} Hari
                    @endif
                </span>
                <span>Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="cart-footer"
            style="margin-top: 20px; background: rgba(255,255,255,0.03); padding: 18px; border-radius: 12px;">

            <form action="{{ route('admin.order.store') }}" method="POST" enctype="multipart/form-data"
                style="display:flex; flex-direction:column; gap:14px;">
                @csrf

                @if (!empty($pesanan))
                    <input type="hidden" name="pesanan_id" value="{{ $pesanan->id }}">
                @endif

                <div style="background: rgba(255,255,255,0.02); padding:12px; border-radius:8px;">
                    <strong style="display:block; margin-bottom:8px; color:#FFD700; text-align:center;">Metode
                        Pembayaran</strong>

                    <label
                        style="display:flex; justify-content:space-between; align-items:center; gap:10px; cursor:pointer; padding:8px 6px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <input type="radio" name="metode_pembayaran" value="Cash" id="payCash" checked>
                            <span>Cash (Bayar di tempat saat mengambil barang)</span>
                        </div>
                    </label>

                    <label
                        style="display:flex; justify-content:space-between; align-items:center; gap:10px; cursor:pointer; padding:8px 6px; margin-top:6px;">
                        <div style="display:flex; align-items:center; gap:8px;">
                            <input type="radio" name="metode_pembayaran" value="QRIS" id="payQris">
                            <span>QRIS (Scan QR / Upload bukti)</span>
                        </div>
                    </label>

                    <div id="qrisImageContainer" style="display:none; text-align:center; margin-top:12px;">
                        <img src="{{ asset('DT ADVENTURE.png') }}" alt="QRIS Code"
                            style="width:280px; border-radius:12px; box-shadow:0 6px 18px rgba(0,0,0,0.12);">
                        <p style="color:#ccc; margin-top:8px; font-size:0.95rem;">Scan kode di atas untuk melakukan
                            pembayaran melalui QRIS.</p>
                    </div>

                    <div id="buktiWrapper" style="display:none; margin-top:12px;">
                        <label style="display:block; color:#eee; margin-bottom:6px;">Unggah Bukti Pembayaran
                            (QRIS)</label>
                        <input type="file" name="bukti" id="buktiInput" accept="image/*" style="color: white;"/>
                        <div style="font-size:12px; color:#ccc; margin-top:6px;">Format: JPG/PNG. Max: 2MB.</div>
                    </div>
                </div>

                <div style="display:flex; justify-content:space-between; align-items:center; gap:12px;">
                    <div>
                        <div style="font-weight:700;">Total: Rp {{ number_format($total ?? 0, 0, ',', '.') }}</div>
                    </div>

                    <div style="margin-left:auto;">
                        <button type="submit" class="checkout-btn"
                            style="padding:10px 18px; border-radius:8px; background:#00b894; color:#fff; border:none; font-weight:700;">
                            Buat Pesanan
                        </button>
                    </div>
                </div>
            </form>

            <script>
                (function() {
                    const payQris = document.getElementById('payQris');
                    const payCash = document.getElementById('payCash');
                    const qrisImageContainer = document.getElementById('qrisImageContainer');
                    const buktiWrapper = document.getElementById('buktiWrapper');
                    const form = document.querySelector('form');
                    const buktiInput = document.getElementById('buktiInput');

                    if (!payQris || !payCash) return;

                    function updatePaymentUI() {
                        if (payQris.checked) {
                            qrisImageContainer.style.display = 'block';
                            buktiWrapper.style.display = 'block';
                        } else {
                            qrisImageContainer.style.display = 'none';
                            buktiWrapper.style.display = 'none';
                        }
                    }

                    payQris.addEventListener('change', updatePaymentUI);
                    payCash.addEventListener('change', updatePaymentUI);

                    updatePaymentUI();

                    // Validasi wajib upload bukti jika QRIS
                    form.addEventListener('submit', function(e) {
                        if (payQris.checked && (!buktiInput.files || buktiInput.files.length === 0)) {
                            e.preventDefault();
                            alert('Harap upload bukti pembayaran QRIS terlebih dahulu!');
                            buktiWrapper.scrollIntoView({ behavior: 'smooth' });
                        }
                    });
                })();
            </script>
        </div>

    </div>
</body>

</html>