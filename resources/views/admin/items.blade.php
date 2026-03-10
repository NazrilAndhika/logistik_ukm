@extends('admin.layout')

@section('title', 'Manajemen Data Alat')

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold" style="color: #172a53;">
                <i class="bi bi-boxes me-2"></i>Daftar Alat Logistik
            </h6>
            <button class="btn btn-sm btn-primary px-3" data-bs-toggle="modal" data-bs-target="#tambahModal">
                <i class="bi bi-plus-lg me-1"></i> Tambah Alat
            </button>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3" width="5%">No</th>
                            <th>Nama Barang</th>
                            <th class="text-center" width="15%">Stok Tersedia</th>
                            <th class="text-center" width="15%">Kondisi</th>
                            <th class="text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $index => $item)
                        <tr>
                            <td class="px-4 text-center">{{ $index + 1 }}</td>
                            <td class="fw-semibold text-dark">
                                @if($item->foto) <i class="bi bi-image text-primary me-1" title="Ada Foto"></i> @endif
                                {{ $item->nama_barang }}
                            </td>
                            <td class="text-center">
                                <span class="badge {{ $item->stok > 0 ? 'bg-success' : 'bg-danger' }} bg-opacity-10 text-{{ $item->stok > 0 ? 'success' : 'danger' }} border border-{{ $item->stok > 0 ? 'success' : 'danger' }} px-3 py-2">
                                    {{ $item->stok }} Pcs
                                </span>
                            </td>
                            <td class="text-center">{{ $item->kondisi }}</td>
                            <td class="text-center">
                                <button class="btn btn-warning btn-sm me-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $item->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $item->id }}">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="editModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-header bg-warning">
                                        <h6 class="modal-title fw-bold text-dark">Edit Alat</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('admin.items.update', $item->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf @method('PUT')
                                        <div class="modal-body text-start">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Nama Barang</label>
                                                <input type="text" name="nama_barang" class="form-control" value="{{ $item->nama_barang }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Stok</label>
                                                <input type="number" name="stok" class="form-control" value="{{ $item->stok }}" min="0" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Kondisi</label>
                                                <select name="kondisi" class="form-select" required>
                                                    <option value="Baru" {{ $item->kondisi == 'Baru' ? 'selected' : '' }}>Baru</option>
                                                    <option value="Baik" {{ $item->kondisi == 'Baik' ? 'selected' : '' }}>Baik</option>
                                                    <option value="Kurang Baik" {{ $item->kondisi == 'Kurang Baik' ? 'selected' : '' }}>Kurang Baik</option>
                                                    <option value="Rusak" {{ $item->kondisi == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold">Ganti Foto Alat</label>
                                                <input type="file" name="foto" class="form-control" accept="image/*">
                                                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto saat ini.</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-warning btn-sm fw-semibold">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-body text-center p-4">
                                        <i class="bi bi-exclamation-circle text-danger" style="font-size: 3rem;"></i>
                                        <h5 class="mt-3 fw-bold">Yakin ingin menghapus?</h5>
                                        <p class="text-muted">Data <strong>{{ $item->nama_barang }}</strong> akan dihapus permanen dari sistem.</p>
                                        <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" class="mt-4">
                                            @csrf @method('DELETE')
                                            <button type="button" class="btn btn-outline-secondary px-4 me-2" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger px-4">Ya, Hapus!</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-box2 fs-1 d-block mb-2"></i> Belum ada data alat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambahModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h6 class="modal-title fw-bold">Tambah Alat Baru</h6>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Net Lining..." required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Jumlah Stok</label>
                            <input type="number" name="stok" class="form-control" min="0" placeholder="0" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Kondisi</label>
                            <select name="kondisi" class="form-select" required>
                                <option value="Baru">Baru</option>
                                <option value="Baik" selected>Baik</option>
                                <option value="Kurang Baik">Kurang Baik</option>
                                <option value="Rusak">Rusak</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Upload Foto Alat</label>
                            <input type="file" name="foto" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary btn-sm fw-semibold">Simpan Alat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection