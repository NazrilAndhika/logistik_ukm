<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Alat - UKM Badminton</title>
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

    <div class="container mt-4 mb-5">
        
        <div class="card border-0 shadow-sm mb-5 bg-theme text-white overflow-hidden" style="border-radius: 16px;">
            <div class="card-body p-4 p-md-5 position-relative">
                <div style="position: relative; z-index: 2;">
                    <h2 class="fw-bold mb-3">Halo, {{ Auth::user()->name }}! </h2>
                    <p class="mb-0" style="font-size: 1.1rem; opacity: 0.9; max-width: 700px;">
                        Selamat datang di pusat Manajemen Logistik UKM Badminton Politeknik Negeri Cilacap. <br>
                        Silahkan cek ketersediaan alat di bawah ini dan ajukan peminjamanmu. Pastikan mengambil barang ke sekre setelah statusnya disetujui Admin!
                    </p>
                </div>
                <!-- <i class="bi bi-box-seam position-absolute" style="font-size: 12rem; right: -20px; bottom: -50px; color: rgba(255,255,255,0.08); transform: rotate(-15deg);"></i> -->
            </div>
        </div>
        @if($cekTerlambat)
            <div class="alert alert-danger shadow-sm mb-4 border-0" style="border-left: 5px solid #dc3545 !important;">
                <h6 class="fw-bold mb-1 text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i> Akses Peminjaman Dibekukan!</h6>
                <p class="mb-0 text-dark" style="font-size: 0.95rem;">
                    Anda memiliki alat yang <strong>belum dikembalikan melewati batas waktu</strong>. Anda tidak dapat mengajukan peminjaman alat baru sebelum mengembalikan alat tersebut kepada Admin.
                </p>
            </div>
        @endif

        <h5 class="fw-bold mb-3 text-theme"><i class="bi bi-box-seam me-2"></i>Katalog Alat Tersedia</h5>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            
            @forelse ($items as $item)
            <div class="col">
                <div class="card h-100 border-0 shadow-sm">
                    
                    <div class="bg-light d-flex justify-content-center align-items-center rounded-top overflow-hidden" style="height: 160px;">
                        @if($item->foto)
                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_barang }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i class="bi bi-image text-muted fs-1"></i>
                        @endif
                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-bold mb-1">{{ $item->nama_barang }}</h6>
                        <div class="d-flex justify-content-between align-items-center mb-3" style="font-size: 0.85rem;">
                            <span class="badge bg-success bg-opacity-10 text-success border border-success">Stok: {{ $item->stok }}</span>
                            <span class="text-muted">Kondisi: {{ $item->kondisi }}</span>
                        </div>
                        @if($cekTerlambat)
                            <button class="btn btn-danger w-100 btn-sm py-2 fw-semibold opacity-75" disabled>
                                <i class="bi bi-lock-fill me-1"></i> Diblokir
                            </button>
                        @elseif($item->stok > 0)
                            <button class="btn btn-theme w-100 btn-sm py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#modalPinjam{{ $item->id }}">
                                Ajukan Pinjam
                            </button>
                        @else
                            <button class="btn btn-secondary w-100 btn-sm py-2 fw-semibold" disabled>
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>

                <div class="modal fade" id="modalPinjam{{ $item->id }}" tabindex="-1" aria-labelledby="modalPinjamLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content border-0 shadow">
                            <div class="modal-header bg-theme text-white">
                                <h6 class="modal-title fw-bold" id="modalPinjamLabel{{ $item->id }}">Form Peminjaman Alat</h6>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('pinjam.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                
                                <div class="modal-body">
                                    <div class="alert alert-info py-2 d-flex align-items-center" style="font-size: 0.85rem;">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        <div>Pengajuan akan berstatus <strong>Pending</strong>.</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label" style="font-size: 0.9rem; font-weight: 600;">Nama Alat</label>
                                        <input type="text" class="form-control" value="{{ $item->nama_barang }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" style="font-size: 0.9rem; font-weight: 600;">Jumlah</label>
                                        <input type="number" name="jumlah" class="form-control" min="1" max="{{ $item->stok }}" placeholder="Maks: {{ $item->stok }}" required>
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
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">
                Belum ada barang di logistik.
            </div>
            @endforelse

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>