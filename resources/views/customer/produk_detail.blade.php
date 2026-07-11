@extends('layouts.app')

@section('title', $product->nama . ' - BERKAH ALAM')

@section('content')
<div class="container py-5" style="margin-top: 20px;">
    <!-- Back Button -->
    <a href="{{ route('home') }}#produk" class="btn btn-stone-outline mb-5 py-2 px-3">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Produk
    </a>

    <div class="row g-5">
        <!-- Product Image -->
        <div class="col-lg-6">
            <div class="premium-card p-3 bg-white" style="border-radius: 20px; overflow: hidden;">
                @if($product->gambar)
                    <img src="{{ asset($product->gambar) }}" class="img-fluid rounded-3 w-100" style="max-height: 500px; object-fit: contain; background-color: #F8F9FA;" alt="{{ $product->nama }}">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center text-muted" style="height: 400px; border-radius: 12px;">
                        <i class="bi bi-gem fs-1"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Information & Order Form -->
        <div class="col-lg-6">
            <div class="d-flex flex-column h-100">
                <div class="mb-4">
                    <span class="badge bg-secondary-subtle text-dark-emphasis px-3 py-2 rounded-pill mb-2">
                        Kategori: {{ $product->kategori->nama }}
                    </span>
                    <h1 class="fw-bold text-black    display-5 mb-2">{{ $product->nama }}</h1>
                    
                    <div class="product-price fs-2 fw-bold text-stone-accent mb-3">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </div>
                    
                    <div class="mb-3">
                        @if($product->stok > 0)
                            <span class="text-success fw-semibold"><i class="bi bi-check-circle-fill me-1"></i> Stok Tersedia ({{ $product->stok }} pcs)</span>
                        @else
                            <span class="text-danger fw-semibold"><i class="bi bi-x-circle-fill me-1"></i> Stok Habis</span>
                        @endif
                    </div>
                    
                    <hr class="border-secondary-subtle">
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold mb-2">Deskripsi Produk</h5>
                    <p class="text-secondary" style="font-size: 0.95rem; line-height: 1.7;">
                        {{ $product->deskripsi ?: 'Produk kerajinan batu alam berkualitas premium yang dipahat oleh pengrajin berpengalaman di workshop Berkah Alam. Bahan batu tahan cuaca luar ruangan dan tulisan dilapisi cat emas yang tahan pudar.' }}
                    </p>
                </div>

                <!-- Order Form -->
                @auth
                    @if(Auth::user()->role === 'customer')
                        @if($product->stok > 0)
                            <div class="premium-card p-4 bg-light-subtle border-accent">
                                <h5 class="fw-bold mb-3"><i class="bi bi-pencil-fill me-2 text-stone-accent"></i>Form Kustom Pemesanan</h5>
                                
                                <form method="POST" action="{{ route('customer.order.store', $product->id) }}">
                                    @csrf

                                    <!-- Qty -->
                                    <div class="mb-3">
                                        <label for="qty" class="form-label text-muted small fw-semibold">Jumlah Pesanan (Pcs)</label>
                                        <input type="number" name="qty" id="qty" class="form-control py-2 w-25" value="1" min="1" max="{{ $product->stok }}" required>
                                    </div>

                                    <!-- Catatan Ukiran -->
                                    <div class="mb-3">
                                        <label for="catatan_ukiran" class="form-label text-muted small fw-semibold">Teks Ukiran Nisan / Prasasti</label>
                                        <textarea name="catatan_ukiran" id="catatan_ukiran" class="form-control py-2" rows="4" placeholder="Contoh untuk batu nisan:&#10;Nama: Alm. Ahmad Fauzi&#10;Lahir: Jakarta, 12 Jan 1960&#10;Wafat: Bandung, 24 Feb 2024&#10;Bin: H. Ibrahim"></textarea>
                                        <span class="form-text text-muted" style="font-size: 0.75rem;">
                                            Tuliskan detail teks yang akan diukir di batu nisan atau prasasti dengan teliti. Tim kami akan melakukan konfirmasi ulang sebelum pemahatan dimulai.
                                        </span>
                                    </div>

                                    <!-- Alamat Pengiriman -->
                                    <div class="mb-4">
                                        <label for="alamat" class="form-label text-muted small fw-semibold">Alamat Pengiriman</label>
                                        <textarea name="alamat" id="alamat" class="form-control py-2 @error('alamat') is-invalid @enderror" rows="3" placeholder="Masukkan alamat lengkap pengiriman nisan/prasasti..." required>{{ old('alamat', Auth::user()->address) }}</textarea>
                                        @error('alamat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-stone-accent w-100 py-3">
                                        <i class="bi bi-cart-plus me-2"></i>Buat Pesanan Sekarang
                                    </button>
                                </form>
                            </div>
                        @else
                            <div class="alert alert-warning py-3" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i> Maaf, produk ini sedang tidak tersedia untuk dipesan. Silakan hubungi kami untuk informasi ketersediaan.
                            </div>
                        @endif
                    @else
                        <div class="alert alert-info py-3" role="alert">
                            <i class="bi bi-info-circle me-2"></i> Anda login sebagai Admin. Silakan gunakan akun Customer untuk memesan produk.
                        </div>
                    @endif
                @else
                    <div class="premium-card p-4 text-center">
                        <p class="text-secondary mb-3">Silakan login atau daftar akun untuk melakukan pemesanan nisan secara kustom.</p>
                        <div class="d-flex justify-content-center gap-2">
                            <a href="{{ route('login') }}" class="btn btn-stone-primary">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-stone-outline">Daftar</a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
