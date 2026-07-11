@extends('layouts.app')

@section('title', 'BERKAH ALAM - Batu Nisan, Prasasti, & Ukiran Batu Alam Premium')

@section('styles')
<style>
    /* Hero Section */
    .hero-section {
        position: relative;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        overflow: hidden;
        color: #FFFFFF;
        text-align: center;
    }

    .hero-content {
        position: relative;
        z-index: 5;
        max-width: 850px;
        padding: 0 20px;
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .hero-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 4rem;
        font-weight: 600;
        line-height: 1.25;
        margin-bottom: 20px;
        color: #FFFFFF;
        letter-spacing: 0.5px;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    }

    .hero-title span {
        color: var(--accent-color);
        font-style: italic;
        font-weight: 500;
    }

    .hero-badge {
        font-family: 'Poppins', sans-serif;
        font-size: 0.75rem;
        letter-spacing: 2.5px;
        color: #FFFFFF;
        background: rgba(255, 255, 255, 0.15);
        border: 1.5px solid rgba(255, 255, 255, 0.4);
        padding: 8px 22px;
        text-transform: uppercase;
        font-weight: 600;
        border-radius: 30px;
        backdrop-filter: blur(5px);
        margin-bottom: 25px;
        display: inline-block;
    }

    .hero-subtitle {
        font-family: 'Poppins', sans-serif;
        font-size: 1.15rem;
        font-weight: 400;
        max-width: 650px;
        line-height: 1.8;
        color: rgba(255, 255, 255, 0.9);
        margin: 0 auto 35px;
        letter-spacing: 0.3px;
        text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
    }

    /* Outlined Button matching user reference */
    .btn-hero-outline {
        background-color: transparent;
        color: #FFFFFF !important;
        border-radius: 50px;
        padding: 14px 40px;
        font-family: 'Poppins', sans-serif;
        font-size: 0.9rem;
        letter-spacing: 2px;
        font-weight: 600;
        text-transform: uppercase;
        border: 2px solid #FFFFFF;
        transition: all 0.3s ease;
        display: inline-block;
        text-decoration: none;
    }

    .btn-hero-outline:hover {
        background-color: #FFFFFF;
        color: #1A1A1A !important;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Section Styling */
    section {
        padding: 100px 0;
        background-color: transparent;
        color: var(--text-color);
    }

    .section-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.6rem;
        font-weight: 500;
        color: var(--primary-color);
        position: relative;
        margin-bottom: 15px;
    }

    .section-title::after {
        content: '';
        display: block;
        width: 40px;
        height: 1.5px;
        background-color: var(--accent-color);
        margin-top: 15px;
    }

    .section-title.center::after {
        margin: 15px auto 0;
    }

    .section-subtitle {
        color: #555555;
        font-size: 1rem;
        max-width: 650px;
        margin-bottom: 60px;
    }

    /* Category Card */
    .category-card {
        background: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 40px 30px;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .category-card:hover {
        transform: translateY(-5px);
        border-color: var(--accent-color);
        background: #FFFFFF;
        box-shadow: 0 15px 35px rgba(197, 168, 128, 0.08);
    }

    .category-icon {
        font-size: 2.2rem;
        color: var(--accent-color);
        margin-bottom: 20px;
        transition: transform 0.3s ease;
    }

    .category-card:hover .category-icon {
        transform: scale(1.05);
    }

    /* Product Card */
    .product-card {
        background: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
    }

    .product-card:hover {
        transform: translateY(-5px);
        border-color: var(--accent-color);
        box-shadow: 0 15px 35px rgba(197, 168, 128, 0.08);
    }

    .product-img-wrapper {
        position: relative;
        height: 260px;
        overflow: hidden;
        background-color: #F8F9FA;
    }

    .product-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        background-color: #F8F9FA;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-img {
        transform: scale(1.03);
    }

    .product-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: var(--accent-color);
        color: #FFFFFF;
        border: none;
        font-size: 0.7rem;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 6px 12px;
        border-radius: 30px;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(197, 168, 128, 0.2);
    }

    .product-info {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        background: #FFFFFF;
        color: var(--text-color);
    }

    .product-info h5 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.4rem;
        color: var(--primary-color);
        margin-bottom: 10px;
        font-weight: 600;
    }

    .product-price {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--accent-color);
        margin-bottom: 15px;
    }

    /* Step Card */
    .step-card {
        text-align: center;
        position: relative;
    }

    .step-num {
        width: 50px;
        height: 50px;
        background-color: var(--accent-color);
        color: #FFFFFF;
        font-size: 1.25rem;
        font-weight: 700;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        border: none;
        box-shadow: 0 4px 10px rgba(197, 168, 128, 0.2);
    }

    /* FAQ Style */
    .accordion-item {
        background-color: #FFFFFF;
        border: 1px solid var(--border-color);
        border-radius: 12px !important;
        margin-bottom: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.01);
    }

    .accordion-button {
        font-weight: 600;
        color: var(--primary-color);
        background-color: #FFFFFF;
        padding: 20px;
        border: none;
    }

    .accordion-button:not(.collapsed) {
        background-color: #F8F9FA;
        color: var(--accent-color);
        box-shadow: none;
    }

    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(255, 255, 255, 0.1);
    }

    .accordion-body {
        padding: 20px;
        color: #A0A0A0;
        line-height: 1.6;
    }
</style>
@endsection

@section('content')

    <!-- Hero Section -->
    <section class="hero-section" style="background-image: linear-gradient(rgba(0, 0, 0, 0.45), rgba(0, 0, 0, 0.65)), url('{{ $heroes->isNotEmpty() && $heroes->first()->gambar ? asset($heroes->first()->gambar) : 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=1920&q=80' }}');">
        <div class="hero-content">
            <div class="mb-4 d-inline-block">
                <span class="hero-badge">Sejak 2000</span>
            </div>
            
            <h1 class="hero-title">
                Penghormatan <span>Berkah Alam</span><br>untuk yang Tercinta
            </h1>
            
            <p class="hero-subtitle">
                @if($heroes->isNotEmpty())
                    {{ $heroes->first()->subjudul }}
                @else
                    Batu nisan berkualitas tinggi dengan material pilihan dan ukiran presisi — sebuah kenangan yang layak untuk mereka.
                @endif
            </p>
            
            <div class="mt-4">
                <a href="#produk" class="btn-hero-outline">
                    Lihat Koleksi &nbsp;&darr;
                </a>
            </div>
        </div>
        
        <!-- Scroll Indicator -->
        <div class="d-flex flex-column align-items-center position-absolute bottom-0 start-50 translate-middle-x pb-4" style="z-index: 10;">
            <span style="font-family: 'Poppins', sans-serif; font-size: 0.75rem; letter-spacing: 3px; color: rgba(255, 255, 255, 0.6); text-transform: uppercase; font-weight: 500;">Scroll</span>
            <div style="width: 1px; height: 50px; background-color: rgba(255, 255, 255, 0.4); margin-top: 10px;"></div>
        </div>
    </section>

    <!-- Tentang Kami -->
    <section id="tentang" style="background-color: #FFFFFF; border-top: 1px solid var(--border-color);">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <img src="{{ $heroes->isNotEmpty() && $heroes->first()->tentang_gambar ? asset($heroes->first()->tentang_gambar) : 'https://cdn.pixabay.com/photo/2015/01/22/22/47/grave-608441_1280.jpg' }}" alt="Tentang Berkah Alam" class="img-fluid rounded-0 shadow-sm" style="max-height: 480px; width: 100%; object-fit: cover; border: 1px solid #ffffffff;">
                </div>
                <div class="col-lg-6">
                    <h6 class="text-uppercase fw-bold mb-2" style="letter-spacing: 2px; color: var(--accent-color); font-size: 0.8rem;">Tentang Kami</h6>
                    <h2 class="section-title">Dedikasi Seni Di Atas Batu Alam Abadi</h2>
                    <p style="color: #A0A0A0; line-height: 1.8; margin-bottom: 20px; text-align: justify;">
                        BERKAH ALAM adalah workshop kerajinan batu alam spesialis pembuat Batu Nisan, Prasasti Peresmian, Papan Nama Instansi, Monumen, serta berbagai ukiran relief batu alam kustom. Berdiri dengan komitmen menghadirkan kualitas terbaik bagi setiap pelanggan.
                    </p>
                    <p style="color: #A0A0A0; line-height: 1.8; margin-bottom: 30px;text-align: justify;">
                        Kami hanya menggunakan bahan baku batu alam pilihan seperti Granit Hitam (Black Nero), Marmer Putih Carrara, Batu Kali, hingga Batu Paras Jogja. Setiap goresan ukiran dikerjakan secara manual oleh pengrajin berpengalaman demi mencapai tingkat kedalaman, kerapian, dan estetika yang tinggi.
                    </p>
                    <div class="row g-3 pt-3 border-top border-secondary" style="border-color: var(--border-color) !important;">
                        <div class="col-6">
                            <h4 class="fw-bold mb-1" style="color: var(--primary-color); font-family: 'Cormorant Garamond', serif; font-size: 2rem;">100%</h4>
                            <p class="small mb-0" style="color: #8C8C8C;">Bahan Batu Alam Asli & Marmer Asli</p>
                        </div>
                        <div class="col-6">
                            <h4 class="fw-bold mb-1" style="color: var(--primary-color); font-family: 'Cormorant Garamond', serif; font-size: 2rem;">25+ Tahun</h4>
                            <p class="small mb-0" style="color: #8C8C8C;">Pengalaman Seni Ukir Batu</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Keunggulan -->
    <section style="background-color: #F8F9FA; border-top: 1px solid var(--border-color);">
        <div class="container">
            <div class="text-center">
                <h6 class="text-uppercase fw-bold mb-2" style="letter-spacing: 2px; color: var(--accent-color); font-size: 0.8rem;">Mengapa Kami</h6>
                <h2 class="section-title center">Keunggulan Berkah Alam</h2>
                <p class="section-subtitle mx-auto">Kami berfokus pada hasil karya yang tahan lama, estetis, dan bernilai seni tinggi.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <i class="bi bi-patch-check category-icon"></i>
                        <h5 class="fw-bold mb-2" style="font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; color: var(--primary-color);">Bahan Kualitas Terbaik</h5>
                        <p class="small mb-0" style="color: #8C8C8C;">Hanya menggunakan batu alam utuh tanpa sambungan.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <i class="bi bi-brush category-icon"></i>
                        <h5 class="fw-bold mb-2" style="font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; color: var(--primary-color);">Pahat Seni Manual</h5>
                        <p class="small mb-0" style="color: #8C8C8C;">Pengerjaan pahatan yang presisi oleh seniman ukir lokal.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <i class="bi bi-pencil-square category-icon"></i>
                        <h5 class="fw-bold mb-2" style="font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; color: var(--primary-color);">Desain Kustom</h5>
                        <p class="small mb-0" style="color: #8C8C8C;">Desain tulisan dan kaligrafi dapat disesuaikan keinginan.</p>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <i class="bi bi-box-seam category-icon"></i>
                        <h5 class="fw-bold mb-2" style="font-family: 'Cormorant Garamond', serif; font-size: 1.3rem; color: var(--primary-color);">Pengiriman Aman</h5>
                        <p class="small mb-0" style="color: #8C8C8C;">Proteksi kemasan kayu tebal ke seluruh Indonesia.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk Unggulan -->
    <section id="produk" style="background-color: #FFFFFF; border-top: 1px solid var(--border-color);">
        <div class="container">
            <div class="text-center">
                <h6 class="text-uppercase fw-bold mb-2" style="letter-spacing: 2px; color: var(--accent-color); font-size: 0.8rem;">Koleksi Produk</h6>
                <h2 class="section-title center">Karya Unggulan Kami</h2>
                <p class="section-subtitle mx-auto">Jelajahi produk batu alam terbaik yang siap kami pahat dengan detail tulisan kustom dari Anda.</p>
            </div>
            
            <div class="row g-4">
                @if($products->isNotEmpty())
                    @foreach($products as $product)
                        <div class="col-lg-4 col-md-6">
                            <div class="product-card">
                                <div class="product-img-wrapper">
                                    <span class="product-badge">{{ $product->kategori->nama }}</span>
                                    <img src="{{ asset($product->gambar) }}" class="product-img" alt="{{ $product->nama }}">
                                </div>
                                <div class="product-info">
                                    <h5 class="fw-bold mb-2">{{ $product->nama }}</h5>
                                    <p class="small text-truncate-2 mb-3" style="color: #8C8C8C; min-height: 48px;">{{ Str::limit($product->deskripsi, 100) }}</p>
                                    <div class="mt-auto">
                                        <div class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                                        <a href="{{ route('customer.produk.detail', $product->id) }}" class="btn btn-stone-outline w-100 py-2">Lihat Detail & Pesan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Fallback data -->
                    @php 
                        $fallback_prods = [
                            ['nama' => 'Batu Nisan Granit Hitam Book', 'harga' => 2500000, 'img' => 'https://images.unsplash.com/photo-1604147706283-d7119b5b822c?auto=format&fit=crop&w=600&q=80', 'cat' => 'Batu Nisan'],
                            ['nama' => 'Prasasti Peresmian Marmer Itali', 'harga' => 1500000, 'img' => 'https://images.unsplash.com/photo-1582139329536-e7284fece509?auto=format&fit=crop&w=600&q=80', 'cat' => 'Prasasti'],
                            ['nama' => 'Batu Nisan Dome Marmer Putih', 'harga' => 3200000, 'img' => 'https://images.unsplash.com/photo-1604147706283-d7119b5b822c?auto=format&fit=crop&w=600&q=80', 'cat' => 'Batu Nisan'],
                        ];
                    @endphp
                    @foreach($fallback_prods as $fp)
                        <div class="col-lg-4 col-md-6">
                            <div class="product-card">
                                <div class="product-img-wrapper">
                                    <span class="product-badge">{{ $fp['cat'] }}</span>
                                    <img src="{{ $fp['img'] }}" class="product-img" alt="{{ $fp['nama'] }}">
                                </div>
                                <div class="product-info">
                                    <h5 class="fw-bold mb-2">{{ $fp['nama'] }}</h5>
                                    <p class="small mb-3" style="color: #8C8C8C; min-height: 48px;">Pahatan tulisan dilapisi cat emas metalik berkualitas tinggi yang awet bertahun-tahun di luar ruangan.</p>
                                    <div class="mt-auto">
                                        <div class="product-price">Rp {{ number_format($fp['harga'], 0, ',', '.') }}</div>
                                        <a href="{{ route('register') }}" class="btn btn-stone-outline w-100 py-2">Daftar untuk Memesan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- Alur Pemesanan -->
    <section style="background-color: #F8F9FA; border-top: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color);">
        <div class="container">
            <div class="text-center">
                <h6 class="text-uppercase fw-bold mb-2" style="letter-spacing: 2px; color: var(--accent-color); font-size: 0.8rem;">Alur Transaksi</h6>
                <h2 class="section-title center">Cara Melakukan Pemesanan</h2>
                <p class="section-subtitle mx-auto">Ikuti langkah mudah berikut untuk memesan nisan atau prasasti kustom.</p>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <div class="step-card">
                        <div class="step-num">1</div>
                        <h5 class="fw-bold" style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; color: var(--primary-color); margin-bottom: 10px;">Registrasi Akun</h5>
                        <p class="small" style="color: #8C8C8C;">Daftarkan diri Anda untuk masuk ke sistem pesanan kami.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="step-card">
                        <div class="step-num">2</div>
                        <h5 class="fw-bold" style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; color: var(--primary-color); margin-bottom: 10px;">Pilih Produk</h5>
                        <p class="small" style="color: #8C8C8C;">Pilih ukuran dan jenis bahan (marmer, granit hitam) yang disukai.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="step-card">
                        <div class="step-num">3</div>
                        <h5 class="fw-bold" style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; color: var(--primary-color); margin-bottom: 10px;">Tulis Teks Nisan</h5>
                        <p class="small" style="color: #8C8C8C;">Isi catatan ukiran (contoh: Nama Almarhum, bin/binti, Lahir & Wafat).</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="step-card">
                        <div class="step-num">4</div>
                        <h5 class="fw-bold" style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; color: var(--primary-color); margin-bottom: 10px;">Unggah Bukti Bayar</h5>
                        <p class="small" style="color: #8C8C8C;">Transfer pembayaran dan unggah bukti transfer agar pesanan diproses.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni section removed -->

    <!-- FAQ & Kontak sections removed -->

@endsection
