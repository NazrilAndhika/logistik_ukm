@extends('admin.layout')

@section('title', 'Manajemen Data Anggota')

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
                <i class="bi bi-people-fill me-2"></i>Daftar Anggota UKM
            </h6>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3" width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>NIM</th>
                            <th>Jenis Kelamin</th>
                            <th>Kontak</th>
                            <th class="text-center" width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($anggota as $index => $user)
                        <tr>
                            <td class="px-4 text-center">{{ $index + 1 }}</td>
                            <td class="fw-semibold text-dark">
                                {{ $user->name }}
                                <div class="text-muted" style="font-size: 0.8rem;">
                                    {{ $user->email }} <br>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary mt-1">
                                        {{ $user->prodi ?? '-' }} | Kelas: {{ $user->kelas ?? '-' }}
                                    </span>
                                </div>
                            </td>
                            <td>{{ $user->nim ?? '-' }}</td>
                            <td>{{ $user->jenis_kelamin ?? '-' }}</td>
                            <td>
                                @if($user->no_hp)
                                    <span class="fw-medium text-dark"><i class="bi bi-telephone me-1 text-secondary"></i> {{ $user->no_hp }}</span>
                                @else
                                    <span class="text-muted fst-italic">Belum diisi</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $user->id }}">
                                    <i class="bi bi-trash3"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="deleteModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow">
                                    <div class="modal-body text-center p-4">
                                        <i class="bi bi-exclamation-circle text-danger" style="font-size: 3rem;"></i>
                                        <h5 class="mt-3 fw-bold">Keluarkan Anggota?</h5>
                                        <p class="text-muted">Akun atas nama <strong>{{ $user->name }}</strong> akan dihapus permanen dari sistem.</p>
                                        <form action="{{ route('admin.anggota.destroy', $user->id) }}" method="POST" class="mt-4">
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
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-1 d-block mb-2"></i> Belum ada anggota yang mendaftar.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection