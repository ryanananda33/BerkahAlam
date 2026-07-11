@extends('layouts.auth')

@section('title', 'Login - BERKAH ALAM')

@section('content')
    <h2>Selamat Datang Kembali</h2>
    <p class="subtitle">Silakan masuk untuk melanjutkan pemesanan batu nisan dan prasasti.</p>

    <!-- Error validation banner -->
    @if ($errors->any())
        <div class="alert alert-danger border-0 text-white py-2 px-3 mb-4" style="background: rgba(220, 53, 69, 0.2); backdrop-filter: blur(5px); border-radius: 12px; font-size: 0.85rem;">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="input-group-glass">
            <i class="bi bi-envelope"></i>
            <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required autofocus autocomplete="username">
        </div>

        <!-- Password -->
        <div class="input-group-glass">
            <i class="bi bi-lock"></i>
            <input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="current-password">
        </div>

        <!-- Remember Me -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                <label class="form-check-label" for="remember_me">
                    Ingat saya
                </label>
            </div>
        </div>

        <button type="submit" class="btn btn-auth-primary">
            Masuk
        </button>
    </form>

    <div class="auth-footer">
        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>
@endsection
