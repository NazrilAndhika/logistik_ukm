@extends('admin.layout')

@section('title', 'Pengembalian Alat')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom py-3">
            <h6 class="m-0 fw-bold" style="color: #172a53;">
                <i class="bi bi-arrow-return-left text-info me-2"></i>Daftar Alat Sedang Dipinjam
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
                            <th>Batas Kembali</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($borrowedTransactions as $index => $trx)
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
                                <span class="badge bg-info bg-opacity-10 text-info border border-info">
                                    {{ $trx->jumlah }} Unit
                                </span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($trx->tgl_pinjam)->format('d M Y') }}</td>
                            <td>
                                @php
                                    $tglKembali = \Carbon\Carbon::parse($trx->tgl_kembali);
                                    $isTerlambat = $tglKembali->isPast() && !$tglKembali->isToday();
                                @endphp
                                <span class="{{ $isTerlambat ? 'text-danger fw-bold' : 'text-dark' }}">
                                    {{ $tglKembali->format('d M Y') }}
                                    @if($isTerlambat) <i class="bi bi-exclamation-circle-fill ms-1" title="Terlambat!"></i> @endif
                                </span>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('admin.kembalikan', $trx->id) }}" method="POST" onsubmit="return confirm('Pastikan barang dikembalikan dalam kondisi baik. Lanjutkan?');">
                                    @csrf @method('PUT')
                                    <button type="submit" class="btn btn-outline-primary btn-sm fw-semibold">
                                        <i class="bi bi-check2-all me-1"></i> Tandai Dikembalikan
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-box2-heart fs-2 d-block mb-2"></i>
                                Tidak ada alat yang sedang dipinjam saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection