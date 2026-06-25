-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2026 at 08:27 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `e_ticket_kapal_laut`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwals`
--

CREATE TABLE `jadwals` (
  `id_jadwal` bigint(20) UNSIGNED NOT NULL,
  `id_kapal` bigint(20) UNSIGNED NOT NULL,
  `asal` varchar(255) NOT NULL,
  `tujuan` varchar(255) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_berangkat` time NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwals`
--

INSERT INTO `jadwals` (`id_jadwal`, `id_kapal`, `asal`, `tujuan`, `tanggal`, `jam_berangkat`, `harga`, `created_at`, `updated_at`) VALUES
(1, 1, 'Tanjung Priok (Jakarta)', 'Belawan (Medan)', '2026-06-17', '08:00:00', 450000.00, '2026-06-14 21:58:21', '2026-06-14 21:58:21'),
(2, 1, 'Belawan (Medan)', 'Tanjung Priok (Jakarta)', '2026-06-19', '14:00:00', 450000.00, '2026-06-14 21:58:21', '2026-06-14 21:58:21'),
(3, 2, 'Tanjung Priok (Jakarta)', 'Tanjung Perak (Surabaya)', '2026-06-16', '10:30:00', 240000.00, '2026-06-14 21:58:21', '2026-06-14 21:58:21'),
(4, 3, 'Tanjung Perak (Surabaya)', 'Soekarno-Hatta (Makassar)', '2026-06-18', '20:00:00', 380000.00, '2026-06-14 21:58:21', '2026-06-14 21:58:21'),
(5, 4, 'Soekarno-Hatta (Makassar)', 'Tanjung Perak (Surabaya)', '2026-06-17', '17:00:00', 390000.00, '2026-06-14 21:58:21', '2026-06-14 21:58:21'),
(6, 3, 'Dumas (Benoa Bali)', 'Tanjung Perak (Surabaya)', '2026-06-16', '09:00:00', 200000.00, '2026-06-14 21:58:21', '2026-06-14 21:58:21'),
(7, 1, 'Tanjung Priok (Jakarta)', 'Tanjung Perak (Surabaya)', '2026-06-18', '13:00:00', 250000.00, '2026-06-14 21:58:21', '2026-06-14 21:58:21'),
(8, 5, 'Pelabuhan Merak', 'Pelabuhan Bakauheni', '2026-06-17', '12:30:00', 450000.00, '2026-06-14 22:18:52', '2026-06-14 22:18:52');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kapals`
--

CREATE TABLE `kapals` (
  `id_kapal` bigint(20) UNSIGNED NOT NULL,
  `nama_kapal` varchar(255) NOT NULL,
  `kapasitas` int(11) NOT NULL,
  `kelas` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kapals`
--

INSERT INTO `kapals` (`id_kapal`, `nama_kapal`, `kapasitas`, `kelas`, `created_at`, `updated_at`) VALUES
(1, 'KM Kelud', 1500, 'Ekonomi, Bisnis, VIP', '2026-06-14 21:58:21', '2026-06-14 21:58:21'),
(2, 'KM Lawit', 800, 'Ekonomi, Bisnis', '2026-06-14 21:58:21', '2026-06-14 21:58:21'),
(3, 'KM Sinabung', 2000, 'Ekonomi, Bisnis, VIP', '2026-06-14 21:58:21', '2026-06-14 21:58:21'),
(4, 'KM Bukit Siguntang', 1200, 'Ekonomi, Bisnis, VIP', '2026-06-14 21:58:21', '2026-06-14 21:58:21'),
(5, 'KMP Portlink', 1000, 'Ekonomi, Bisnis, VIP', '2026-06-14 22:16:22', '2026-06-14 22:16:22');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_06_15_045710_create_kapals_table', 1),
(5, '2026_06_15_045711_create_jadwals_table', 1),
(6, '2026_06_15_045711_create_pemesanans_table', 1),
(7, '2026_06_15_045712_create_pembayarans_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id_pembayaran` bigint(20) UNSIGNED NOT NULL,
  `id_pemesanan` bigint(20) UNSIGNED NOT NULL,
  `metode` varchar(255) NOT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `tanggal_bayar` datetime NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayarans`
--

INSERT INTO `pembayarans` (`id_pembayaran`, `id_pemesanan`, `metode`, `bukti_transfer`, `tanggal_bayar`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Transfer Bank', 'uploads/bukti_transfer/proof_BKG-71QANPRX_1781850900.png', '2026-06-19 06:35:00', 'approved', '2026-06-18 23:35:00', '2026-06-18 23:35:53'),
(2, 2, 'Transfer Bank', 'uploads/bukti_transfer/proof_BKG-V3AFIPBP_1781855750.png', '2026-06-19 07:55:50', 'approved', '2026-06-19 00:55:50', '2026-06-19 00:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `pemesanans`
--

CREATE TABLE `pemesanans` (
  `id_pemesanan` bigint(20) UNSIGNED NOT NULL,
  `kode_booking` varchar(255) NOT NULL,
  `id_user` bigint(20) UNSIGNED NOT NULL,
  `id_jadwal` bigint(20) UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `no_hp` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `jenis_kelas` enum('Ekonomi','Bisnis','VIP') NOT NULL DEFAULT 'Ekonomi',
  `jumlah_penumpang` int(11) NOT NULL,
  `total_harga` decimal(10,2) NOT NULL,
  `status` enum('pending','paid','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pemesanans`
--

INSERT INTO `pemesanans` (`id_pemesanan`, `kode_booking`, `id_user`, `id_jadwal`, `nama_lengkap`, `nik`, `no_hp`, `email`, `jenis_kelas`, `jumlah_penumpang`, `total_harga`, `status`, `created_at`, `updated_at`) VALUES
(1, 'BKG-71QANPRX', 2, 8, 'Budi Santoso', '3602897654235678', '082128593608', 'user@kapal.com', 'Bisnis', 2, 1350000.00, 'paid', '2026-06-14 22:23:08', '2026-06-18 23:35:53'),
(2, 'BKG-V3AFIPBP', 2, 1, 'Budi Santoso', '12345678910111213', '082123741938', 'user@kapal.com', 'Ekonomi', 1, 450000.00, 'paid', '2026-06-19 00:55:28', '2026-06-19 00:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('7A6xpbVkDxxYO1BI6kNERxxOMNd9I21HyQd2dPH5', NULL, '180.252.227.137', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieE5IRklsQlNvOWZwcUozRUVxdmdXcHJaTm91cnBtclAxaEVRVGw2USI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vdmFucXVpc2gtc2FnZ3ktZHV0eS5uZ3Jvay1mcmVlLmRldiI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1782015584),
('ofeeNih8RIzbdNuNEIkYnuno0AckOEgDa7f1k1lV', NULL, '180.252.227.137', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib2d3Q1ZLa2oxa2VyWXZzNU5XVktBaFMyRnNnREtXTHhUdlREN2FkZCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vdmFucXVpc2gtc2FnZ3ktZHV0eS5uZ3Jvay1mcmVlLmRldiI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1782015611),
('Q7AFnvNkUWpzfXGhSlt6ihowNvuIpuUeVJqn4JFZ', NULL, '180.252.227.137', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) SamsungBrowser/29.0 Chrome/136.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTEUwYkdZUXZ3ZGJHRTFuSzFYRnY0ZHdKOWJWaTh5WDYxbzc0c3l3biI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vdmFucXVpc2gtc2FnZ3ktZHV0eS5uZ3Jvay1mcmVlLmRldiI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1782015584),
('Rr5K3sgK8qGlliHxe1DVoZDxYGJqr4R8rce2eDUs', NULL, '180.252.227.137', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/149.0.0.0 Mobile Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWJ1c05UeG1obGx4ZEJnUjZ0bGFoSEYxSk9pRDZ4NkRiSkRLd3V6MyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDI6Imh0dHBzOi8vdmFucXVpc2gtc2FnZ3ktZHV0eS5uZ3Jvay1mcmVlLmRldiI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1782015585);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@kapal.com', NULL, '$2y$12$O7ojgewYGjlyVxYpcMqp4OqzXKVWE76PC8YpaMS0rOIC7SVnI6utu', 'admin', 'bTF9AMqu19dEFa5vmeg7Z5GAEYzc7fMboW20fapofKSqBAvtBLrm4pUexWFA', '2026-06-14 21:58:20', '2026-06-14 21:58:20'),
(2, 'Budi Santoso', 'user@kapal.com', NULL, '$2y$12$lNZ5eFOcz6rpu4pI63gkaO.cmhhXdJaIxziawGIYiTTX4L44n0bk2', 'user', 'EgrkNX4XRbqht8RWYg0I5OFKVqbg9YbryA4vAKlSL52VbZjFcUsHLcsE6X5J', '2026-06-14 21:58:20', '2026-06-14 21:58:20'),
(3, 'Siti Aminah', 'siti@kapal.com', NULL, '$2y$12$wgOzINJNO7lpCrtHvmo4LuoNyaoNBWEMc0Zx6bPuVlPUhst8T9.k2', 'user', NULL, '2026-06-14 21:58:21', '2026-06-14 21:58:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `jadwals_id_kapal_foreign` (`id_kapal`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kapals`
--
ALTER TABLE `kapals`
  ADD PRIMARY KEY (`id_kapal`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `pembayarans_id_pemesanan_foreign` (`id_pemesanan`);

--
-- Indexes for table `pemesanans`
--
ALTER TABLE `pemesanans`
  ADD PRIMARY KEY (`id_pemesanan`),
  ADD UNIQUE KEY `pemesanans_kode_booking_unique` (`kode_booking`),
  ADD KEY `pemesanans_id_user_foreign` (`id_user`),
  ADD KEY `pemesanans_id_jadwal_foreign` (`id_jadwal`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwals`
--
ALTER TABLE `jadwals`
  MODIFY `id_jadwal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kapals`
--
ALTER TABLE `kapals`
  MODIFY `id_kapal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id_pembayaran` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pemesanans`
--
ALTER TABLE `pemesanans`
  MODIFY `id_pemesanan` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD CONSTRAINT `jadwals_id_kapal_foreign` FOREIGN KEY (`id_kapal`) REFERENCES `kapals` (`id_kapal`) ON DELETE CASCADE;

--
-- Constraints for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_id_pemesanan_foreign` FOREIGN KEY (`id_pemesanan`) REFERENCES `pemesanans` (`id_pemesanan`) ON DELETE CASCADE;

--
-- Constraints for table `pemesanans`
--
ALTER TABLE `pemesanans`
  ADD CONSTRAINT `pemesanans_id_jadwal_foreign` FOREIGN KEY (`id_jadwal`) REFERENCES `jadwals` (`id_jadwal`) ON DELETE CASCADE,
  ADD CONSTRAINT `pemesanans_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
