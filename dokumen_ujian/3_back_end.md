# FILE 3: SCRIPT DAN UI BACK END
**Sistem Informasi UMKM Berkah Alam**

Dokumen ini mendokumentasikan arsitektur, script logika (Controllers & Routing), otorisasi keamanan, dan antarmuka administrator (UI Back End) pada sistem informasi UMKM Berkah Alam.

---

## 1. Rute dan Otorisasi Back End (Admin Area)

Semua fungsionalitas Back End dilindungi oleh middleware **Authentication (`auth`)** untuk memverifikasi login dan **Role Authorization (`role:admin`)** untuk membatasi hak akses agar hanya Administrator yang dapat masuk ke panel ini.

Definisi grup route admin di `routes/web.php`:
```php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CMS Kategori & Produk
    Route::resource('/kategori', AdminKategoriController::class);
    Route::resource('/produk', AdminProdukController::class);
    
    // Kelola Pesanan & Pembayaran
    Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [AdminPesananController::class, 'show'])->name('pesanan.show');
    Route::post('/pesanan/{id}/verify', [AdminPesananController::class, 'verifyPayment'])->name('pesanan.verify');
    Route::post('/pesanan/{id}/status', [AdminPesananController::class, 'updateStatus'])->name('pesanan.status');
    Route::get('/pesanan/{id}/export-pdf', [AdminPesananController::class, 'exportPdf'])->name('pesanan.export-pdf');
});
```

---

## 2. Controller & Logika Bisnis Utama

Berikut adalah script pengolah data utama yang berjalan di server (Back End):

### 2.1. Validasi & Verifikasi Pembayaran (`AdminPesananController@verifyPayment`)
Metode ini bertugas memproses unggahan bukti bayar dari customer. Admin dapat memverifikasi (menerima) atau menolak transaksi tersebut.

```php
public function verifyPayment(Request $request, $id)
{
    $order = Pesanan::with('pembayaran')->findOrFail($id);
    
    if (!$order->pembayaran) {
        return back()->with('error', 'Pesanan ini belum memiliki bukti pembayaran.');
    }

    $request->validate([
        'action' => ['required', 'in:verify,reject'],
    ]);

    if ($request->action === 'verify') {
        // Update status pembayaran & status pesanan menjadi diverifikasi
        $order->pembayaran->update(['status' => 'diverifikasi']);
        $order->update(['status' => 'diverifikasi']);
        return back()->with('success', 'Pembayaran berhasil diverifikasi! Status pesanan berubah menjadi Diverifikasi.');
    } else {
        // Update status pembayaran & status pesanan menjadi ditolak
        $order->pembayaran->update(['status' => 'ditolak']);
        $order->update(['status' => 'ditolak']);
        return back()->with('success', 'Pembayaran ditolak! Status pesanan berubah menjadi Ditolak.');
    }
}
```

---

### 2.2. Ekspor Struk/Invoice ke PDF (`AdminPesananController@exportPdf`)
Menggunakan plugin **Barryvdh\DomPDF** (`dompdf`) untuk melakukan render file view Blade khusus HTML menjadi berkas PDF biner untuk diunduh langsung sebagai struk resmi cetak.

```php
public function exportPdf($id)
{
    // Mengambil data pesanan lengkap beserta relasinya
    $order = Pesanan::with(['user', 'pembayaran', 'detailPesanan.produk'])->findOrFail($id);
    
    // Load view Blade dan konversi menjadi PDF stream
    $pdf = Pdf::loadView('admin.pesanan.pdf', compact('order'));
    
    // Download otomatis dengan nama file unik
    return $pdf->download('Invoice-BA-' . $order->id . '.pdf');
}
```

---

### 2.3. Upload Gambar & CRUD Produk (`AdminProdukController@store`)
Logika penambahan produk dengan validasi ketat tipe data, pengecekan ketersediaan file gambar, dan penyimpanan di storage public.

```php
public function store(Request $request)
{
    $request->validate([
        'kategori_id' => 'required|exists:kategori,id',
        'nama' => 'required|string|max:255',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',
        'deskripsi' => 'nullable|string',
        'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $data = $request->all();

    // Logika penanganan upload file gambar produk ke public/uploads/produk/
    if ($request->hasFile('gambar')) {
        $file = $request->file('gambar');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/produk'), $filename);
        $data['gambar'] = 'uploads/produk/' . $filename;
    }

    Produk::create($data);

    return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan!');
}
```

---

## 3. UI Back End (Panel Dashboard Administrator)

Tampilan dashboard admin dirancang menggunakan layout beraliran Glassmorphism semi-transparan dengan sidebar navigasi tetap di bagian kiri.

### Layout Dashboard Admin (`resources/views/admin/layouts/admin.blade.php`):
Struktur layout admin memisahkan navigasi menu dengan konten utama secara responsif.
```html
<div class="sidebar">
    <div class="sidebar-brand">
        <div class="logo-box">
            <i class="bi bi-gem text-white"></i>
        </div>
        <span class="ms-3 fw-bold">Admin Berkah Alam</span>
    </div>
    <ul class="sidebar-menu">
        <li class="sidebar-item">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>Dashboard
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('admin.produk.index') }}" class="sidebar-link {{ Request::routeIs('admin.produk.*') ? 'active' : '' }}">
                <i class="bi bi-box"></i>Produk
            </a>
        </li>
        <li class="sidebar-item">
            <a href="{{ route('admin.pesanan.index') }}" class="sidebar-link {{ Request::routeIs('admin.pesanan.*') ? 'active' : '' }}">
                <i class="bi bi-cart"></i>Kelola Pesanan
            </a>
        </li>
    </ul>
</div>
<div class="main-wrapper">
    <header class="admin-header d-flex justify-content-between align-items-center">
        <h4>Panel Administrasi</h4>
        <!-- Profil info admin -->
    </header>
    <div class="container-fluid py-4">
        @yield('content') <!-- Isi konten spesifik per halaman CMS -->
    </div>
</div>
```

### Halaman Kelola Pesanan (`resources/views/admin/pesanan/index.blade.php`):
Menggunakan **DataTables** untuk menyajikan data tabel secara dinamis dengan fitur pencarian instan, paginasi, dan pengurutan status.
```html
<table id="datatables" class="table table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal</th>
            <th>Total Tagihan</th>
            <th>Status Pesanan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>#BA-{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ $order->tanggal }}</td>
                <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
                <td>
                    <span class="badge bg-{{ $order->status === 'selesai' ? 'success' : ($order->status === 'pending' ? 'warning' : 'primary') }}">
                        {{ strtoupper($order->status) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('admin.pesanan.show', $order->id) }}" class="btn btn-sm btn-stone-primary">
                        <i class="bi bi-eye"></i> Detail
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
```
*Tampilan di atas dikombinasikan dengan Javascript DataTables instan (`$('#datatables').DataTable();`) untuk mempermudah administrator melakukan pencarian data transaksi secara langsung.*
