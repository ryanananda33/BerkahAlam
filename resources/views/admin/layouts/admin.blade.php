<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - BERKAH ALAM')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary-color: #1A1A1A;
            --secondary-color: #6C757D;
            --background-color: #F8F9FA;
            --surface-color: rgba(255, 255, 255, 0.55);
            --border-color: rgba(255, 255, 255, 0.5);
            --accent-color: #C5A059; /* Champagne Gold */
            --text-color: #333333;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Poppins', sans-serif;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 280px;
            background-color: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(25px) saturate(180%);
            -webkit-backdrop-filter: blur(25px) saturate(180%);
            color: var(--text-color);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding: 30px 20px;
            z-index: 100;
            display: flex;
            flex-direction: column;
            border-right: 1px solid rgba(0, 0, 0, 0.06);
        }

        .sidebar-brand {
            font-family: 'Poppins', sans-serif;
            margin-bottom: 40px;
            display: flex;
            align-items: center;
        }

        .logo-box {
            background-color: var(--accent-color);
            width: 42px;
            height: 42px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(197, 168, 128, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar-menu {
            list-style: none;
            padding-left: 0;
            margin-bottom: auto;
        }

        .sidebar-item {
            margin-bottom: 6px;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 12px 18px;
            color: #555555;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            color: var(--primary-color);
            background-color: rgba(0, 0, 0, 0.03);
        }

        .sidebar-link.active {
            color: #ffffff !important;
            background-color: var(--accent-color) !important;
            box-shadow: 0 4px 12px rgba(197, 168, 128, 0.3);
        }

        .sidebar-link.active i {
            color: #ffffff !important;
        }

        .sidebar-link i {
            margin-right: 14px;
            font-size: 1.15rem;
            transition: color 0.2s ease;
        }

        .sidebar-logout {
            color: #ff5b5b;
            background: transparent;
            border: none;
            width: 100%;
            padding: 12px 18px;
            text-align: left;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        
        .sidebar-logout:hover {
            background-color: rgba(255, 91, 91, 0.08);
            color: #ff3b3b;
        }

        /* Main Content wrapper */
        .main-wrapper {
            margin-left: 280px;
            width: calc(100% - 280px);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        /* Topbar */
        .topbar {
            background-color: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            padding: 18px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 99;
        }

        /* Content Panel */
        .content-panel {
            padding: 40px;
            flex-grow: 1;
        }

        /* Premium Card style for Admin */
        .admin-card {
            background: var(--surface-color);
            border: 1px solid var(--border-color);
            backdrop-filter: blur(25px) saturate(180%);
            -webkit-backdrop-filter: blur(25px) saturate(180%);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            padding: 30px;
            margin-bottom: 30px;
            transition: all 0.3s ease;
        }

        .admin-card:hover {
            border-color: var(--accent-color);
            box-shadow: 0 15px 35px rgba(197, 168, 128, 0.08);
        }

        /* Table Styling */
        .table {
            --bs-table-color: var(--text-color) !important;
            --bs-table-bg: transparent !important;
            --bs-table-border-color: var(--border-color) !important;
            --bs-table-hover-bg: rgba(0, 0, 0, 0.01) !important;
            color: var(--text-color) !important;
        }
        .table th {
            background-color: transparent !important;
            border-bottom-color: var(--border-color) !important;
            color: var(--secondary-color) !important;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 10px;
        }
        .table td {
            background-color: transparent !important;
            border-bottom-color: var(--border-color) !important;
            color: var(--text-color) !important;
            padding: 14px 10px;
            font-size: 0.95rem;
        }
        .table-responsive {
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 12px;
        }

        /* Custom buttons for Admin */
        .btn-stone-admin {
            background-color: var(--accent-color);
            color: #ffffff !important;
            border: 1.5px solid var(--accent-color);
            border-radius: 30px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .btn-stone-admin:hover {
            background-color: transparent;
            color: var(--accent-color) !important;
            box-shadow: 0 4px 12px rgba(197, 168, 128, 0.15);
        }

        .btn-stone-dark {
            background-color: var(--primary-color);
            color: #ffffff !important;
            border: 1.5px solid var(--primary-color);
            border-radius: 30px;
            padding: 10px 24px;
            font-weight: 600;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            transition: all 0.3s ease;
        }

        .btn-stone-dark:hover {
            background-color: transparent;
            color: var(--primary-color) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Helper Classes Overrides */
        .bg-light, .bg-light-subtle {
            background-color: rgba(255, 255, 255, 0.3) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            color: var(--text-color) !important;
            border: 1px solid rgba(255, 255, 255, 0.4) !important;
        }
        .bg-white {
            background-color: rgba(255, 255, 255, 0.45) !important;
            backdrop-filter: blur(15px) !important;
            -webkit-backdrop-filter: blur(15px) !important;
            color: var(--text-color) !important;
            border: 1px solid rgba(255, 255, 255, 0.5) !important;
        }
        
        /* Text Color Overrides */
        .text-dark, .text-dark-emphasis {
            color: var(--primary-color) !important;
        }
        .text-muted, .text-secondary {
            color: var(--secondary-color) !important;
        }

        /* Form Controls */
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.5) !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            color: var(--text-color) !important;
            border-radius: 10px !important;
            transition: all 0.3s ease !important;
        }
        .form-control:focus, .form-select:focus {
            background-color: #FFFFFF !important;
            border-color: var(--accent-color) !important;
            color: var(--primary-color) !important;
            box-shadow: 0 0 10px rgba(197, 168, 128, 0.15) !important;
        }
        .form-control::placeholder {
            color: #999999 !important;
        }
        .form-control:disabled, .form-control[readonly] {
            background-color: rgba(255, 255, 255, 0.3) !important;
            color: #777777 !important;
            border-color: var(--border-color) !important;
        }

        /* Badges Styling */
        .badge.bg-primary {
            background-color: rgba(0, 123, 255, 0.1) !important;
            color: #007bff !important;
            border: 1px solid rgba(0, 123, 255, 0.2) !important;
            font-weight: 600;
        }
        .badge.bg-warning {
            background-color: rgba(255, 193, 7, 0.15) !important;
            color: #b58100 !important;
            border: 1px solid rgba(255, 193, 7, 0.3) !important;
            font-weight: 600;
        }
        .badge.bg-success {
            background-color: rgba(40, 167, 69, 0.1) !important;
            color: #28a745 !important;
            border: 1px solid rgba(40, 167, 69, 0.2) !important;
            font-weight: 600;
        }
        .badge.bg-info {
            background-color: rgba(23, 162, 184, 0.1) !important;
            color: #17a2b8 !important;
            border: 1px solid rgba(23, 162, 184, 0.2) !important;
            font-weight: 600;
        }
        .badge.bg-danger {
            background-color: rgba(220, 53, 69, 0.1) !important;
            color: #dc3545 !important;
            border: 1px solid rgba(220, 53, 69, 0.2) !important;
            font-weight: 600;
        }
        .badge.bg-light {
            background-color: rgba(255, 255, 255, 0.45) !important;
            border: 1px solid rgba(0, 0, 0, 0.08) !important;
            color: var(--primary-color) !important;
        }

        /* Floating background blobs animations */
        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.35;
            animation: float 25s infinite alternate ease-in-out;
            pointer-events: none;
            z-index: -1;
        }
        @keyframes float {
            0% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }
            100% {
                transform: translate(80px, 50px) scale(1.2) rotate(180deg);
            }
        }

        /* Modal styling */
        .modal-content {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(25px) saturate(180%);
            -webkit-backdrop-filter: blur(25px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.4) !important;
        }

        /* List Group Item styling */
        .list-group-item {
            background-color: transparent !important;
            border-color: rgba(0, 0, 0, 0.05) !important;
            color: var(--text-color) !important;
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Glowing fluid blurs (Liquid Glass effect) -->
    <div class="blob-container" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; overflow: hidden; pointer-events: none;">
        <div class="blob" style="background-color: #E2C799; width: 50vw; height: 50vw; top: -10%; left: -15%; opacity: 0.32;"></div>
        <div class="blob" style="background-color: #D3E0EA; width: 45vw; height: 45vw; bottom: -5%; right: -10%; opacity: 0.35; animation-delay: -5s;"></div>
        <div class="blob" style="background-color: #E2C799; width: 30vw; height: 30vw; top: 50%; left: 75%; opacity: 0.2; animation-delay: -10s;"></div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand d-flex align-items-center">
            
            <div class="d-flex flex-column">
                <span class="brand-title fw-bold text-dark mb-0" style="font-size: 1.15rem; line-height: 1.2; letter-spacing: 0.5px;">Berkah Alam</span>
                <span class="brand-subtitle text-secondary fw-semibold" style="font-size: 0.72rem; letter-spacing: 0.5px; text-transform: uppercase;">Memorial</span>
            </div>
        </div>
        
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
            
            <li class="sidebar-item mt-4">
                <span class="text-uppercase px-3 small fw-bold" style="font-size: 0.75rem; letter-spacing: 1px; color: #C5A059;">Katalog & Transaksi</span>
            </li>
            
            <li class="sidebar-item">
                <a href="{{ route('admin.produk.index') }}" class="sidebar-link {{ Route::is('admin.produk.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Kelola Produk
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.pesanan.index') }}" class="sidebar-link {{ Route::is('admin.pesanan.*') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> Kelola Pesanan
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.customer.index') }}" class="sidebar-link {{ Route::is('admin.customer.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Data Customer
                </a>
            </li>

            <li class="sidebar-item mt-4">
                <span class="text-uppercase px-3 small fw-bold" style="font-size: 0.75rem; letter-spacing: 1px; color: #C5A059;">CMS</span>
            </li>
            <li class="sidebar-item">
                <a href="{{ route('admin.hero.index') }}" class="sidebar-link {{ Route::is('admin.hero.*') ? 'active' : '' }}">
                    <i class="bi bi-image"></i> Hero & Tentang Kami
                </a>
            </li>


        </ul>

        <div class="mt-auto border-top border-light-subtle pt-3" style="border-top: 1px solid rgba(0, 0, 0, 0.08) !important;">
            <div class="d-flex align-items-center mb-3 px-3">
                <div class="me-2">
                    <i class="bi bi-person-circle fs-3 text-secondary"></i>
                </div>
                <div>
                    <h6 class="fw-bold mb-0 text-dark small">{{ Auth::user()->name }}</h6>
                    <span class="text-secondary small" style="font-size: 0.72rem;">Administrator</span>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <i class="bi bi-box-arrow-left me-2"></i> Log Out
                </button>
            </form>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Topbar -->
        <div class="topbar">
            <h5 class="fw-bold mb-0">Halaman Administrator</h5>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-secondary py-2 px-3">
                    <i class="bi bi-globe me-1"></i> Buka Website
                </a>
            </div>
        </div>

        <!-- Content Panel -->
        <div class="content-panel">
            @yield('content')
        </div>
    </div>

    <!-- JQuery, Bootstrap, and DataTables Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert Flash Messages -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: "{{ session('success') }}",
                confirmButtonColor: '#2D2D2D',
                timer: 3000
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: "{{ session('error') }}",
                confirmButtonColor: '#2D2D2D'
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#2D2D2D'
            });
        </script>
    @endif

    @yield('modals')
    @yield('scripts')
</body>
</html>
