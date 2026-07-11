<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentication - BERKAH ALAM')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --accent-color: #C5A059; /* Metallic Champagne Gold */
            --accent-hover: #B28F4B;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #F8F9FA;
            min-height: 100vh;
            overflow-x: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Glassmorphism Background & Blurs */
        .background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0.35)),
                url('https://cdn.pixabay.com/photo/2015/01/22/22/47/grave-608441_1280.jpg');
            background-size: cover;
            background-position: center;
            filter: blur(6px); 
            transform: scale(1.05);
            z-index: 1;
        }

        /* Liquid Light Blurs (VisionOS effect) */
        .blob-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 2;
            pointer-events: none;
        }

        .blob {
            position: absolute;
            border-radius: 50%;
            filter: blur(120px);
            opacity: 0.38; /* Highly visible liquid blurs */
            animation: float 20s infinite alternate ease-in-out;
        }

        .blob-gold {
            background-color: #E2C799;
            width: 50vw;
            height: 50vw;
            top: -15%;
            left: -5%;
        }

        .blob-white {
            background-color: #D3E0EA;
            width: 45vw;
            height: 45vw;
            bottom: -10%;
            right: -5%;
            animation-delay: -5s;
        }

        @keyframes float {
            0% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }
            100% {
                transform: translate(80px, 50px) scale(1.2) rotate(180deg);
            }
        }

        /* Form Card */
        .auth-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
            padding: 20px;
            animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .auth-card {
            background: rgba(255, 255, 255, 0.45) !important;
            backdrop-filter: blur(25px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(25px) saturate(180%) !important;
            border: 1px solid rgba(255, 255, 255, 0.6) !important;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.04) !important;
            position: relative;
            overflow: hidden;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-logo {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: 1.6rem;
            color: #1A1A1A;
            letter-spacing: 1.5px;
            margin-bottom: 24px;
            text-align: center;
        }

        .auth-logo a {
            color: #1A1A1A !important;
        }

        .auth-logo span {
            color: var(--accent-color);
        }

        .auth-card h2 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            color: #1A1A1A;
            font-size: 1.8rem;
            margin-bottom: 6px;
            text-align: center;
        }

        .auth-card p.subtitle {
            color: #6C757D;
            font-size: 0.9rem;
            margin-bottom: 30px;
            text-align: center;
            line-height: 1.5;
        }

        /* Inputs Glassmorphism */
        .input-group-glass {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group-glass i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #8C8C8C;
            z-index: 10;
            font-size: 1.1rem;
        }

        .input-group-glass .form-control {
            background: rgba(255, 255, 255, 0.5) !important;
            border: 1px solid rgba(0, 0, 0, 0.1) !important;
            border-radius: 12px;
            color: #1A1A1A;
            padding: 14px 16px 14px 48px;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }

        .input-group-glass .form-control::placeholder {
            color: #999999;
        }

        .input-group-glass .form-control:focus {
            background: #FFFFFF !important;
            border-color: var(--accent-color) !important;
            box-shadow: 0 0 10px rgba(197, 168, 128, 0.15) !important;
            color: #1A1A1A;
        }

        /* Primary button clean monochrome */
        .btn-auth-primary {
            background-color: var(--accent-color);
            color: #FFFFFF;
            border: none;
            border-radius: 12px;
            padding: 14px 20px;
            font-weight: 600;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-auth-primary:hover {
            background-color: var(--accent-hover);
            color: #FFFFFF;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(197, 168, 128, 0.25);
        }

        .auth-footer {
            margin-top: 25px;
            text-align: center;
            font-size: 0.85rem;
            color: #555555;
        }

        .auth-footer a {
            color: var(--accent-color);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .auth-footer a:hover {
            color: var(--accent-hover);
            text-decoration: underline;
        }

        /* Checkbox styling */
        .form-check-label {
            color: #555555;
            font-size: 0.85rem;
        }

        .form-check-input {
            background-color: rgba(255, 255, 255, 0.5);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .form-check-input:checked {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
    </style>
</head>
<body>

    <!-- Blurred background workshop -->
    <div class="background-overlay"></div>

    <!-- Glowing fluid blurs -->
    <div class="blob-container">
        <div class="blob blob-gold"></div>
        <div class="blob blob-white"></div>
    </div>

    <!-- Card container -->
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <a href="{{ route('home') }}" class="text-decoration-none text-dark">
                    <i class="bi bi-gem me-2"></i>BERKAH <span>ALAM</span>
                </a>
            </div>
            
            @yield('content')
            
        </div>
    </div>

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
</body>
</html>
