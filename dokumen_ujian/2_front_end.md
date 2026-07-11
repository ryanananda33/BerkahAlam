# FILE 2: SCRIPT DAN UI FRONT END
**Sistem Informasi UMKM Berkah Alam**

Dokumen ini menjelaskan struktur, script, dan antarmuka pengguna (UI) bagian Front End yang diakses oleh Customer dan Pengunjung Umum (Guest) pada sistem informasi UMKM Berkah Alam.

---

## 1. Rute dan Struktur Front End

Semua tampilan depan dikelompokkan dan dilindungi menggunakan routing Laravel di dalam `routes/web.php`. Berikut rute-rute utama Front End:

| URL/Endpoint | Controller & Method | Keterangan | Hak Akses |
| :--- | :--- | :--- | :--- |
| `/` | `LandingPageController@index` | Halaman katalog produk, hero banner, galeri, dan testimoni | Publik |
| `/login` | `AuthController@showLogin` | Halaman form masuk bagi pengguna | Guest |
| `/register` | `AuthController@showRegister` | Halaman form pendaftaran akun customer | Guest |
| `/customer/dashboard` | `CustomerController@dashboard` | Area dashboard daftar riwayat transaksi customer | Customer |
| `/customer/produk/{id}`| `OrderController@showProductDetail` | Detail produk batu alam & form kustom teks ukiran | Customer/Publik |
| `/customer/pesanan/{id}/pembayaran` | `CustomerController@uploadPaymentForm` | Form upload bukti transfer bank pembayaran | Customer |

---

## 2. Layout Utama (`resources/views/layouts/app.blade.php`)

Halaman Front End menggunakan satu layout dasar terpadu untuk memastikan konsistensi navigasi (Navbar), kaki halaman (Footer), pemanggilan asset CSS Bootstrap 5, ikon Bootstrap, dan SweetAlert2 untuk notifikasi.

### Potongan Penting Layout:
```html
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BERKAH ALAM - Batu Nisan & Prasasti Premium')</title>
    <!-- Google Fonts: Cormorant Garamond (Elegansi Klasik) & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons & SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --primary-color: #1A1A1A;
            --accent-color: #C5A059; /* Champagne Gold (Elemen Premium) */
            --background-color: #F8F9FA;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--background-color); }
        h1, h2, h3, .display-font { font-family: 'Cormorant Garamond', serif; font-weight: 600; }
        .navbar {
            background-color: rgba(255, 255, 255, 0.7) !important;
            backdrop-filter: blur(25px); /* Efek Kaca Glassmorphism */
            border-bottom: 1px solid rgba(255, 255, 255, 0.4) !important;
        }
    </style>
</head>
<body>
    @include('layouts.navbar') <!-- Navigasi Terpadu -->

    <main class="flex-grow-1">
        @yield('content') <!-- Tempat Meletakkan Konten Spesifik Halaman -->
    </main>

    @include('layouts.footer') <!-- Footer Informasi Workshop -->
</body>
</html>
```

---

## 3. Tampilan Halaman Utama (`resources/views/welcome.blade.php`)

Landing page dirancang dengan estetika premium yang berfokus pada visualisasi produk batu alam. Halaman ini memuat:
1.  **Hero Banner**: Judul utama dengan animasi, subjudul, dan tombol call-to-action ke daftar produk.
2.  **Kategori Produk**: Navigasi filter jenis batu alam.
3.  **Katalog Produk**: Grid produk berisi gambar, nama, harga, dan tombol "Detail & Pesan".
4.  **Galeri Pengerjaan**: Menampilkan foto asli proses pemahatan nisan/prasasti.
5.  **Testimoni**: Ulasan kepuasan pelanggan dengan rating bintang.

### Kode Struktur Grid Produk:
```html
<div class="row g-4" id="product-container">
    @foreach($products as $product)
        <div class="col-md-6 col-lg-4 product-card-item" data-kategori="{{ $product->kategori_id }}">
            <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden position-relative">
                <img src="{{ asset($product->gambar) }}" class="card-img-top" style="height: 280px; object-fit: cover;" alt="{{ $product->nama }}">
                <div class="card-body p-4">
                    <span class="text-muted small uppercase">{{ $product->kategori->nama }}</span>
                    <h5 class="fw-bold mt-1 text-dark">{{ $product->nama }}</h5>
                    <p class="text-stone-accent fw-bold fs-5 mt-2">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </p>
                    <a href="{{ route('customer.produk.detail', $product->id) }}" class="btn btn-stone-outline w-100 mt-3 py-2">
                        Detail & Pesan Kustom
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>
```

---

## 4. Tampilan Detail & Pemesanan Kustom (`resources/views/customer/produk_detail.blade.php`)

Halaman ini sangat penting karena menyediakan form interaktif kustomisasi teks yang akan dipahat di batu nisan atau prasasti. Form ini menangkap `qty`, `catatan_ukiran`, dan `alamat`.

### Kode Form Kustomisasi Pemesanan:
```html
<form method="POST" action="{{ route('customer.order.store', $product->id) }}">
    @csrf
    <!-- Input Qty -->
    <div class="mb-3">
        <label for="qty" class="form-label text-muted small fw-semibold">Jumlah Pesanan (Pcs)</label>
        <input type="number" name="qty" id="qty" class="form-control py-2 w-25" value="1" min="1" max="{{ $product->stok }}" required>
    </div>

    <!-- Teks Ukiran Kustom -->
    <div class="mb-3">
        <label for="catatan_ukiran" class="form-label text-muted small fw-semibold">Teks Ukiran Nisan / Prasasti</label>
        <textarea name="catatan_ukiran" id="catatan_ukiran" class="form-control py-2" rows="4" 
                  placeholder="Contoh untuk batu nisan:&#10;Nama: Alm. Ahmad Fauzi&#10;Lahir: Jakarta, 12 Jan 1960&#10;Wafat: Bandung, 24 Feb 2024&#10;Bin: H. Ibrahim"></textarea>
        <span class="form-text text-muted" style="font-size: 0.75rem;">
            Tuliskan detail teks yang akan diukir di batu nisan atau prasasti dengan teliti.
        </span>
    </div>

    <!-- Alamat Pengiriman -->
    <div class="mb-4">
        <label for="alamat" class="form-label text-muted small fw-semibold">Alamat Pengiriman</label>
        <textarea name="alamat" id="alamat" class="form-control py-2" rows="3" required>{{ Auth::user()->address }}</textarea>
    </div>

    <button type="submit" class="btn btn-stone-accent w-100 py-3">
        <i class="bi bi-cart-plus me-2"></i>Buat Pesanan Sekarang
    </button>
</form>
```

---

## 5. Tampilan Unggah Pembayaran (`resources/views/customer/pembayaran.blade.php`)

Halaman ini memandu customer untuk melakukan transfer ke rekening bank resmi Berkah Alam (BCA/Mandiri) senilai total tagihan pesanan, kemudian mengunggah foto bukti pembayaran.

### Kode Form Upload Bukti Pembayaran:
```html
<div class="premium-card p-5">
    <h4 class="fw-bold mb-1"><i class="bi bi-upload me-2 text-stone-accent"></i>Unggah Bukti Transfer</h4>
    <p class="text-secondary mb-4">Unggah file foto / tangkapan layar bukti transfer ATM atau M-Banking Anda.</p>

    <!-- Enctype multipart/form-data wajib ada untuk proses upload berkas -->
    <form method="POST" action="{{ route('customer.pembayaran.store', $order->id) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label for="bukti_pembayaran" class="form-label text-muted small fw-semibold">Pilih File Foto Bukti Pembayaran</label>
            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="form-control py-2" required accept="image/*">
            <span class="form-text text-muted" style="font-size: 0.75rem;">Format file: JPG, JPEG, atau PNG.</span>
        </div>

        <button type="submit" class="btn btn-stone-accent w-100 py-3">
            <i class="bi bi-send-fill me-2"></i>Kirim Bukti Pembayaran
        </button>
    </form>
</div>
```
*Form ini mewajibkan atribut `enctype="multipart/form-data"` agar file bukti pembayaran dapat diproses dengan aman oleh Laravel.*
