@extends('layouts.app')

@section('title', 'Profil Saya - BERKAH ALAM')

@section('content')
<div class="container py-5" style="margin-top: 20px;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Breadcrumbs / Back button -->
            <a href="{{ route('customer.dashboard') }}" class="btn btn-stone-outline mb-4 py-2 px-3">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
            </a>

            <!-- Profile Form Card -->
            <div class="premium-card p-5">
                <h3 class="fw-bold mb-1"><i class="bi bi-person-gear me-2 text-stone-accent"></i>Pengaturan Profil</h3>
                <p class="text-secondary mb-4">Perbarui informasi kontak dan alamat pengiriman Anda.</p>

                <form method="POST" action="{{ route('customer.profile.update') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label text-muted small fw-semibold">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control py-2 @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email (Disabled for safety, but showing) -->
                    <div class="mb-3">
                        <label for="email" class="form-label text-muted small fw-semibold">Alamat Email (Akun)</label>
                        <input type="email" id="email" class="form-control py-2 bg-light text-muted" value="{{ $user->email }}" disabled>
                        <span class="form-text text-muted" style="font-size: 0.75rem;">Email akun tidak dapat diubah.</span>
                    </div>

                    <!-- Phone (WhatsApp) -->
                    <div class="mb-3">
                        <label for="phone" class="form-label text-muted small fw-semibold">Nomor Telepon / WhatsApp</label>
                        <input type="text" name="phone" id="phone" class="form-control py-2 @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="mb-4">
                        <label for="address" class="form-label text-muted small fw-semibold">Alamat Pengiriman (Pengiriman Batu Nisan)</label>
                        <textarea name="address" id="address" class="form-control py-2 @error('address') is-invalid @enderror" rows="4" placeholder="Masukkan alamat lengkap pengiriman untuk pengiriman kemasan peti kayu...">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action button -->
                    <button type="submit" class="btn btn-stone-accent w-100 py-3">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
