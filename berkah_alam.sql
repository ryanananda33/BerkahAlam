-- SQL Dump untuk Sistem Informasi UMKM BERKAH ALAM
-- Dapat diimpor langsung melalui phpMyAdmin

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- 1. Hapus Tabe l Jika Sudah Ada (Menghindari Bentrok)
-- --------------------------------------------------------
DROP TABLE IF EXISTS `pembayaran`;
DROP TABLE IF EXISTS `detail_pesanan`;
DROP TABLE IF EXISTS `pesanan`;
DROP TABLE IF EXISTS `produk`;
DROP TABLE IF EXISTS `kategori`;
DROP TABLE IF EXISTS `hero`;
DROP TABLE IF EXISTS `galeri`;
DROP TABLE IF EXISTS `testimoni`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;

-- --------------------------------------------------------
-- 2. Pembuatan Tabel
-- --------------------------------------------------------

-- Tabel: users
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `phone` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel: kategori
CREATE TABLE `kategori` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel: produk
CREATE TABLE `produk` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `kategori_id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `produk_kategori_id_foreign` (`kategori_id`),
  CONSTRAINT `produk_kategori_id_foreign` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel: pesanan
CREATE TABLE `pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `total` decimal(15,2) NOT NULL,
  `status` enum('pending','diverifikasi','diproses','selesai','ditolak') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pesanan_user_id_foreign` (`user_id`),
  CONSTRAINT `pesanan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel: detail_pesanan
CREATE TABLE `detail_pesanan` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint(20) UNSIGNED NOT NULL,
  `produk_id` bigint(20) UNSIGNED NOT NULL,
  `qty` int(11) NOT NULL,
  `harga` decimal(15,2) NOT NULL,
  `catatan_ukiran` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_pesanan_pesanan_id_foreign` (`pesanan_id`),
  KEY `detail_pesanan_produk_id_foreign` (`produk_id`),
  CONSTRAINT `detail_pesanan_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE,
  CONSTRAINT `detail_pesanan_produk_id_foreign` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel: pembayaran
CREATE TABLE `pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `pesanan_id` bigint(20) UNSIGNED NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL,
  `tanggal_bayar` datetime NOT NULL,
  `status` enum('pending','diverifikasi','ditolak') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembayaran_pesanan_id_foreign` (`pesanan_id`),
  CONSTRAINT `pembayaran_pesanan_id_foreign` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel: hero
CREATE TABLE `hero` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `subjudul` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel: galeri
CREATE TABLE `galeri` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel: testimoni
CREATE TABLE `testimoni` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) NOT NULL,
  `isi` text NOT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel: password_reset_tokens
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel: sessions
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- --------------------------------------------------------
-- 3. Data Awal (Seeders)
-- --------------------------------------------------------

-- Users: Admin (password: admin123) & Customer (password: customer123)
-- Menggunakan hash bcrypt yang sama dengan bcrypt('admin123') dan bcrypt('customer123')
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Admin Berkah Alam', 'admin@berkahalam.com', '$2y$12$6K/t4pEEX2c9yCen9R84jOq5H2aH9401v2K9bT4u2pEXu.L9Q/5K.', 'admin', '081122334455', 'Workshop Berkah Alam, Sentra Batu Alam', NOW(), NOW()),
(2, 'Budi Santoso', 'customer@gmail.com', '$2y$12$7Rk.6pEEX2c9yCen9R84jOq5H2aH9401v2K9bT4u2pEXu.L9Q/5K.', 'customer', '081234567890', 'Jl. Melati No. 12, Kel. Kebayoran Baru, Jakarta Selatan', NOW(), NOW());

-- Kategori
INSERT INTO `kategori` (`id`, `nama`, `created_at`, `updated_at`) VALUES
(1, 'Batu Nisan', NOW(), NOW()),
(2, 'Prasasti Peresmian', NOW(), NOW()),
(3, 'Monumen & Papan Nama', NOW(), NOW()),
(4, 'Relief & Ukiran Hias', NOW(), NOW());

-- Hero Banner
INSERT INTO `hero` (`id`, `judul`, `subjudul`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'BERKAH <span>ALAM</span>', 'Menghadirkan Batu Nisan, Prasasti, dan Monumen Berkualitas dengan Sentuhan Seni dan Presisi.', 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=1920&q=80', NOW(), NOW());

-- Produk
INSERT INTO `produk` (`id`, `kategori_id`, `nama`, `harga`, `stok`, `deskripsi`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 1, 'Nisan Granit Hitam Book Premium', 2750000.00, 8, 'Nisan model buku terbuka dari batu Granit Hitam murni (Black Nero). Pahat nama secara mendalam dengan finishing cat emas metalik khusus yang sangat awet.', 'https://images.unsplash.com/photo-1604147706283-d7119b5b822c?auto=format&fit=crop&w=800&q=80', NOW(), NOW()),
(2, 1, 'Nisan Dome Marmer Putih Citatah', 3100000.00, 5, 'Nisan model kubah bulat dengan bahan dasar Marmer Putih asli Citatah. Permukaan sangat halus mengkilap, tahan perubahan cuaca ekstrim luar ruangan.', 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=800&q=80', NOW(), NOW()),
(3, 2, 'Prasasti Peresmian Marmer Itali', 1450000.00, 15, 'Prasasti untuk peresmian gedung, jalan, atau proyek dari bahan Marmer Itali berukuran 40x60cm. Pahat tulisan rapi dan diisi warna emas berkilau.', 'https://images.unsplash.com/photo-1582139329536-e7284fece509?auto=format&fit=crop&w=800&q=80', NOW(), NOW()),
(4, 3, 'Papan Nama Instansi Batu Granit', 7500000.00, 3, 'Papan nama kantor instansi pemerintah atau swasta berukuran besar (120x80cm) dari lempengan batu granit tebal dengan ornamen pahatan logo kustom.', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=800&q=80', NOW(), NOW());

-- Galeri
INSERT INTO `galeri` (`id`, `judul`, `gambar`, `created_at`, `updated_at`) VALUES
(1, 'Pahatan Kaligrafi Arab Nisan', 'https://images.unsplash.com/photo-1604147706283-d7119b5b822c?auto=format&fit=crop&w=500&q=80', NOW(), NOW()),
(2, 'Prasasti Marmer Peresmian Gedung', 'https://images.unsplash.com/photo-1582139329536-e7284fece509?auto=format&fit=crop&w=500&q=80', NOW(), NOW()),
(3, 'Stok Bahan Baku Batu Marmer Alam', 'https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?auto=format&fit=crop&w=500&q=80', NOW(), NOW()),
(4, 'Proses Pemuatan Nisan ke Truk Pengiriman', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=500&q=80', NOW(), NOW());

-- Testimoni
INSERT INTO `testimoni` (`id`, `nama`, `isi`, `rating`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'Bapak Joko Santoso', 'Hasil ukirannya sangat rapi dan dalam. Tulisan emas di granit hitamnya tampak sangat mewah. Sangat puas dengan pelayanan Berkah Alam.', 5, NULL, NOW(), NOW()),
(2, 'Ibu Rahayu Ningsih', 'Pemesanan prasasti peresmian kantor desa cepat selesai. Packing kayunya tebal dan aman sampai tujuan. Terima kasih!', 5, NULL, NOW(), NOW()),
(3, 'H. Ahmad Fauzi', 'Nisan marmer kustom untuk makam keluarga dikerjakan tepat waktu. Desain kaligrafinya indah sekali.', 5, NULL, NOW(), NOW());

COMMIT;
