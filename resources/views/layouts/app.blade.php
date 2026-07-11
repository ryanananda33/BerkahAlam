<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BERKAH ALAM - Batu Nisan & Prasasti Premium')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary-color: #1A1A1A;
            --secondary-color: #6C757D;
            --background-color: #F8F9FA; /* Softer background to highlight glass */
            --surface-color: rgba(255, 255, 255, 0.55);
            --border-color: rgba(255, 255, 255, 0.5);
            --accent-color: #C5A059; /* Richer Champagne Gold */
            --text-color: #333333;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        h1, h2, h3, h4, h5, h6, .display-font {
            font-family: 'Cormorant Garamond', serif;
            color: var(--primary-color);
            font-weight: 600;
        }

        /* Navbar Styling */
        .navbar {
            background-color: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(25px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(25px) saturate(180%) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.4) !important;
            padding: 20px 0;
            transition: all 0.3s ease;
        }
        
        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 500;
            font-size: 1.6rem;
            letter-spacing: 0.5px;
            color: var(--primary-color) !important;
        }
        
        .navbar-brand span {
            color: var(--accent-color);
            font-style: italic;
            font-weight: 500;
        }

        .nav-link {
            color: #555555 !important;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 6px 20px !important;
            transition: color 0.3s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--accent-color) !important;
        }

        /* Buttons Custom */
        .btn-stone-primary {
            background-color: var(--accent-color);
            color: #FFFFFF !important;
            border-radius: 50px;
            padding: 10px 28px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            letter-spacing: 1.5px;
            font-weight: 600;
            text-transform: uppercase;
            border: 1.5px solid var(--accent-color);
            transition: all 0.3s ease;
        }

        .btn-stone-primary:hover {
            background-color: transparent;
            border-color: var(--accent-color);
            color: var(--accent-color) !important;
            transform: none;
            box-shadow: 0 5px 15px rgba(197, 168, 128, 0.2);
        }

        .btn-stone-outline {
            background-color: transparent;
            color: var(--accent-color) !important;
            border-radius: 50px;
            padding: 10px 28px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            letter-spacing: 1.5px;
            font-weight: 600;
            text-transform: uppercase;
            border: 1.5px solid var(--accent-color);
            transition: all 0.3s ease;
        }

        .btn-stone-outline:hover {
            background-color: var(--accent-color);
            color: #FFFFFF !important;
            transform: none;
            box-shadow: 0 5px 15px rgba(197, 168, 128, 0.2);
        }

        .btn-stone-accent {
            background-color: var(--accent-color);
            color: #FFFFFF !important;
            border-radius: 50px;
            padding: 10px 28px;
            font-family: 'Poppins', sans-serif;
            font-size: 0.8rem;
            letter-spacing: 1.5px;
            font-weight: 600;
            text-transform: uppercase;
            border: 1.5px solid var(--accent-color);
            transition: all 0.3s ease;
        }

        .btn-stone-accent:hover {
            background-color: transparent;
            border-color: var(--accent-color);
            color: var(--accent-color) !important;
            transform: none;
            box-shadow: 0 5px 15px rgba(197, 168, 128, 0.2);
        }

        /* Footer */
        footer {
            background-color: rgba(248, 249, 250, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            color: #555555;
            padding: 80px 0 40px;
            margin-top: auto;
            border-top: 1px solid var(--border-color);
            font-size: 0.9rem;
        }

        footer h5 {
            color: var(--primary-color);
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 25px;
        }

        footer a {
            color: #555555;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: var(--accent-color);
        }

        .social-box {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border: 1px solid var(--border-color);
            color: #555555;
            transition: all 0.3s ease;
            margin-right: 8px;
            font-size: 1.1rem;
            text-decoration: none;
        }

        .social-box:hover {
            border-color: var(--accent-color);
            color: var(--accent-color);
            background-color: rgba(197, 168, 128, 0.05);
        }

        /* Premium Card style */
        .premium-card {
            background: var(--surface-color) !important;
            border: 1px solid var(--border-color) !important;
            backdrop-filter: blur(25px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(25px) saturate(180%) !important;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            transition: all 0.3s ease;
        }

        .premium-card:hover {
            border-color: var(--accent-color) !important;
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(197, 168, 128, 0.08);
        }

        /* Table Styling */
        .table {
            --bs-table-color: var(--text-color) !important;
            --bs-table-bg: transparent !important;
            --bs-table-border-color: var(--border-color) !important;
            color: var(--text-color) !important;
        }
        .table th, .table td {
            background-color: transparent !important;
            border-bottom-color: var(--border-color) !important;
            color: var(--text-color) !important;
        }
        .table-responsive {
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.45);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 12px;
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
        .form-control {
            background-color: rgba(255, 255, 255, 0.5) !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            color: var(--text-color) !important;
            border-radius: 10px !important;
            transition: all 0.3s ease !important;
        }
        .form-control:focus {
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
            background-color: rgba(197, 168, 128, 0.15) !important;
            color: var(--accent-color) !important;
            border: 1px solid rgba(197, 168, 128, 0.3) !important;
            font-weight: 600;
        }
        .badge.bg-warning {
            background-color: rgba(197, 168, 128, 0.15) !important;
            color: var(--accent-color) !important;
            border: 1px solid rgba(197, 168, 128, 0.3) !important;
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
        .badge.bg-secondary-subtle {
            background-color: rgba(197, 168, 128, 0.1) !important;
            color: var(--accent-color) !important;
            border: 1px solid rgba(197, 168, 128, 0.2) !important;
            font-weight: 600;
        }
        .badge.text-dark {
            color: var(--accent-color) !important;
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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                Berkah Alam&nbsp;<span>Memorial</span>
            </a>
            <button class="navbar-toggler border-0 text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <i class="bi bi-list fs-2"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#produk">Katalog</a>
                    </li>
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-stone-primary py-2 px-4">
                                    Admin Panel
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('customer.dashboard') }}" class="btn btn-stone-primary py-2 px-4">
                                    Dashboard
                                </a>
                            </li>
                        @endif
                        <li class="nav-item ms-2">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-stone-outline py-2 px-3">
                                    <i class="bi bi-box-arrow-right"></i>
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="btn btn-stone-outline py-2 px-4">Login / Register</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-5 col-md-6">
                    <h5 class="fw-bold d-flex align-items-center" style="font-family: 'Cormorant Garamond', serif; font-size: 1.5rem; letter-spacing: 0.5px; color: #000000ff; text-transform: none; margin-bottom: 20px;">
                        Berkah Alam&nbsp;<span style="color: var(--accent-color); font-style: italic; font-weight: 500;">Memorial</span>
                    </h5>
                    <p class="text-secondary-emphasis mb-0" style="color: #8C8C8C !important; font-size: 0.9rem; line-height: 1.7; max-width: 380px;">
                        Mewujudkan penghormatan terindah untuk orang-orang yang Anda cintai, dengan keahlian dan dedikasi penuh.
                    </p>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h5>Informasi</h5>
                    <ul class="list-unstyled mb-0" style="font-size: 0.9rem; line-height: 1.8;">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="bi bi-geo-alt me-3 text-warning fs-5" style="color: var(--accent-color) !important; margin-top: -2px;"></i>
                            <span style="color: #A0A0A0;">Jl. Raya Desa Nanggerang , Kec. Jalaksana , Kabupaten Kuningan, Jawa Barat 45556</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-clock me-3 text-warning fs-5" style="color: var(--accent-color) !important;"></i>
                            <span style="color: #A0A0A0;">Weekday 08.00-17.00 - Weekend 09.00-15.00</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-telephone me-3 text-warning fs-5" style="color: var(--accent-color) !important;"></i>
                            <span style="color: #A0A0A0;">0814-6892-0234</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-envelope me-3 text-warning fs-5" style="color: var(--accent-color) !important;"></i>
                            <span style="color: #A0A0A0;">berkahalam@gmail.com</span>
                        </li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>Ikuti Kami</h5>
                    <div class="d-flex mt-3">
                        <a href="#" class="social-box"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-box"><i class="bi bi-tiktok"></i></a>
                        <a href="https://wa.me/6281461143708" class="social-box"><i class="bi bi-whatsapp"></i></a>
                        <a href="#" class="social-box"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary mt-5 mb-4" style="border-color: #1A1A1A !important;">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0" style="color: #555555; font-size: 0.85rem;">&copy; 2026 Berkah Alam Memorial. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end mt-2 mt-md-0">
                    <p class="mb-0" style="color: #555555; font-size: 0.85rem;">Crafted with care & precision.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

    @yield('scripts')
</body>
</html>
