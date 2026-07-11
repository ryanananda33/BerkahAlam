<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users
        User::create([
            'name' => 'Admin Berkah Alam',
            'email' => 'admin@berkahalam.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'phone' => '081122334455',
            'address' => 'Workshop Berkah Alam, Sentra Batu Alam'
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'customer@gmail.com',
            'password' => Hash::make('customer123'),
            'role' => 'customer',
            'phone' => '081234567890',
            'address' => 'Jl. Melati No. 12, Kel. Kebayoran Baru, Jakarta Selatan'
        ]);

        // Seed Categories
        $k1 = Kategori::create(['nama' => 'Batu Nisan']);
        $k2 = Kategori::create(['nama' => 'Prasasti Peresmian']);
        $k3 = Kategori::create(['nama' => 'Monumen & Papan Nama']);
        $k4 = Kategori::create(['nama' => 'Relief & Ukiran Hias']);

        // Seed Hero Banner
        Hero::create([
            'judul' => 'BERKAH <span>ALAM</span>',
            'subjudul' => 'Menghadirkan Batu Nisan, Prasasti, dan Monumen Berkualitas dengan Sentuhan Seni dan Presisi.',
            'gambar' => 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=1920&q=80'
        ]);

        // Seed Products
        Produk::create([
            'kategori_id' => $k1->id,
            'nama' => 'Nisan Granit Hitam Book Premium',
            'harga' => 2750000,
            'stok' => 8,
            'deskripsi' => 'Nisan model buku terbuka dari batu Granit Hitam murni (Black Nero). Pahat nama secara mendalam dengan finishing cat emas metalik khusus yang sangat awet.',
            'gambar' => 'https://images.unsplash.com/photo-1604147706283-d7119b5b822c?auto=format&fit=crop&w=800&q=80'
        ]);

        Produk::create([
            'kategori_id' => $k1->id,
            'nama' => 'Nisan Dome Marmer Putih Citatah',
            'harga' => 3100000,
            'stok' => 5,
            'deskripsi' => 'Nisan model kubah bulat dengan bahan dasar Marmer Putih asli Citatah. Permukaan sangat halus mengkilap, tahan perubahan cuaca ekstrim luar ruangan.',
            'gambar' => 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=800&q=80'
        ]);

        Produk::create([
            'kategori_id' => $k2->id,
            'nama' => 'Prasasti Peresmian Marmer Itali',
            'harga' => 1450000,
            'stok' => 15,
            'deskripsi' => 'Prasasti untuk peresmian gedung, jalan, atau proyek dari bahan Marmer Itali berukuran 40x60cm. Pahat tulisan rapi dan diisi warna emas berkilau.',
            'gambar' => 'https://images.unsplash.com/photo-1582139329536-e7284fece509?auto=format&fit=crop&w=800&q=80'
        ]);

        Produk::create([
            'kategori_id' => $k3->id,
            'nama' => 'Papan Nama Instansi Batu Granit',
            'harga' => 7500000,
            'stok' => 3,
            'deskripsi' => 'Papan nama kantor instansi pemerintah atau swasta berukuran besar (120x80cm) dari lempengan batu granit tebal dengan ornamen pahatan logo kustom.',
            'gambar' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80'
        ]);

        // Seed Galleries
        Galeri::create([
            'judul' => 'Pahatan Kaligrafi Arab Nisan',
            'gambar' => 'https://images.unsplash.com/photo-1604147706283-d7119b5b822c?auto=format&fit=crop&w=500&q=80'
        ]);
        Galeri::create([
            'judul' => 'Prasasti Marmer Peresmian Gedung',
            'gambar' => 'https://images.unsplash.com/photo-1582139329536-e7284fece509?auto=format&fit=crop&w=500&q=80'
        ]);
        Galeri::create([
            'judul' => 'Stok Bahan Baku Batu Marmer Alam',
            'gambar' => 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=500&q=80'
        ]);
        Galeri::create([
            'judul' => 'Proses Pemuatan Nisan ke Truk Pengiriman',
            'gambar' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=500&q=80'
        ]);

        // Seed Testimonials
        Testimoni::create([
            'nama' => 'Bapak Joko Santoso',
            'isi' => 'Hasil ukirannya sangat rapi dan dalam. Tulisan emas di granit hitamnya tampak sangat mewah. Sangat puas dengan pelayanan Berkah Alam.',
            'rating' => 5,
            'foto' => null
        ]);
        Testimoni::create([
            'nama' => 'Ibu Rahayu Ningsih',
            'isi' => 'Pemesanan prasasti peresmian kantor desa cepat selesai. Packing kayunya tebal dan aman sampai tujuan. Terima kasih!',
            'rating' => 5,
            'foto' => null
        ]);
        Testimoni::create([
            'nama' => 'H. Ahmad Fauzi',
            'isi' => 'Nisan marmer kustom untuk makam keluarga dikerjakan tepat waktu. Desain kaligrafinya indah sekali.',
            'rating' => 5,
            'foto' => null
        ]);
    }
}
