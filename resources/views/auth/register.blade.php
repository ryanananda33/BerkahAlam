@extends('layouts.auth')

@section('title', 'Register - BERKAH ALAM')

@section('content')
    <h2>Buat Akun Baru</h2>
    <p class="subtitle">Daftarkan diri Anda untuk mulai melakukan pemesanan.</p>

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

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="input-group-glass">
            <i class="bi bi-person"></i>
            <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" value="{{ old('name') }}" required autocomplete="name">
        </div>

        <!-- Email Address -->
        <div class="input-group-glass">
            <i class="bi bi-envelope"></i>
            <input type="email" name="email" class="form-control" placeholder="Email Address" value="{{ old('email') }}" required autocomplete="username">
        </div>

        <!-- Phone Number -->
        <div class="input-group-glass">
            <i class="bi bi-telephone"></i>
            <input type="text" name="phone" class="form-control" placeholder="Nomor Telepon (WhatsApp)" value="{{ old('phone') }}" required>
        </div>

        <!-- Address -->
        <div class="input-group-glass">
            <i class="bi bi-geo-alt"></i>
            <input type="text" name="address" class="form-control" placeholder="Alamat Lengkap" value="{{ old('address') }}" required>
        </div>

        <!-- Password -->
        <div class="input-group-glass">
            <i class="bi bi-lock"></i>
            <input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="new-password">
        </div>

        <!-- Confirm Password -->
        <div class="input-group-glass">
            <i class="bi bi-lock-fill"></i>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Konfirmasi Password" required autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-auth-primary">
            Daftar Sekarang
        </button>
    </form>

    <div class="auth-footer">
        Sudah punya akun? <a href="{{ route('login') }}">Masuk sekarang</a>
    </div>
@endsection
