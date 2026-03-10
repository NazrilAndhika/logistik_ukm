@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <h6 class="mb-1 fw-normal text-white-50">Total Alat</h6>
                    <h3 class="fw-bold mb-0">{{ $totalAlat }}</h3>
                    <i class="bi bi-boxes stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning text-dark h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <h6 class="mb-1 fw-normal opacity-75">Menunggu Validasi</h6>
                    <h3 class="fw-bold mb-0">{{ $menungguValidasi }}</h3>
                    <i class="bi bi-hourglass-split stat-icon text-dark opacity-25"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-info text-white h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <h6 class="mb-1 fw-normal text-white-50">Sedang Dipinjam</h6>
                    <h3 class="fw-bold mb-0">{{ $sedangDipinjam }}</h3>
                    <i class="bi bi-box-seam stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white h-100 position-relative overflow-hidden">
                <div class="card-body p-4">
                    <h6 class="mb-1 fw-normal text-white-50">Selesai/Kembali</h6>
                    <h3 class="fw-bold mb-0">{{ $totalSelesai }}</h3>
                    <i class="bi bi-check2-circle stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold" style="color: #172a53;">
                <i class="bi bi-bell-fill text-warning me-2"></i>Pengajuan Menunggu Validasi (Terbaru)
            </h6>
            <a href="{{ route('admin.validasi') }}" class="btn btn-sm btn-outline-primary px-3">Lihat Semua</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Peminjam</th>
                            <th>Barang</th>
                            <th class="text-center">Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th class="text-center">Aksi Cepat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingTransactions as $trx)
                        <tr>
                            <td class="px-4">
                                <div class="fw-bold text-dark">{{ $trx->user->name }}</div>
                                <div class="text-muted" style="font-size: 0.8rem;">NIM: {{ $trx->user->nim ?? 'Belum diisi' }}</div>
                            </td>
                            <td class="fw-medium">{{ $trx->item->nama_barang }}</td>
                            <td class="text-center">{{ $trx->jumlah }}</td>
                            <td>{{ \Carbon\Carbon::parse($trx->tgl_pinjam)->format('d M Y') }}</td>
                            <td class="text-center">
                            <div class="d-flex justify-content-center gap-1">
                                <form action="{{ route('admin.setujui', $trx->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-lg"></i> Setujui</button>
                                </form>

                                <form action="{{ route('admin.tolak', $trx->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-x-lg"></i> Tolak</button>
                                </form>
                            </div>
                        </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Tidak ada pengajuan baru yang menunggu validasi.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection