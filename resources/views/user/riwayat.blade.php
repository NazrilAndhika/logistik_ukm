<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - UKM Badminton</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        .text-theme { color: #172a53; }
        .bg-theme { background-color: #172a53; color: white; }
        body { background-color: #f8f9fa; }
        
        .table-custom th {
            background-color: #172a53;
            color: white;
            font-weight: 600;
            border: none;
        }
        .table-custom td {
            vertical-align: middle;
        }

        /* --- CSS KHUSUS PAGINATION BIAR RAPI & DI TENGAH --- */
        .custom-pagination nav { width: 100%; }
        /* Memaksa kontainer angka ke tengah */
        .custom-pagination nav > div.d-sm-flex { justify-content: center !important; }
        /* Menyembunyikan teks "Showing 1 to 5 of..." */
        .custom-pagination nav > div.d-sm-flex > div:first-child { display: none !important; } 
        /* Merapikan posisi di layar HP kecil */
        .custom-pagination nav > div.d-flex.justify-content-between.flex-fill.d-sm-none { justify-content: center !important; }
    </style>
</head>
<body>

    <x-navbar />

    <div class="container mt-4 mb-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold text-theme m-0"><i class="bi bi-clock-history me-2"></i>Riwayat Peminjaman Saya</h5>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0 text-secondary">
                        <thead>
                            <tr>
                                <th class="py-3 px-4" width="5%">No</th>
                                <th class="py-3 px-4">Nama Alat</th>
                                <th class="py-3 px-4" width="10%">Jumlah</th>
                                <th class="py-3 px-4" width="18%">Tgl Pinjam</th>
                                <th class="py-3 px-4" width="18%">Tgl Dikembalikan</th>
                                <th class="py-3 px-4 text-center" width="20%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($riwayat as $index => $pinjam)
                            <tr>
                                <td class="px-4 text-center">{{ $riwayat->firstItem() + $index }}</td>
                                <td class="px-4 fw-semibold text-dark">{{ $pinjam->item->nama_barang ?? 'Barang Dihapus' }}</td>
                                <td class="px-4 text-center">{{ $pinjam->jumlah }}</td>
                                <td class="px-4">{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d M Y') }}</td>
                                
                                <td class="px-4">
                                    @if($pinjam->status == 'Selesai' || $pinjam->status == 'Selesai (Terlambat)')
                                        <span class="text-success fw-medium" title="Tanggal Dikembalikan">{{ \Carbon\Carbon::parse($pinjam->updated_at)->format('d M Y') }}</span>
                                    @elseif($pinjam->status == 'Ditolak')
                                        <span class="text-danger fw-medium">-</span>
                                    @else
                                        <span class="text-dark" title="Rencana Kembali">{{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d M Y') }}</span>
                                    @endif
                                </td>
                                
                                <td class="px-4 text-center">
                                    @if($pinjam->status == 'Pending')
                                        <span class="badge bg-warning text-dark border border-warning rounded-pill px-3 py-2"><i class="bi bi-clock-history me-1"></i> Pending</span>
                                    @elseif($pinjam->status == 'Dipinjam')
                                        <span class="badge bg-primary text-white border border-primary rounded-pill px-3 py-2"><i class="bi bi-box-arrow-right me-1"></i> Dipinjam</span>
                                    @elseif($pinjam->status == 'Selesai')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success rounded-pill px-3 py-2"><i class="bi bi-check-circle me-1"></i> Selesai</span>
                                    @elseif($pinjam->status == 'Selesai (Terlambat)')
                                        <span class="badge bg-dark bg-opacity-10 text-dark border border-dark rounded-pill px-3 py-2"><i class="bi bi-exclamation-circle me-1"></i> Selesai (Terlambat)</span>
                                    @elseif($pinjam->status == 'Ditolak')
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger rounded-pill px-3 py-2"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-clock-history fs-2 d-block mb-2 text-light"></i>
                                    Belum ada riwayat peminjaman yang selesai.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($riwayat->hasPages())
            <div class="card-footer bg-white border-top py-3 custom-pagination d-flex justify-content-center">
                {{ $riwayat->links('pagination::bootstrap-5') }}
            </div>
            @endif
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>