{{-- 
    LOGIN ADMIN PAGE (login.blade.php)

    Halaman ini digunakan sebagai form login khusus admin DT Adventure.

    Fungsi utama:
    - Menampilkan form input email & password.
    - Mengirimkan kredensial ke route autentikasi admin.
    - Menyediakan tombol kembali ke dashboard user.

    Teknologi:
    - Bootstrap 5 (CSS framework responsif)
    - Blade Template Engine Laravel ({{ }}, @csrf, route())

    Alur:
    1. User membuka /admin/login
    2. Mengisi email + password
    3. POST → route('adminn.login.submit')
    4. Controller memproses login
    5. Jika sukses → masuk dashboard admin
    6. Jika gagal → kembali ke halaman ini dengan pesan error
--}}

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login Admin</title>

    <!--
        Memuat Bootstrap dari CDN.
        Bootstrap dipakai untuk styling form, layout, dan responsif.
    -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!--
        Container utama form login.
        - mt-5 memberi jarak atas
        - row + justify-content-center untuk memposisikan form ke tengah
        - col-md-4 membatasi form agar tidak terlalu lebar
    -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">

                <!-- Card sebagai wrapper tampilan form login -->
                <div class="card shadow">

                    <!-- Header card berisi judul halaman -->
                    <div class="card-header bg-primary text-center text-white">
                        <h4>Login Admin DT Adventure</h4>
                    </div>

                    <div class="card-body">

                        <!--
                            FORM LOGIN
                            - Method POST karena mengirim data sensitif
                            - Action ke route adminn.login.submit
                            - @csrf untuk keamanan (mencegah CSRF attack)
                        -->
                        <form action="{{ route('adminn.login.submit') }}" method="POST" novalidate>
                            @csrf
                            @if ($errors->has('login'))
                                <div class="alert alert-danger">
                                    {{ $errors->first('login') }}
                                </div>
                            @endif

                            <form action="{{ route('adminn.login.submit') }}" method="POST" novalidate>
                                @csrf
                                <!-- Input email admin -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Admin</label>
                                    <input type="email" name="email" id="email" class="form-control"
                                        placeholder="Masukkan email admin" required>
                                </div>

                                <!-- Input password admin -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Masukkan password" required>
                                </div>

                                <!-- Tombol submit untuk melakukan login -->
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>

                            <!--
                            Tombol kembali untuk kembali ke halaman user (dashboard utama).
                            Berguna jika user salah masuk halaman admin.
                        -->
                            <a href="{{ route('User.dashboard') }}" class="btn btn-outline-secondary w-100 mt-3">
                                Kembali Ke Dashboard Pembelian
                            </a>

                    </div>
                </div>
                <!-- End Card Login -->

            </div>
        </div>
    </div>

</body>

</html>
