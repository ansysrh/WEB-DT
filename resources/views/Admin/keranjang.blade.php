<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* CSS Tambahan untuk tombol Edit Jumlah */
        .qty-container {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }
        .btn-qty {
            background-color: #333;
            color: #fff;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.2s;
        }
        .btn-qty:hover { background-color: #555; }
        .qty-input {
            width: 40px;
            text-align: center;
            border: 1px solid #444;
            background: #222;
            color: white;
            border-radius: 4px;
            padding: 4px;
            font-weight: bold;
        }
        /* Hilangkan panah spinner bawaan browser pada input number */
        .qty-input::-webkit-outer-spin-button,
        .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>

<body>
    <div class="cart-page">
        <div class="cart-header">
            <a href="#" class="back-btn" onclick="history.back(); return false;">
                <span class="arrow">←</span> Kembali
            </a>
            <h2>Keranjang </h2>
        </div>

        <div class="cart-container">
            <h2>Keranjang Saya ({{ count($cart) }})</h2>

            @if (count($cart) > 0)
                @foreach ($cart as $item)
                    <div class="cart-item">
                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_alat }}" width="100">
                        
                        <div class="cart-info">
                            <h4>{{ $item->nama_alat }}</h4>
                            <p>Rp {{ number_format($item->harga, 0, ',', '.') }} / hari</p>
                            
                            {{-- BAGIAN BARU: Kontrol Edit Jumlah --}}
                            <div class="qty-container">
                                <button type="button" class="btn-qty" onclick="updateQty({{ $item->id }}, -1)">-</button>
                                <input type="number" id="qty-{{ $item->id }}" class="qty-input" value="{{ $item->jumlah }}" readonly>
                                <button type="button" class="btn-qty" onclick="updateQty({{ $item->id }}, 1)">+</button>
                            </div>
                        </div>

                        <form id="delete-form-{{ $item->id }}" action="{{ route('keranjang.hapus', $item->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-hapus" data-id="{{ $item->id }}">Hapus</button>
                        </form>
                    </div>
                @endforeach
            @else
                <p>Keranjang masih kosong.</p>
            @endif

            <div style="text-align: right; width: 100%; margin-top: 20px;">
                <a href="{{ route('admin.isidata') }}" style="text-decoration:none; display:inline-block;">
                    <button class="checkout-btn" style="width:auto; padding:10px 30px; display:inline-block;">
                        Checkout
                    </button>
                </a>
            </div>
        </div>
    </div>

    <script>
        // --- 1. SCRIPT MENGHAPUS ITEM (Bawaan) ---
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-hapus').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Item ini akan dihapus dari keranjangmu.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('delete-form-' + id).submit();
                        }
                    });
                });
            });
        });

        // --- 2. SCRIPT EDIT JUMLAH (Baru) ---
        function updateQty(id, change) {
            const inputElement = document.getElementById('qty-' + id);
            let currentQty = parseInt(inputElement.value);
            let newQty = currentQty + change;

            // Jangan biarkan jumlah menjadi 0 atau negatif
            if (newQty < 1) return;

            // Update angka di layar secara langsung agar terasa responsif
            inputElement.value = newQty;

            // Kirim permintaan ubah data ke database via AJAX
            fetch(`/keranjang/update/${id}`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ jumlah: newQty })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    // Jika gagal disimpan di server, kembalikan angkanya ke semula
                    inputElement.value = currentQty;
                    alert("Gagal menyimpan perubahan ke server.");
                }
            })
            .catch(error => {
                console.error("Terjadi kesalahan:", error);
                inputElement.value = currentQty;
                alert("Kesalahan jaringan.");
            });
        }
    </script>
</body>

</html>