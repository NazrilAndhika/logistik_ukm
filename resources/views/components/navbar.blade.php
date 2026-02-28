<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-2">
    <div class="container">
        <a class="navbar-brand fw-bold text-theme d-flex align-items-center" href="#">
            <img src="{{ asset('img/logo-ukm.png') }}" alt="Logo" width="35" class="me-2">
            Logistik UKM
        </a>
        
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 mt-3 mt-lg-0">
                <li class="nav-item">
                    <a class="nav-link active fw-semibold" aria-current="page" href="#">Katalog Alat</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Status & Riwayat</a>
                </li>
            </ul>
            
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center p-0" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-theme text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <span class="fw-semibold text-dark me-1">
                            {{ Auth::user()->name ?? 'Anggota' }}
                        </span>
                    </a>
                    
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-3 rounded-3" aria-labelledby="profileDropdown">
                        <li>
                            <a class="dropdown-item py-2 d-flex align-items-center" href="#">
                                <i class="bi bi-person-circle me-2 text-secondary"></i> Profil Saya
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item py-2 d-flex align-items-center text-danger hover-bg-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #172a53;
    }
    .dropdown-item.text-danger:hover {
        background-color: #fee2e2; /* Merah muda transparan */
        color: #dc3545 !important;
    }
</style>