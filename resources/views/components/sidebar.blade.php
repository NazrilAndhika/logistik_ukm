<nav id="sidebar">
    <div class="py-4 text-center border-bottom border-secondary border-opacity-25 mb-3">
        <h5 class="fw-bold m-0 text-white"><i class="bi bi-box-seam me-2"></i>Admin Logistik</h5>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard
            </a>
        </li>
        
        <li class="nav-item mt-3 mb-1 ms-4 text-uppercase text-secondary" style="font-size: 0.75rem; letter-spacing: 1px;">Manajemen Data</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.items*') ? 'active' : '' }}" href="{{ route('admin.items') }}">
                <i class="bi bi-boxes"></i> Data Alat
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.anggota') ? 'active' : '' }}" href="{{ route('admin.anggota') }}">
                <i class="bi bi-people"></i> Data Anggota
            </a>
        </li>
        
        <li class="nav-item mt-3 mb-1 ms-4 text-uppercase text-secondary" style="font-size: 0.75rem; letter-spacing: 1px;">Sirkulasi</li>
        <li class="nav-item">
         <a class="nav-link {{ request()->routeIs('admin.validasi') ? 'active' : '' }}" href="{{ route('admin.validasi') }}">
             <i class="bi bi-clipboard-check"></i> Validasi Pinjam
         </a>
     </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.pengembalian') ? 'active' : '' }}" href="{{ route('admin.pengembalian') }}">
                <i class="bi bi-arrow-return-left"></i> Pengembalian
            </a>
        </li>
        
        <li class="nav-item mt-3 mb-1 ms-4 text-uppercase text-secondary" style="font-size: 0.75rem; letter-spacing: 1px;">Laporan</li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.riwayat') ? 'active' : '' }}" href="{{ route('admin.riwayat') }}">
                <i class="bi bi-file-earmark-bar-graph"></i> Riwayat & Laporan
            </a>
        </li>
    </ul>
</nav>