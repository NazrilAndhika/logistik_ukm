@extends('admin.layout')

@section('title', 'Riwayat & Laporan Transaksi')

@section('content')

    <style>
        @media print {
            #sidebar, .topbar, .btn, footer, .d-print-none { 
                display: none !important; 
            }
            #main-content { 
                margin-left: 0 !important; 
                width: 100% !important; 
                padding: 0 !important;
            }
            body { background-color: white; }
            .card { border: none !important; box-shadow: none !important; }
            .card-header { border-bottom: 2px solid #000 !important; background: transparent !important; }
        }

        /* --- CSS KHUSUS PAGINATION BIAR RAPI & DI TENGAH --- */
        .custom-pagination nav { width: 100%; }
        .custom-pagination nav > div.d-sm-flex { justify-content: center !important; }
        .custom-pagination nav > div.d-sm-flex > div:first-child { display: none !important; } 
        .custom-pagination nav > div.d-flex.justify-content-between.flex-fill.d-sm-none { justify-content: center !important; }
    </style>

    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold" style="color: #172a53;">
                <i class="bi bi-file-earmark-bar-graph text-secondary me-2"></i>Buku Induk Logistik
            </h6>
            <button onclick="window.print()" class="btn btn-sm btn-primary px-3 d-print-none">
                <i class="bi bi-printer me-1"></i> Cetak Laporan
            </button>
        </div>
        
        <div class="card-body border-bottom bg-light d-print-none py-3">
            <form action="{{ route('admin.riwayat') }}" method="GET" id="filterForm" class="row g-3 align-items-center mb-0">
                <div class="col-auto">
                    <label class="col-form-label fw-semibold text-secondary"><i class="bi bi-funnel me-1"></i> Filter :</label>
                </div>
                <div class="col-auto">
                    <input type="date" name="start_date" id="start_date" class="form-control form-control-sm" value="{{ request('start_date') }}" required>
                </div>
                <div class="col-auto">
                    <span class="text-muted fw-medium">s/d</span>
                </div>
                <div class="col-auto">
                    <input type="date" name="end_date" id="end_date" class="form-control form-control-sm" value="{{ request('end_date') }}" required>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-sm text-white fw-semibold" style="background-color: #172a53;"><i class="bi bi-search me-1"></i> Terapkan</button>
                </div>

                <div class="col-auto ms-auto border-start ps-3">
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle fw-semibold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class=""></i> Filter Cepat
                        </button>
                        <ul class="dropdown-menu shadow-sm">
                            <li><a class="dropdown-item" href="#" onclick="setPreset('semua')"><i class="bi bi-clock-history me-2"></i>Semua Waktu</a></li>
                            <li><a class="dropdown-item" href="#" onclick="setPreset('hari_ini')"><i class="bi bi-calendar-day me-2"></i>Hari Ini</a></li>
                            <li><a class="dropdown-item" href="#" onclick="setPreset('bulan_ini')"><i class="bi bi-calendar-month me-2"></i>Bulan Ini</a></li>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3" width="5%">No</th>
                            <th>Peminjam</th>
                            <th>Barang</th>
                            <th class="text-center">Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali/Selesai</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat as $index => $trx)
                        <tr>
                            <td class="px-4 text-center">{{ $riwayat->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $trx->user->name }}</div>
                                <div class="text-muted" style="font-size: 0.8rem;">
                                    NIM: {{ $trx->user->nim ?? '-' }} <br>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary mt-1">
                                        {{ $trx->user->prodi ?? '-' }} | Kelas: {{ $trx->user->kelas ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td class="fw-medium">{{ $trx->item->nama_barang }}</td>
                            <td class="text-center">{{ $trx->jumlah }}</td>
                            <td>{{ \Carbon\Carbon::parse($trx->tgl_pinjam)->format('d M Y') }}</td>
                            
                            <td>
                                @if($trx->status == 'Selesai' || $trx->status == 'Selesai (Terlambat)')
                                    <span class="text-success fw-medium">{{ \Carbon\Carbon::parse($trx->updated_at)->format('d M Y') }}</span>
                                @elseif($trx->status == 'Ditolak')
                                    <span class="text-danger fw-medium">-</span>
                                @else
                                    <span class="text-dark">{{ \Carbon\Carbon::parse($trx->tgl_kembali)->format('d M Y') }}</span>
                                @endif
                            </td>

                            <td class="text-center">
                                @php
                                    $badgeClass = 'bg-secondary';
                                    if($trx->status == 'Pending') $badgeClass = 'bg-warning text-dark';
                                    elseif($trx->status == 'Dipinjam') $badgeClass = 'bg-info text-white';
                                    elseif($trx->status == 'Selesai') $badgeClass = 'bg-success text-white';
                                    elseif($trx->status == 'Selesai (Terlambat)') $badgeClass = 'bg-dark text-white';
                                    elseif($trx->status == 'Ditolak') $badgeClass = 'bg-danger text-white';
                                @endphp
                                <span class="badge {{ $badgeClass }} px-3 py-2">
                                    {{ $trx->status }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-folder-x fs-2 d-block mb-2"></i>
                                Belum ada riwayat transaksi sama sekali.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($riwayat->hasPages())
        <div class="card-footer bg-white border-top py-3 custom-pagination d-flex justify-content-center d-print-none">
            {{ $riwayat->links('pagination::bootstrap-5') }}
        </div>
        @endif

    </div>

    <script>
        function setPreset(tipe) {
            event.preventDefault(); 
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const form = document.getElementById('filterForm');

            if (tipe === 'semua') {
                window.location.href = "{{ route('admin.riwayat') }}";
                return;
            }

            const today = new Date();
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');

            if (tipe === 'hari_ini') {
                const dateString = `${year}-${month}-${day}`;
                startDateInput.value = dateString;
                endDateInput.value = dateString;
            } else if (tipe === 'bulan_ini') {
                const firstDay = `${year}-${month}-01`;
                const lastDayObj = new Date(year, today.getMonth() + 1, 0); 
                const lastDay = String(lastDayObj.getDate()).padStart(2, '0');
                const lastDayString = `${year}-${month}-${lastDay}`;
                startDateInput.value = firstDay;
                endDateInput.value = lastDayString;
            }

            form.submit();
        }
    </script>

@endsection