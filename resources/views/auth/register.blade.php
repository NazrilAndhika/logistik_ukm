<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Logistik UKM Badminton</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; 
            min-height: 100vh; 
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 0; 
        }
        .login-wrapper {
            width: 100%;
            max-width: 450px; 
        }
        .logo-container {
            text-align: center;
            margin-bottom: 25px;
        }
        .login-card {
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            background-color: white;
            padding: 35px 30px;
            border: 1px solid #eaeaea;
        }
        .btn-custom {
            background-color: #172a53;
            border-color: #172a53;
            border-radius: 8px;
            padding: 10px;
        }
        .btn-custom:hover {
            background-color: #0f1c38;
            border-color: #0f1c38;
        }
        .form-control {
            border-radius: 8px;
            padding: 10px 15px;
        }
        .form-label {
            font-size: 0.9rem;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="login-wrapper">
        <div class="logo-container">
            <img src="{{ asset('img/logo-ukm.png') }}" alt="Logo UKM Badminton" width="80" class="mb-2">
            <h5 class="fw-bold mb-1" style="color: #172a53;">UKM Badminton</h5>
            <p class="text-secondary" style="font-size: 0.9rem;">Sistem Manajemen Logistik</p>
        </div>

        <div class="login-card">
            <h4 class="fw-bold mb-1" style="color: #172a53;">Daftar</h4>
            <p class="text-secondary mb-4" style="font-size: 0.9rem;">Buat akun baru Anda</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control @error('prodi') is-invalid @enderror" id="prodi" name="prodi" value="{{ old('prodi') }}" required placeholder="Contoh: Teknik Informatika">
                    @error('prodi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kelas" class="form-label">Kelas / Tingkat</label>
                    <input type="text" class="form-control @error('kelas') is-invalid @enderror" id="kelas" name="kelas" value="{{ old('kelas') }}" required placeholder="Contoh: 2A">
                    @error('kelas')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required placeholder="Minimal 8 karakter">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required placeholder="Ketik ulang password">
                </div>

                <button type="submit" class="btn btn-custom w-100 text-white fw-bold mb-4">Daftar Sekarang</button>

                <div class="text-center" style="font-size: 0.9rem;">
                    <span class="text-secondary">Sudah punya akun?</span> 
                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold" style="color: #172a53;">Masuk</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>