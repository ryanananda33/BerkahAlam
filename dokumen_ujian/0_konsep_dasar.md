# SOAL KONSEP DASAR PEMROGRAMAN WEB
**Sistem Informasi UMKM Berkah Alam**

Berikut adalah penjelasan konsep dasar pemrograman web yang diimplementasikan pada project **Sistem Informasi UMKM Berkah Alam**:

---

## 1. CRUD (Create, Read, Update, Delete)
CRUD adalah empat fungsi dasar penyimpanan persisten yang digunakan dalam aplikasi database.

*   **Create (Membuat Data)**
    *   *Penjelasan*: Proses menambahkan data baru ke dalam database.
    *   *Penerapan pada Project*:
        *   **Customer**: Membuat pesanan baru saat mengklik tombol order produk pada detail produk (`OrderController@placeOrder` menyimpan ke tabel `pesanan` dan `detail_pesanan`).
        *   **Customer**: Mengunggah bukti pembayaran (`CustomerController@storePayment` menyimpan ke tabel `pembayaran`).
        *   **Admin**: Menambahkan data kategori batu alam baru (`AdminKategoriController@store`) dan produk baru (`AdminProdukController@store`).
*   **Read (Membaca/Menampilkan Data)**
    *   *Penjelasan*: Proses mengambil data dari database dan menampilkannya di antarmuka pengguna.
    *   *Penerapan pada Project*:
        *   **Guest/Customer**: Melihat katalog produk batu alam di Landing Page (`LandingPageController@index`).
        *   **Admin**: Melihat daftar transaksi pesanan masuk di dashboard admin (`AdminPesananController@index`).
*   **Update (Mengubah Data)**
    *   *Penjelasan*: Proses memodifikasi data yang sudah ada di database.
    *   *Penerapan pada Project*:
        *   **Customer**: Memperbarui informasi profil seperti alamat dan nomor telepon (`CustomerController@updateProfile`).
        *   **Admin**: Melakukan verifikasi pembayaran dan mengubah status pesanan dari `pending` menjadi `diverifikasi`, `diproses`, atau `selesai` (`AdminPesananController@updateStatus`).
*   **Delete (Menghapus Data)**
    *   *Penjelasan*: Proses menghapus data dari database.
    *   *Penerapan pada Project*:
        *   **Admin**: Menghapus produk (`AdminProdukController@destroy`) atau kategori (`AdminKategoriController@destroy`) yang sudah tidak tersedia lagi di Berkah Alam. Penghapusan ini menggunakan relasi `ON DELETE CASCADE` di database, sehingga data terkait ikut terhapus secara otomatis dan menjaga integritas data.

---

## 2. CMV / MVC (Controller - Model - View)
CMV (atau lebih umum dikenal sebagai MVC - Model, View, Controller) adalah pola arsitektur perangkat lunak yang memisahkan aplikasi menjadi tiga komponen utama untuk memisahkan logika bisnis dari UI.

*   **Model (Komponen Data)**
    *   *Penjelasan*: Komponen yang berinteraksi langsung dengan database, mendefinisikan struktur data, aturan bisnis, dan relasi antartabel.
    *   *Penerapan pada Project*: File di folder `app/Models/`. Contohnya:
        *   `Produk.php`: Merepresentasikan tabel `produk`, berelasi dengan `Kategori` (`belongsTo`) dan `DetailPesanan` (`hasMany`).
        *   `Pesanan.php`: Merepresentasikan tabel `pesanan`, berelasi dengan `User` (`belongsTo`), `DetailPesanan` (`hasMany`), dan `Pembayaran` (`hasOne`).
*   **View (Komponen Antarmuka / UI)**
    *   *Penjelasan*: Komponen yang menampilkan data kepada pengguna dan menerima input. View hanya berisi kode tampilan dan tidak memiliki logika database.
    *   *Penerapan pada Project*: File berekstensi `.blade.php` di folder `resources/views/`. Contohnya:
        *   `welcome.blade.php`: Menampilkan landing page utama dengan katalog produk, galeri, dan testimoni.
        *   `admin/pesanan/show.blade.php`: Menampilkan detail transaksi pesanan untuk diproses oleh admin.
*   **Controller (Komponen Logika Bisnis)**
    *   *Penjelasan*: Penghubung antara Model dan View. Controller menerima request dari route (URL yang diakses user), memanggil Model untuk mengambil/mengolah data, lalu mengirimkan hasilnya ke View untuk dirender.
    *   *Penerapan pada Project*: File di folder `app/Http/Controllers/`. Contohnya:
        *   `LandingPageController.php`: Mengambil data banner hero, kategori, produk, testimoni, dan galeri menggunakan Model, lalu mengirimkannya ke view `welcome.blade.php`.
        *   `Admin\AdminPesananController.php`: Mengatur proses penerimaan pesanan, validasi pembayaran, dan ekspor struk ke PDF.

---

## 3. Keamanan Data
Keamanan data adalah langkah-langkah perlindungan data untuk mencegah akses ilegal, manipulasi data, atau kebocoran informasi pada aplikasi.

*   **Password Hashing (Kriptografi Kata Sandi)**
    *   *Penjelasan*: Menyimpan password dalam bentuk terenkripsi satu arah agar jika database bocor, password asli pengguna tidak dapat dibaca.
    *   *Penerapan pada Project*: Laravel menggunakan algoritma hashing **Bcrypt** (pada project ini diset dengan `BCRYPT_ROUNDS=12` di `.env`). Saat register, password di-hash menggunakan fungsi `Hash::make()` sebelum disimpan di tabel `users`.
*   **CSRF Protection (Cross-Site Request Forgery)**
    *   *Penjelasan*: Melindungi aplikasi dari serangan manipulasi transaksi di mana pihak ketiga mengeksekusi aksi ilegal atas nama pengguna yang sedang login.
    *   *Penerapan pada Project*: Laravel secara otomatis memvalidasi token CSRF pada setiap request POST, PUT, atau DELETE. Di setiap form Blade, disertakan directive `@csrf` yang menghasilkan token keamanan unik tersembunyi.
*   **SQL Injection Prevention**
    *   *Penjelasan*: Mencegah penyerang menyisipkan perintah SQL berbahaya melalui input form untuk merusak atau mencuri isi database.
    *   *Penerapan pada Project*: Query database pada project ini ditulis menggunakan **Eloquent ORM** (misal: `Produk::findOrFail($id)`). Eloquent menggunakan **PDO parameter binding** di latar belakang, yang secara otomatis memfilter dan membersihkan karakter input berbahaya sebelum dieksekusi di database MySQL.
*   **Authentication & Authorization (Otorisasi Akses)**
    *   *Penjelasan*: Memastikan hanya pengguna terdaftar yang bisa masuk (Autentikasi) dan membatasi aksi yang bisa dilakukan berdasarkan peran mereka (Otorisasi).
    *   *Penerapan pada Project*:
        *   Route dikelompokkan menggunakan middleware `auth` untuk membatasi akses halaman privat.
        *   Middleware kustom `role:admin` memastikan bahwa hanya pengguna dengan kolom `role = 'admin'` di tabel `users` yang dapat mengakses route `/admin/*` (panel pengelolaan produk, kategori, dan pesanan). Pengguna biasa (role customer) dibatasi hanya bisa mengakses area `/customer/*`.
