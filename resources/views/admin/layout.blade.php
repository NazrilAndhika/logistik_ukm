<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Logistik UKM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <style>
        :root {
            --theme-color: #172a53;
            --theme-hover: #0f1c38;
        }
        body { background-color: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; overflow-x: hidden; }
        
        /* Sidebar Styling */
        #sidebar {
            width: 260px;
            background-color: var(--theme-color);
            color: white;
            height: 100vh;
            position: fixed;
            z-index: 1040;
            overflow-y: auto;
            transition: all 0.3s ease;
            left: 0;
        }
        #sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 4px 15px;
            border-radius: 8px;
            transition: all 0.2s;
        }
        #sidebar .nav-link:hover, #sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            font-weight: 600;
        }
        #sidebar .nav-link i { margin-right: 10px; font-size: 1.1rem; }
        
        /* Main Content Styling */
        #main-content {
            margin-left: 260px;
            width: calc(100% - 260px);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }
        
        /* Top Navbar */
        .topbar {
            background-color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.04);
            padding: 15px 25px;
        }
        
        .content-area { padding: 25px; flex-grow: 1; }
        .stat-icon { font-size: 3.5rem; position: absolute; right: 15px; bottom: 5px; opacity: 0.2; }

        /* ======== RESPONSIVE MOBILE ======== */
        @media (max-width: 768px) {
            #sidebar {
                left: -260px; /* Sembunyikan sidebar ke kiri luar layar */
            }
            #sidebar.active {
                left: 0; /* Munculkan saat tombol hamburger diklik */
            }
            #main-content {
                margin-left: 0;
                width: 100%;
            }
            /* Latar gelap saat sidebar muncul di HP */
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0; left: 0; right: 0; bottom: 0;
                background: rgba(0,0,0,0.5);
                z-index: 1030;
            }
            .sidebar-overlay.active { display: block; }
        }
    </style>
</head>
<body>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="d-flex">
        <x-sidebar />

        <div id="main-content">
            
            <div class="topbar d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <button class="btn btn-outline-secondary border-0 me-3 d-md-none" id="sidebarToggle">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <h5 class="m-0 fw-bold text-dark d-none d-sm-block">@yield('title', 'Dashboard')</h5>
                </div>
                
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-decoration-none text-dark dropdown-toggle" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 35px; height: 35px;">
                            <i class="bi bi-person-badge"></i>
                        </div>
                        <span class="fw-semibold">{{ Auth::user()->name ?? 'Administrator' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="content-area">
                @yield('content')
            </div>
            
            <footer class="bg-white text-center py-3 text-muted mt-auto" style="font-size: 0.85rem;">
                &copy; {{ date('Y') }} Sistem Logistik UKM Badminton - Politeknik Negeri Cilacap
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        });

        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            document.getElementById('sidebar').classList.remove('active');
            this.classList.remove('active');
        });
    </script>
</body>
</html>