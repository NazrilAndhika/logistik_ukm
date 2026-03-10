<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - UKM Badminton</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        .text-theme { color: #172a53; }
        .bg-theme { background-color: #172a53; color: white; }
        .btn-theme { background-color: #172a53; color: white; }
        .btn-theme:hover { background-color: #0f1c38; color: white; }
        body { background-color: #f8f9fa; }
    </style>
</head>
<body>

    <x-navbar />

    <div class="container mt-4 mb-5" style="max-width: 800px;">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold text-theme m-0"><i class="bi bi-person-circle me-2"></i>Profil Saya</h5>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">
                <form action="{{ route('profil.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">NIM</label>
                            <input type="text" name="nim" class="form-control" value="{{ $user->nim }}" placeholder="Masukkan NIM Anda">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">No. WhatsApp</label>
                            <input type="text" name="no_hp" class="form-control" value="{{ $user->no_hp }}" placeholder="Contoh: 08123456789">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Program Studi</label>
                            <input type="text" name="prodi" class="form-control" value="{{ $user->prodi }}" placeholder="Teknik Informatika">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Kelas</label>
                            <input type="text" name="kelas" class="form-control" value="{{ $user->kelas }}" placeholder="2A">
                        </div>

                        <div class="col-md-12 mb-4">
                            <label class="form-label fw-semibold">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="" disabled {{ is_null($user->jenis_kelamin) ? 'selected' : '' }}>Pilih Jenis Kelamin</option>
                                <option value="Laki-laki" {{ $user->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-theme px-4 fw-semibold">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>