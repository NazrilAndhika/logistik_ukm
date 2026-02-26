<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Logistik UKM Badminton</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Latar belakang abu-abu terang */
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-wrapper {
            width: 100%;
            max-width: 400px;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 25px;
        }
        .logo-icon {
            background-color: #172a53; /* Biru gelap sesuai gambar */
            color: white;
            font-size: 28px;
            width: 65px;
            height: 65px;
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
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
            <img src="{{ asset('img/logo-ukm.png') }}" alt="Logo UKM Badminton" width="90" class="mb-3">
            <h4 class="fw-bold mb-1" style="color: #172a53;">UKM Badminton</h4>
            <p class="text-secondary" style="font-size: 0.95rem;">Sistem Manajemen Logistik</p>
        </div>

        <div class="login-card">
            <h4 class="fw-bold mb-1" style="color: #172a53;">Masuk</h4>
            <p class="text-secondary mb-4" style="font-size: 0.9rem;">Masuk ke akun Anda</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="email@contoh.com" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Minimal 6 karakter" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-custom w-100 text-white fw-bold mb-4">Masuk</button>

                <div class="text-center" style="font-size: 0.9rem;">
                    <span class="text-secondary">Belum punya akun?</span> 
                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold" style="color: #172a53;">Daftar</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>