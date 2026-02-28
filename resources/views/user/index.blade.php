<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Alat - UKM Badminton</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        /* Menggunakan warna tema dari login kamu */
        .text-theme { color: #172a53; }
        .bg-theme { background-color: #172a53; color: white; }
        .btn-theme { background-color: #172a53; color: white; }
        .btn-theme:hover { background-color: #0f1c38; color: white; }
        body { background-color: #f8f9fa; }
    </style>
</head>
<body>

   <x-navbar />

    <div class="container mt-4 mb-5">
        
        <div class="card border-0 shadow-sm mb-4" style="border-left: 5px solid #172a53 !important;">
            <div class="card-body">
                <h5 class="fw-bold text-theme mb-1">Selamat Datang!</h5>
                <p class="text-secondary mb-0" style="font-size: 0.95rem;">Cek ketersediaan alat di bawah dan ajukan peminjaman. Pastikan status disetujui admin sebelum mengambil barang ya!</p>
            </div>
        </div>

        <h5 class="fw-bold mb-3 text-theme"><i class="bi bi-box-seam me-2"></i>Katalog Alat Tersedia</h5>

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="bg-light d-flex justify-content-center align-items-center" style="height: 160px;">
                        <i class="bi bi-image text-muted fs-1"></i>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-1">Raket Yonex Astrox</h6>
                        <div class="d-flex justify-content-between align-items-center mb-3" style="font-size: 0.85rem;">
                            <span class="badge bg-success bg-opacity-10 text-success border border-success">Stok: 5</span>
                            <span class="text-muted">Kondisi: Baik</span>
                        </div>
                        <button class="btn btn-theme w-100 btn-sm py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalPinjam">
                            Ajukan Pinjam
                        </button>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="bg-light d-flex justify-content-center align-items-center" style="height: 160px;">
                        <i class="bi bi-image text-muted fs-1"></i>
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-1">Shuttlecock Garuda</h6>
                        <div class="d-flex justify-content-between align-items-center mb-3" style="font-size: 0.85rem;">
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning">Stok: 2 Slop</span>
                            <span class="text-muted">Kondisi: Baru</span>
                        </div>
                        <button class="btn btn-theme w-100 btn-sm py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalPinjam">
                            Ajukan Pinjam
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalPinjam" tabindex="-1" aria-labelledby="modalPinjamLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-theme text-white">
                    <h6 class="modal-title fw-bold" id="modalPinjamLabel">Form Peminjaman Alat</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="alert alert-info py-2 d-flex align-items-center" style="font-size: 0.85rem;">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <div>Pengajuan akan berstatus <strong>Pending</strong> menunggu validasi Admin.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 0.9rem; font-weight: 600;">Nama Alat</label>
                            <input type="text" class="form-control" value="Nama Barang Terpilih" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-size: 0.9rem; font-weight: 600;">Jumlah</label>
                            <input type="number" name="jumlah" class="form-control" min="1" placeholder="Masukkan jumlah..." required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="font-size: 0.9rem; font-weight: 600;">Rencana Dikembalikan Tgl</label>
                            <input type="date" name="tgl_kembali" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary btn-sm px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-theme btn-sm px-4">Kirim Pengajuan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>