@extends('admin.layout')

@section('title', 'Validasi Peminjaman')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="m-0 fw-bold" style="color: #172a53;">
                <i class="bi bi-clipboard-check text-warning me-2"></i>Daftar Menunggu Validasi
            </h6>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3" width="5%">No</th>
                            <th>Peminjam</th>
                            <th>Barang & Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th>Rencana Kembali</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingTransactions as $index => $trx)
                        <tr>
                            <td class="px-4 text-center">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $trx->user->name }}</div>
                                <div class="text-muted" style="font-size: 0.8rem;">
                                    NIM: {{ $trx->user->nim ?? '-' }} <br>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary mt-1">
                                        {{ $trx->user->prodi ?? '-' }} | Kelas: {{ $trx->user->kelas ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-medium">{{ $trx->item->nama_barang }}</span><br>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary">
                                    {{ $trx->jumlah }} Unit
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($trx->tgl_pinjam)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($trx->tgl_kembali)->format('d M Y') }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
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
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                Semua pengajuan sudah tervalidasi. Laporan bersih!
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection