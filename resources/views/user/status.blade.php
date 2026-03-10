<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman - UKM Badminton</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        .text-theme { color: #172a53; }
        .bg-theme { background-color: #172a53; color: white; }
        body { background-color: #f8f9fa; }
        
        /* Kustomisasi Tabel */
        .table-custom th {
            background-color: #172a53;
            color: white;
            font-weight: 600;
            border: none;
        }
        .table-custom td {
            vertical-align: middle;
        }
        .status-badge {
            width: 90px;
            display: inline-block;
            text-align: center;
        }
    </style>
</head>
<body>

    <x-navbar />

    <div class="container mt-4 mb-5">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold text-theme m-0"><i class="bi bi-hourglass-split me-2"></i>Status Peminjaman Saya</h5>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Katalog
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover table-custom mb-0">
                        <thead>
                            <tr>
                                <th class="py-3 px-4" width="5%">No</th>
                                <th class="py-3 px-4">Nama Alat</th>
                                <th class="py-3 px-4" width="10%">Jumlah</th>
                                <th class="py-3 px-4" width="18%">Tgl Pinjam</th>
                                <th class="py-3 px-4" width="18%">Rencana Kembali</th>
                                <th class="py-3 px-4 text-center" width="15%">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($peminjaman as $index => $pinjam)
                            <tr>
                                <td class="px-4 text-center">{{ $index + 1 }}</td>
                                <td class="px-4 fw-semibold text-dark">{{ $pinjam->item->nama_barang }}</td>
                                <td class="px-4 text-center">{{ $pinjam->jumlah ?? '-' }}</td>
                                <td class="px-4 text-secondary">{{ \Carbon\Carbon::parse($pinjam->tgl_pinjam)->format('d M Y') }}</td>
                                <td class="px-4 text-secondary">{{ \Carbon\Carbon::parse($pinjam->tgl_kembali)->format('d M Y') }}</td>
                                <td class="px-4 text-center">
                                    @php 
                                        // Ubah teks ke huruf kecil semua agar tidak error
                                        $cekStatus = strtolower($pinjam->status); 
                                    @endphp
                                    
                                    @if($cekStatus == 'pending')
                                        <span class="badge bg-warning text-dark status-badge">Pending</span>
                                    @elseif($cekStatus == 'dipinjam')
                                        <span class="badge bg-primary status-badge">Dipinjam</span>
                                    @else
                                        <span class="badge bg-secondary status-badge">{{ $pinjam->status ?? 'Kosong' }}</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Belum ada pengajuan peminjaman saat ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-3 text-secondary" style="font-size: 0.85rem;">
            <p><i class="bi bi-info-circle me-1"></i> <strong>Catatan:</strong> Status <span class="badge bg-warning text-dark mx-1">Pending</span> berarti menunggu persetujuan Admin. Status <span class="badge bg-primary mx-1">Dipinjam</span> berarti alat sudah bisa diambil / sedang Anda gunakan.</p>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>