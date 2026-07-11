@extends('layouts.app')

@section('title', 'Pembayaran Pesanan - BERKAH ALAM')

@section('content')
<div class="container py-5" style="margin-top: 20px;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Back Button -->
            <a href="{{ route('customer.dashboard') }}" class="btn btn-stone-outline mb-4 py-2 px-3">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
            </a>

            <!-- Payment Instructions Card -->
            <div class="premium-card p-5 mb-4">
                <h3 class="fw-bold mb-1"><i class="bi bi-credit-card me-2 text-stone-accent"></i>Informasi Pembayaran</h3>
                <p class="text-secondary mb-4">Silakan lakukan transfer sesuai jumlah tagihan ke rekening bank resmi kami di bawah ini.</p>

                <div class="bg-light p-4 rounded-3 mb-4">
                    <div class="row align-items-center g-3">
                        <div class="col-sm-6">
                            <span class="text-muted small d-block">ID PESANAN</span>
                            <span class="fw-bold fs-5 black-white">#BA-{{ $order->id }}</span>
                        </div>
                        <div class="col-sm-6 text-sm-end">
                            <span class="text-muted small d-block">TOTAL TAGIHAN</span>
                            <span class="fw-bold fs-4 text-stone-accent">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <h5 class="fw-bold mb-3">Pilihan Rekening Transfer:</h5>
                <div class="border rounded-3 p-3 mb-3 bg-white d-flex align-items-center justify-content-between">
                    <div>
                        <span class="badge bg-primary px-3 py-1 mb-2">BANK BCA</span>
                        <h6 class="fw-bold mb-1" style="font-size: 1.1rem;">8605-234-990</h6>
                        <span class="text-muted small">Atas Nama: <strong>CV. BERKAH ALAM INDONESIA</strong></span>
                    </div>
                    <i class="bi bi-bank fs-1 text-muted"></i>
                </div>
                <div class="border rounded-3 p-3 mb-4 bg-white d-flex align-items-center justify-content-between">
                    <div>
                        <span class="badge bg-warning text-dark px-3 py-1 mb-2">BANK MANDIRI</span>
                        <h6 class="fw-bold mb-1" style="font-size: 1.1rem;">137-00-123456-7</h6>
                        <span class="text-muted small">Atas Nama: <strong>CV. BERKAH ALAM INDONESIA</strong></span>
                    </div>
                    <i class="bi bi-bank fs-1 text-muted"></i>
                </div>
            </div>

            <!-- Upload Form Card -->
            <div class="premium-card p-5">
                <h4 class="fw-bold mb-1"><i class="bi bi-upload me-2 text-stone-accent"></i>Unggah Bukti Transfer</h4>
                <p class="text-secondary mb-4">Unggah file foto / tangkapan layar bukti transfer ATM atau M-Banking Anda.</p>

                <form method="POST" action="{{ route('customer.pembayaran.store', $order->id) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <label for="bukti_pembayaran" class="form-label text-muted small fw-semibold">Pilih File Foto Bukti Pembayaran</label>
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control py-2 @error('bukti_pembayaran') is-invalid @enderror" required accept="image/*">
                        <span class="form-text text-muted" style="font-size: 0.75rem;">Format file: JPG, JPEG, atau PNG. Maksimum ukuran file: 10MB.</span>
                        @error('bukti_pembayaran')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-stone-accent w-100 py-3">
                        <i class="bi bi-send-fill me-2"></i>Kirim Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
