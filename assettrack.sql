-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 29, 2026 at 09:51 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assettrack`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_log`
--

CREATE TABLE `activity_log` (
  `id` int UNSIGNED NOT NULL,
  `user_id` int UNSIGNED DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  `reference_id` int UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bast`
--

CREATE TABLE `bast` (
  `id` int UNSIGNED NOT NULL,
  `bast_number` varchar(50) NOT NULL,
  `laptop_id` int UNSIGNED NOT NULL,
  `employee_id` int UNSIGNED NOT NULL,
  `handover_type` enum('serah_terima_awal','peminjaman','pengembalian') NOT NULL DEFAULT 'serah_terima_awal',
  `handover_date` date NOT NULL,
  `location` varchar(150) DEFAULT NULL,
  `purpose` varchar(255) DEFAULT NULL,
  `expected_return_date` date DEFAULT NULL,
  `condition_on_handover` varchar(100) DEFAULT 'Baik',
  `checklist` text COMMENT 'JSON kelengkapan: laptop,charger,tas,mouse,adapter,lainnya',
  `notes` text,
  `status` enum('draft','menunggu','aktif','selesai','dibatalkan') NOT NULL DEFAULT 'draft',
  `signed_by_receiver` tinyint(1) NOT NULL DEFAULT '0',
  `signed_by_approver` tinyint(1) NOT NULL DEFAULT '0',
  `approver_name` varchar(150) DEFAULT NULL,
  `approver_role` varchar(150) DEFAULT NULL,
  `signer_name` varchar(150) DEFAULT NULL COMMENT 'Override manual nama Pihak Pertama/Menyerahkan khusus BAST ini',
  `signer_role` varchar(150) DEFAULT NULL COMMENT 'Override manual jabatan Pihak Pertama/Menyerahkan khusus BAST ini',
  `signature_token` varchar(64) DEFAULT NULL COMMENT 'Token unik untuk link tanda tangan publik (tanpa login)',
  `admin_signature` varchar(255) DEFAULT NULL COMMENT 'Path file gambar TTD admin (menyerahkan)',
  `receiver_signature` varchar(255) DEFAULT NULL COMMENT 'Path file gambar TTD penerima',
  `approver_signature` varchar(255) DEFAULT NULL COMMENT 'Path file gambar TTD atasan',
  `admin_signed_at` datetime DEFAULT NULL,
  `receiver_signed_at` datetime DEFAULT NULL,
  `approver_signed_at` datetime DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `created_by` int UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bast`
--

INSERT INTO `bast` (`id`, `bast_number`, `laptop_id`, `employee_id`, `handover_type`, `handover_date`, `location`, `purpose`, `expected_return_date`, `condition_on_handover`, `checklist`, `notes`, `status`, `signed_by_receiver`, `signed_by_approver`, `approver_name`, `approver_role`, `signer_name`, `signer_role`, `signature_token`, `admin_signature`, `receiver_signature`, `approver_signature`, `admin_signed_at`, `receiver_signed_at`, `approver_signed_at`, `qr_code`, `created_by`, `created_at`, `updated_at`) VALUES
(17, 'BAST/IT/2026/001', 143, 78, 'serah_terima_awal', '2026-09-17', 'Jakarta HO', 'digunakan sebagai pengganti laptop 5 tahun pemakaian', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"lengkap\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', NULL, NULL, NULL, '82b21c832cd518fd8ac41af07b710b6944a39bd8', 'assets/uploads/signatures/ttd-admin-17-1789631645.png', 'assets/uploads/signatures/ttd-penerima-17-1789631655.png', 'assets/uploads/signatures/ttd-atasan-17-1789631675.png', '2026-09-17 07:54:05', '2026-09-17 07:54:15', '2026-09-17 07:54:35', NULL, 1, '2026-09-17 14:53:56', '2026-09-17 14:54:35'),
(18, 'BAST/IT/2026/002', 145, 125, 'serah_terima_awal', '2026-09-17', 'Jakarta HO', 'digunakan sembari menunggu laptop baru untuk BFLP', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', NULL, NULL, NULL, 'be56a69066f70cf11d81e96442439ed8cebbe327', 'assets/uploads/signatures/ttd-admin-18-1789631898.png', 'assets/uploads/signatures/ttd-penerima-18-1789631904.png', 'assets/uploads/signatures/ttd-atasan-18-1789631913.png', '2026-09-17 07:58:18', '2026-09-17 07:58:24', '2026-09-17 07:58:33', NULL, 1, '2026-09-17 14:58:07', '2026-09-17 14:58:33'),
(19, 'BAST/IT/2026/003', 144, 124, 'serah_terima_awal', '2026-09-17', 'Jakarta HO', 'sebagai pengganti laptop 5tahun', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"lengkap\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', NULL, NULL, NULL, 'e9c45aa28b8ca3179d8a731bcebb4b2967736ddb', 'assets/uploads/signatures/ttd-admin-19-1789632335.png', 'assets/uploads/signatures/ttd-penerima-19-1789632342.png', 'assets/uploads/signatures/ttd-atasan-19-1789632351.png', '2026-09-17 08:05:35', '2026-09-17 08:05:42', '2026-09-17 08:05:51', NULL, 1, '2026-09-17 15:05:26', '2026-09-17 15:05:51'),
(20, 'BAST/IT/2026/004', 148, 25, 'serah_terima_awal', '2026-09-17', 'Jakarta HO', 'operasional', NULL, 'Ada Catatan Minor', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'rusak', 'aktif', 1, 1, 'Nanang Andri Hidayat', NULL, NULL, NULL, 'ed7759284c0eb3aca41232ad7f8106c2c8b33dec', 'assets/uploads/signatures/ttd-admin-20-1789632635.png', 'assets/uploads/signatures/ttd-penerima-20-1789632642.png', 'assets/uploads/signatures/ttd-atasan-20-1789632650.png', '2026-09-17 08:10:35', '2026-09-17 08:10:42', '2026-09-17 08:10:50', NULL, 1, '2026-09-17 15:10:23', '2026-09-17 15:10:50'),
(21, 'BAST/IT/2026/005', 11, 127, 'peminjaman', '2026-09-17', 'Jakarta HO', 'Digunakan intern tim VAM', '2026-12-17', 'Ada Catatan Minor', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'Baterai drop', 'aktif', 1, 1, 'Nanang Andri Hidayat', NULL, NULL, NULL, '8b2e322ffdcb9840e14a0b4dc071f008020fbd65', 'assets/uploads/signatures/ttd-admin-21-1789636046.png', 'assets/uploads/signatures/ttd-penerima-21-1789636090.png', 'assets/uploads/signatures/ttd-atasan-21-1789636098.png', '2026-09-17 09:07:26', '2026-09-17 09:08:10', '2026-09-17 09:08:18', NULL, 1, '2026-09-17 16:07:21', '2026-09-17 16:08:18'),
(22, 'BAST/IT/2026/006', 142, 122, 'serah_terima_awal', '2026-09-18', 'Jakarta HO', 'pengganti laptop 5 tahun', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"lengkap\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'laptop lama belum dikembalikan', 'aktif', 1, 1, 'Nanang Andri Hidayat', NULL, NULL, NULL, '2bc51880daf5ef2ce7f2b2996d096c351606f7a0', 'assets/uploads/signatures/ttd-admin-22-1789723949.png', 'assets/uploads/signatures/ttd-penerima-22-1789723956.png', 'assets/uploads/signatures/ttd-atasan-22-1789723966.png', '2026-09-18 09:32:29', '2026-09-18 09:32:36', '2026-09-18 09:32:46', NULL, 1, '2026-09-18 16:32:21', '2026-09-18 16:32:46'),
(23, 'BAST/IT/2026/007', 141, 32, 'serah_terima_awal', '2026-09-18', 'Jakarta HO', 'pengganti laptop 5 tahun', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'laptop lama masih digunakan', 'aktif', 1, 1, 'Nanang Andri Hidayat', NULL, NULL, NULL, '2a370ca70372d658f1d16fa39e4c5b23c25aed03', 'assets/uploads/signatures/ttd-admin-23-1789724039.png', 'assets/uploads/signatures/ttd-penerima-23-1789724046.png', 'assets/uploads/signatures/ttd-atasan-23-1789724054.png', '2026-09-18 09:33:59', '2026-09-18 09:34:06', '2026-09-18 09:34:14', NULL, 1, '2026-09-18 16:33:54', '2026-09-18 16:34:14'),
(24, 'BAST/IT/2026/008', 140, 82, 'serah_terima_awal', '2026-09-18', 'Jakarta HO', 'pengganti laptop 5 tahun', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"lengkap\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'diberikan ke aivelia karena masih pakai laptop yang lama', 'selesai', 1, 1, 'Nanang Andri Hidayat', NULL, NULL, NULL, '66ba8bad9628a6563b0249a5e91be637b0a80468', 'assets/uploads/signatures/ttd-admin-24-1789724204.png', 'assets/uploads/signatures/ttd-penerima-24-1789724215.png', 'assets/uploads/signatures/ttd-atasan-24-1789724223.png', '2026-09-18 09:36:44', '2026-09-18 09:36:55', '2026-09-18 09:37:03', NULL, 1, '2026-09-18 16:36:35', '2026-09-18 16:58:55'),
(25, 'BAST/IT/2026/009', 138, 78, 'serah_terima_awal', '2026-09-18', 'Jakarta HO', 'pengganti laptop 5 tahun', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"lengkap\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'laptop lama masih dipakai', 'aktif', 1, 1, 'Nanang Andri Hidayat', NULL, NULL, NULL, '59218389e9e8a77dda6f1be4a5b085367f499567', 'assets/uploads/signatures/ttd-admin-25-1789725268.png', 'assets/uploads/signatures/ttd-penerima-25-1789725275.png', 'assets/uploads/signatures/ttd-atasan-25-1789725291.png', '2026-09-18 09:54:28', '2026-09-18 09:54:35', '2026-09-18 09:54:51', NULL, 1, '2026-09-18 16:54:21', '2026-09-18 16:54:51'),
(26, 'BAST/IT/2026/010', 137, 17, 'serah_terima_awal', '2026-09-18', 'Jakarta HO', 'pengganti laptop 5 tahun', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"lengkap\",\"mouse\":\"lengkap\",\"adapter\":\"lengkap\",\"aksesoris_lain\":\"lengkap\"}', 'laptop lama masih dipakai', 'aktif', 1, 1, 'Nanang Andri Hidayat', NULL, NULL, NULL, 'a2c83e792965565baed3715232f7c2178339c7e9', 'assets/uploads/signatures/ttd-admin-26-1789725367.png', 'assets/uploads/signatures/ttd-penerima-26-1789725374.png', 'assets/uploads/signatures/ttd-atasan-26-1789725382.png', '2026-09-18 09:56:07', '2026-09-18 09:56:14', '2026-09-18 09:56:22', NULL, 1, '2026-09-18 16:55:59', '2026-09-18 16:56:22'),
(27, 'BAST/IT/2026/011', 136, 73, 'serah_terima_awal', '2026-09-18', 'Jakarta HO', 'pengganti laptop 5 tahun', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"lengkap\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'tidak diambil', 'aktif', 1, 1, 'Nanang Andri Hidayat', NULL, NULL, NULL, 'a2133f70b98ae689131d8e6d25ee2fadc9dc259f', 'assets/uploads/signatures/ttd-admin-27-1789725483.png', 'assets/uploads/signatures/ttd-penerima-27-1789725489.png', 'assets/uploads/signatures/ttd-atasan-27-1789725497.png', '2026-09-18 09:58:03', '2026-09-18 09:58:09', '2026-09-18 09:58:17', NULL, 1, '2026-09-18 16:57:57', '2026-09-18 16:58:17'),
(31, 'BAST/IT/2026/012', 140, 62, 'serah_terima_awal', '2026-09-24', 'Jakarta HO', 'digunakan sebagai pengganti laptop mati', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'laptop dari perentukan Dea', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '843aee713d8d61acb7a9bf26a0c61670201984d8', 'assets/uploads/signatures/ttd-admin-31-1790236171.png', 'assets/uploads/signatures/ttd-penerima-31-1790236179.png', 'assets/uploads/signatures/ttd-atasan-31-1790236196.png', '2026-09-24 07:49:31', '2026-09-24 07:49:39', '2026-09-24 07:49:56', NULL, 1, '2026-09-24 14:49:22', '2026-09-24 14:49:56'),
(32, 'BAST/IT/2026/013', 139, 77, 'serah_terima_awal', '2026-09-24', 'Jakarta HO', 'pengganti laptop 5 tahun', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"lengkap\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '4c4642118f2873ddcedc0a17cd85139641c097f5', 'assets/uploads/signatures/ttd-admin-32-1790239058.png', 'assets/uploads/signatures/ttd-penerima-32-1790239064.png', 'assets/uploads/signatures/ttd-atasan-32-1790239072.png', '2026-09-24 08:37:38', '2026-09-24 08:37:44', '2026-09-24 08:37:52', NULL, 1, '2026-09-24 15:37:34', '2026-09-24 15:37:52'),
(33, 'BAST/IT/2026/014', 149, 114, 'serah_terima_awal', '2026-09-24', 'Jakarta HO', 'penggunaan sehari hari', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'kondisi rusak', 'selesai', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '7a997e93dedfeb6ebe5d2ef73bbe9f7193b88ddb', 'assets/uploads/signatures/ttd-admin-33-1790239199.png', 'assets/uploads/signatures/ttd-penerima-33-1790239205.png', 'assets/uploads/signatures/ttd-atasan-33-1790239211.png', '2026-09-24 08:39:59', '2026-09-24 08:40:05', '2026-09-24 08:40:11', NULL, 1, '2026-09-24 15:39:54', '2026-09-24 15:41:23'),
(34, 'BAST/IT/2026/015', 149, 114, 'pengembalian', '2026-09-24', NULL, NULL, NULL, 'ada_kerusakan', '{\"kondisi_fisik\":\"ada_kerusakan\",\"layar\":\"baik\",\"keyboard\":\"baik\",\"charger\":\"baik\",\"baterai\":\"ada_kerusakan\",\"port_usb\":\"baik\",\"sistem_operasi\":\"perlu_maintenance\"}', 'OS perlu install ulang dan baterai tidak tahan lama', 'aktif', 1, 1, NULL, NULL, NULL, NULL, '1404227d8b4e45c2c8477b67d5d5b10b0671c2d2', 'assets/uploads/signatures/ttd-admin-34-1790239293.png', NULL, NULL, '2026-09-24 08:41:33', NULL, NULL, NULL, 1, '2026-09-24 15:41:23', '2026-09-24 15:41:33'),
(35, 'BAST/IT/2026/016', 146, 128, 'serah_terima_awal', '2026-09-24', 'Jakarta HO', 'keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '41963940f49ddb1a67fd12844c64d50557314366', 'assets/uploads/signatures/ttd-admin-35-1790239540.png', 'assets/uploads/signatures/ttd-penerima-35-1790239549.png', 'assets/uploads/signatures/ttd-atasan-35-1790239558.png', '2026-09-24 08:45:40', '2026-09-24 08:45:49', '2026-09-24 08:45:58', NULL, 1, '2026-09-24 15:45:34', '2026-09-24 15:45:58'),
(36, 'BAST/IT/2026/017', 12, 11, 'serah_terima_awal', '2026-09-24', 'Jakarta HO', 'keperluan operasional( pembelian divisi dan sudah pindah)', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'bfdab7867be155e8fbf6a5be6dad464274a9e648', 'assets/uploads/signatures/ttd-admin-36-1790240013.png', 'assets/uploads/signatures/ttd-penerima-36-1790240020.png', 'assets/uploads/signatures/ttd-atasan-36-1790240027.png', '2026-09-24 08:53:33', '2026-09-24 08:53:40', '2026-09-24 08:53:47', NULL, 1, '2026-09-24 15:53:28', '2026-09-24 15:53:47'),
(37, 'BAST/IT/2026/018', 22, 21, 'serah_terima_awal', '2026-09-24', 'Jakarta HO', 'keperluan POC', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'selesai', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '96745095af7463a451e44fdc39ddade752be9434', 'assets/uploads/signatures/ttd-admin-37-1790240110.png', 'assets/uploads/signatures/ttd-penerima-37-1790240117.png', 'assets/uploads/signatures/ttd-atasan-37-1790240126.png', '2026-09-24 08:55:10', '2026-09-24 08:55:17', '2026-09-24 08:55:26', NULL, 1, '2026-09-24 15:55:04', '2026-09-24 15:55:52'),
(38, 'BAST/IT/2026/019', 22, 21, 'pengembalian', '2026-09-24', NULL, NULL, NULL, 'baik', '{\"kondisi_fisik\":\"baik\",\"layar\":\"baik\",\"keyboard\":\"baik\",\"charger\":\"baik\",\"baterai\":\"baik\",\"port_usb\":\"baik\",\"sistem_operasi\":\"baik\"}', '', 'aktif', 1, 1, NULL, NULL, NULL, NULL, 'bc922ccf5838b374ecaa298ad8b5dc0bd868a309', 'assets/uploads/signatures/ttd-admin-38-1790240341.png', NULL, NULL, '2026-09-24 08:59:01', NULL, NULL, NULL, 1, '2026-09-24 15:55:52', '2026-09-24 15:59:01'),
(39, 'BAST/IT/2026/020', 22, 18, 'serah_terima_awal', '2026-09-24', 'Jakarta HO', 'pengganti laptop yang error', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '13a1485e52c4ee14a615ab5783d4dada17b60e70', 'assets/uploads/signatures/ttd-admin-39-1790240228.png', 'assets/uploads/signatures/ttd-penerima-39-1790240233.png', 'assets/uploads/signatures/ttd-atasan-39-1790240239.png', '2026-09-24 08:57:08', '2026-09-24 08:57:13', '2026-09-24 08:57:19', NULL, 1, '2026-09-24 15:57:00', '2026-09-24 15:57:19'),
(40, 'BAST/IT/2026/021', 23, 21, 'serah_terima_awal', '2026-09-24', 'Jakarta HO', 'Pindah', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'Pindah Grup', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '155dfe56a5536ac1117f9567b53b0d32bf4b2a86', 'assets/uploads/signatures/ttd-admin-40-1790240510.png', 'assets/uploads/signatures/ttd-penerima-40-1790240516.png', 'assets/uploads/signatures/ttd-atasan-40-1790240524.png', '2026-09-24 09:01:50', '2026-09-24 09:01:56', '2026-09-24 09:02:04', NULL, 1, '2026-09-24 16:01:46', '2026-09-24 16:02:04'),
(41, 'BAST/IT/2026/022', 24, 23, 'peminjaman', '2026-09-24', 'BRI 2', 'digunanakn keperluan POC', '2030-01-24', 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '6d53f1169a8f4f8cea036a83f3ad3aebbb6f96b6', 'assets/uploads/signatures/ttd-admin-41-1790240777.png', 'assets/uploads/signatures/ttd-penerima-41-1790240783.png', 'assets/uploads/signatures/ttd-atasan-41-1790240792.png', '2026-09-24 09:06:17', '2026-09-24 09:06:23', '2026-09-24 09:06:32', NULL, 1, '2026-09-24 16:06:12', '2026-09-24 16:06:32'),
(42, 'BAST/IT/2026/023', 25, 23, 'serah_terima_awal', '2026-09-24', 'Jakarta HO', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '718aaf7c74b9b7ddaddd1063653fc1e5945de945', 'assets/uploads/signatures/ttd-admin-42-1790241791.png', 'assets/uploads/signatures/ttd-penerima-42-1790241797.png', 'assets/uploads/signatures/ttd-atasan-42-1790241804.png', '2026-09-24 09:23:11', '2026-09-24 09:23:17', '2026-09-24 09:23:24', NULL, 1, '2026-09-24 16:23:06', '2026-09-24 16:23:24'),
(43, 'BAST/IT/2026/024', 26, 24, 'serah_terima_awal', '2026-09-24', 'Jakarta HO', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '60692174243403f4150d2a1e9149b09bae5a0a18', 'assets/uploads/signatures/ttd-admin-43-1790241855.png', 'assets/uploads/signatures/ttd-penerima-43-1790241862.png', 'assets/uploads/signatures/ttd-atasan-43-1790241869.png', '2026-09-24 09:24:15', '2026-09-24 09:24:22', '2026-09-24 09:24:29', NULL, 1, '2026-09-24 16:24:10', '2026-09-24 16:24:29'),
(44, 'BAST/IT/2026/025', 27, 25, 'serah_terima_awal', '2026-09-24', 'Jakarta HO', 'digunakan keperluan POC', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'a035bd24c61b66f73bdd45f106d661f2291d581a', 'assets/uploads/signatures/ttd-admin-44-1790242408.png', 'assets/uploads/signatures/ttd-penerima-44-1790242423.png', 'assets/uploads/signatures/ttd-atasan-44-1790242448.png', '2026-09-24 09:33:28', '2026-09-24 09:33:43', '2026-09-24 09:34:08', NULL, 1, '2026-09-24 16:33:23', '2026-09-24 16:34:08'),
(45, 'BAST/IT/2026/026', 28, 25, 'serah_terima_awal', '2026-09-24', 'BRI 2', 'Keperluan Operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'laptop rusak', 'selesai', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '1b9e0a94e2e135f0df866f97a1fa8cbf56eeeaf8', 'assets/uploads/signatures/ttd-admin-45-1790242519.png', 'assets/uploads/signatures/ttd-penerima-45-1790242526.png', 'assets/uploads/signatures/ttd-atasan-45-1790242533.png', '2026-09-24 09:35:19', '2026-09-24 09:35:26', '2026-09-24 09:35:33', NULL, 1, '2026-09-24 16:35:14', '2026-09-24 16:36:19'),
(46, 'BAST/IT/2026/027', 28, 25, 'pengembalian', '2026-09-24', NULL, NULL, NULL, 'ada_kerusakan', '{\"kondisi_fisik\":\"baik\",\"layar\":\"ada_kerusakan\",\"keyboard\":\"baik\",\"charger\":\"ada_kerusakan\",\"baterai\":\"ada_kerusakan\",\"port_usb\":\"baik\",\"sistem_operasi\":\"perlu_maintenance\"}', '', 'selesai', 1, 1, NULL, NULL, NULL, NULL, '3308ce9311096f41f4330a68a1e47fe7c174d62c', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 16:36:19', '2026-09-24 16:36:19'),
(47, 'BAST/IT/2026/028', 29, 26, 'serah_terima_awal', '2026-09-24', 'BRI 2', 'keperluan anak magang', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '5689a4d560e1188ea0824df2e313ff50b3f02d82', 'assets/uploads/signatures/ttd-admin-47-1790242854.png', 'assets/uploads/signatures/ttd-penerima-47-1790242860.png', 'assets/uploads/signatures/ttd-atasan-47-1790242868.png', '2026-09-24 09:40:54', '2026-09-24 09:41:00', '2026-09-24 09:41:08', NULL, 1, '2026-09-24 16:40:50', '2026-09-24 16:41:08'),
(48, 'BAST/IT/2026/029', 30, 27, 'serah_terima_awal', '2026-09-24', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '8dff55a8b40e8e946ace7caef6a62320eb217400', 'assets/uploads/signatures/ttd-admin-48-1790243071.png', 'assets/uploads/signatures/ttd-penerima-48-1790243077.png', 'assets/uploads/signatures/ttd-atasan-48-1790243086.png', '2026-09-24 09:44:31', '2026-09-24 09:44:37', '2026-09-24 09:44:46', NULL, 1, '2026-09-24 16:44:27', '2026-09-24 16:44:46'),
(49, 'BAST/IT/2026/030', 31, 28, 'serah_terima_awal', '2026-09-24', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'Pindah Grup', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '04e0804fd2d63a5e30f5f701b2eca474bcceadbf', 'assets/uploads/signatures/ttd-admin-49-1790243142.png', 'assets/uploads/signatures/ttd-penerima-49-1790243150.png', 'assets/uploads/signatures/ttd-atasan-49-1790243159.png', '2026-09-24 09:45:42', '2026-09-24 09:45:50', '2026-09-24 09:45:59', NULL, 1, '2026-09-24 16:45:37', '2026-09-24 16:45:59'),
(50, 'BAST/IT/2026/031', 32, 29, 'serah_terima_awal', '2026-09-24', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '1a9ee6e38b961f704ddb3bebe890e649f2aace39', 'assets/uploads/signatures/ttd-admin-50-1790243230.png', 'assets/uploads/signatures/ttd-penerima-50-1790243236.png', 'assets/uploads/signatures/ttd-atasan-50-1790243241.png', '2026-09-24 09:47:10', '2026-09-24 09:47:16', '2026-09-24 09:47:21', NULL, 1, '2026-09-24 16:47:06', '2026-09-24 16:47:21'),
(51, 'BAST/IT/2026/032', 33, 30, 'serah_terima_awal', '2026-09-24', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '506b48413b27692bcb447c5e8d400c947c3ead5e', 'assets/uploads/signatures/ttd-admin-51-1790243292.png', 'assets/uploads/signatures/ttd-penerima-51-1790243298.png', 'assets/uploads/signatures/ttd-atasan-51-1790243305.png', '2026-09-24 09:48:12', '2026-09-24 09:48:18', '2026-09-24 09:48:25', NULL, 1, '2026-09-24 16:48:08', '2026-09-24 16:48:25'),
(52, 'BAST/IT/2026/033', 34, 31, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '96a80db2bb8310b24f9c4b1f5b1bd03e3f312562', 'assets/uploads/signatures/ttd-admin-52-1790301665.png', 'assets/uploads/signatures/ttd-penerima-52-1790301672.png', 'assets/uploads/signatures/ttd-atasan-52-1790301679.png', '2026-09-25 02:01:05', '2026-09-25 02:01:12', '2026-09-25 02:01:19', NULL, 1, '2026-09-25 09:01:00', '2026-09-25 09:01:19'),
(53, 'BAST/IT/2026/034', 35, 32, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'd8899cb2cfd51974aa55e5614bbc16ab108a25bd', 'assets/uploads/signatures/ttd-admin-53-1790302225.png', 'assets/uploads/signatures/ttd-penerima-53-1790302232.png', 'assets/uploads/signatures/ttd-atasan-53-1790302239.png', '2026-09-25 02:10:25', '2026-09-25 02:10:32', '2026-09-25 02:10:39', NULL, 1, '2026-09-25 09:10:19', '2026-09-25 09:10:39'),
(54, 'BAST/IT/2026/035', 36, 33, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'Kondisi mati total motherboard tidak menyala', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'c562ca22e7f9af2bf74ef104a552e59d5a314e78', 'assets/uploads/signatures/ttd-admin-54-1790302725.png', 'assets/uploads/signatures/ttd-penerima-54-1790302731.png', 'assets/uploads/signatures/ttd-atasan-54-1790302741.png', '2026-09-25 02:18:45', '2026-09-25 02:18:51', '2026-09-25 02:19:01', NULL, 1, '2026-09-25 09:18:39', '2026-09-25 09:19:01'),
(55, 'BAST/IT/2026/036', 37, 34, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'fc68079258387858670971d0cd748aaebb53ae3f', 'assets/uploads/signatures/ttd-admin-55-1790303002.png', 'assets/uploads/signatures/ttd-penerima-55-1790303010.png', 'assets/uploads/signatures/ttd-atasan-55-1790303022.png', '2026-09-25 02:23:22', '2026-09-25 02:23:30', '2026-09-25 02:23:42', NULL, 1, '2026-09-25 09:23:17', '2026-09-25 09:23:42'),
(56, 'BAST/IT/2026/037', 38, 35, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '39d97c5670395d082d427e9492b530d46676cfc2', 'assets/uploads/signatures/ttd-admin-56-1790308552.png', 'assets/uploads/signatures/ttd-penerima-56-1790308558.png', 'assets/uploads/signatures/ttd-atasan-56-1790308565.png', '2026-09-25 03:55:52', '2026-09-25 03:55:58', '2026-09-25 03:56:05', NULL, 1, '2026-09-25 10:55:46', '2026-09-25 10:56:05'),
(57, 'BAST/IT/2026/038', 39, 36, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'e66ee4939c633ab989f4e8cdbcbdddc3e774d632', 'assets/uploads/signatures/ttd-admin-57-1790308618.png', 'assets/uploads/signatures/ttd-penerima-57-1790308625.png', 'assets/uploads/signatures/ttd-atasan-57-1790308632.png', '2026-09-25 03:56:58', '2026-09-25 03:57:05', '2026-09-25 03:57:12', NULL, 1, '2026-09-25 10:56:52', '2026-09-25 10:57:12'),
(58, 'BAST/IT/2026/039', 40, 37, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'b771897896b1340da7735379f5b82d89c1384541', 'assets/uploads/signatures/ttd-admin-58-1790322746.png', 'assets/uploads/signatures/ttd-penerima-58-1790322755.png', 'assets/uploads/signatures/ttd-atasan-58-1790322763.png', '2026-09-25 07:52:26', '2026-09-25 07:52:35', '2026-09-25 07:52:43', NULL, 1, '2026-09-25 14:52:20', '2026-09-25 14:52:43'),
(59, 'BAST/IT/2026/040', 41, 38, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'c453da0bc8fac5e122a033a3f812e676a68a57ac', 'assets/uploads/signatures/ttd-admin-59-1790322806.png', 'assets/uploads/signatures/ttd-penerima-59-1790322812.png', 'assets/uploads/signatures/ttd-atasan-59-1790322821.png', '2026-09-25 07:53:26', '2026-09-25 07:53:32', '2026-09-25 07:53:41', NULL, 1, '2026-09-25 14:53:21', '2026-09-25 14:53:41'),
(60, 'BAST/IT/2026/041', 42, 39, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '4d6f075d7f22c7a1d642df1bc70dfc3a384c49ae', 'assets/uploads/signatures/ttd-admin-60-1790323335.png', 'assets/uploads/signatures/ttd-penerima-60-1790323342.png', 'assets/uploads/signatures/ttd-atasan-60-1790323350.png', '2026-09-25 08:02:15', '2026-09-25 08:02:22', '2026-09-25 08:02:30', NULL, 1, '2026-09-25 15:02:10', '2026-09-25 15:02:30'),
(61, 'BAST/IT/2026/042', 43, 40, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"lengkap\",\"mouse\":\"lengkap\",\"adapter\":\"lengkap\",\"aksesoris_lain\":\"lengkap\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '9c418e848aa43e6c9329726026e3c200a1dc8f52', 'assets/uploads/signatures/ttd-admin-61-1790324395.png', 'assets/uploads/signatures/ttd-penerima-61-1790324401.png', 'assets/uploads/signatures/ttd-atasan-61-1790324408.png', '2026-09-25 08:19:55', '2026-09-25 08:20:01', '2026-09-25 08:20:08', NULL, 1, '2026-09-25 15:19:50', '2026-09-25 15:20:08'),
(62, 'BAST/IT/2026/043', 44, 41, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan anak magang', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'd52f972c80dcdb2cef153451617fef3fac47ccd8', 'assets/uploads/signatures/ttd-admin-62-1790324539.png', 'assets/uploads/signatures/ttd-penerima-62-1790324545.png', 'assets/uploads/signatures/ttd-atasan-62-1790324555.png', '2026-09-25 08:22:19', '2026-09-25 08:22:25', '2026-09-25 08:22:35', NULL, 1, '2026-09-25 15:22:12', '2026-09-25 15:22:35'),
(63, 'BAST/IT/2026/044', 45, 42, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'pindah grup', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '1ceecde7e798abe5b4b4e3f2a54b6a29d1b82fff', 'assets/uploads/signatures/ttd-admin-63-1790327585.png', 'assets/uploads/signatures/ttd-penerima-63-1790327592.png', 'assets/uploads/signatures/ttd-atasan-63-1790327600.png', '2026-09-25 09:13:05', '2026-09-25 09:13:12', '2026-09-25 09:13:20', NULL, 1, '2026-09-25 16:13:00', '2026-09-25 16:13:20'),
(64, 'BAST/IT/2026/045', 46, 43, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '68640cec8e66b45da6b69688633c669f61b166b2', 'assets/uploads/signatures/ttd-admin-64-1790327650.png', 'assets/uploads/signatures/ttd-penerima-64-1790327655.png', 'assets/uploads/signatures/ttd-atasan-64-1790327664.png', '2026-09-25 09:14:10', '2026-09-25 09:14:15', '2026-09-25 09:14:24', NULL, 1, '2026-09-25 16:14:02', '2026-09-25 16:14:24'),
(65, 'BAST/IT/2026/046', 47, 44, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'fb4e4baccb4bd0c0f381dcee6ee0637ad46a8c8f', 'assets/uploads/signatures/ttd-admin-65-1790329241.png', 'assets/uploads/signatures/ttd-penerima-65-1790329248.png', 'assets/uploads/signatures/ttd-atasan-65-1790329256.png', '2026-09-25 09:40:41', '2026-09-25 09:40:48', '2026-09-25 09:40:56', NULL, 1, '2026-09-25 16:40:16', '2026-09-25 16:40:56'),
(66, 'BAST/IT/2026/047', 48, 45, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'Pindah Grup', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '180fbdc31e5821700f577e6dc1b82f35c92d7882', 'assets/uploads/signatures/ttd-admin-66-1790329635.png', 'assets/uploads/signatures/ttd-penerima-66-1790329644.png', 'assets/uploads/signatures/ttd-atasan-66-1790329654.png', '2026-09-25 09:47:15', '2026-09-25 09:47:24', '2026-09-25 09:47:34', NULL, 1, '2026-09-25 16:47:08', '2026-09-25 16:47:34'),
(67, 'BAST/IT/2026/048', 49, 46, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'Pindah', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '1a2bf7d63fe51ce617a484177c5f5b5a2da698d6', 'assets/uploads/signatures/ttd-admin-67-1790329713.png', 'assets/uploads/signatures/ttd-penerima-67-1790329720.png', 'assets/uploads/signatures/ttd-atasan-67-1790329726.png', '2026-09-25 09:48:33', '2026-09-25 09:48:40', '2026-09-25 09:48:46', NULL, 1, '2026-09-25 16:48:28', '2026-09-25 16:48:46'),
(68, 'BAST/IT/2026/049', 50, 47, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"lengkap\",\"mouse\":\"lengkap\",\"adapter\":\"lengkap\",\"aksesoris_lain\":\"lengkap\"}', 'pindah', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '4077a304288faefef6f8539f7274fb431d832b83', 'assets/uploads/signatures/ttd-admin-68-1790330250.png', 'assets/uploads/signatures/ttd-penerima-68-1790330256.png', 'assets/uploads/signatures/ttd-atasan-68-1790330263.png', '2026-09-25 09:57:30', '2026-09-25 09:57:36', '2026-09-25 09:57:43', NULL, 1, '2026-09-25 16:57:24', '2026-09-25 16:57:43'),
(69, 'BAST/IT/2026/050', 51, 48, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '6e3e025dc57f4e22290f7ab96e81dff3a21133a2', 'assets/uploads/signatures/ttd-admin-69-1790330357.png', 'assets/uploads/signatures/ttd-penerima-69-1790330366.png', 'assets/uploads/signatures/ttd-atasan-69-1790330373.png', '2026-09-25 09:59:17', '2026-09-25 09:59:26', '2026-09-25 09:59:33', NULL, 1, '2026-09-25 16:59:12', '2026-09-25 16:59:33'),
(70, 'BAST/IT/2026/051', 52, 49, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '6bf160644c73417a1ef398e13ad74831f409e230', 'assets/uploads/signatures/ttd-admin-70-1790330424.png', 'assets/uploads/signatures/ttd-penerima-70-1790330430.png', 'assets/uploads/signatures/ttd-atasan-70-1790330436.png', '2026-09-25 10:00:24', '2026-09-25 10:00:30', '2026-09-25 10:00:36', NULL, 1, '2026-09-25 17:00:14', '2026-09-25 17:00:36'),
(71, 'BAST/IT/2026/052', 53, 50, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '2e9244d5c53d7ee84e69c7e282f7e4a44e04c80a', 'assets/uploads/signatures/ttd-admin-71-1790330503.png', 'assets/uploads/signatures/ttd-penerima-71-1790330509.png', 'assets/uploads/signatures/ttd-atasan-71-1790330521.png', '2026-09-25 10:01:43', '2026-09-25 10:01:49', '2026-09-25 10:02:01', NULL, 1, '2026-09-25 17:01:34', '2026-09-25 17:02:01'),
(72, 'BAST/IT/2026/053', 54, 51, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '63e76ccdb6f58e895496f73d95ed15fb0bfc17d2', 'assets/uploads/signatures/ttd-admin-72-1790330618.png', 'assets/uploads/signatures/ttd-penerima-72-1790330625.png', 'assets/uploads/signatures/ttd-atasan-72-1790330633.png', '2026-09-25 10:03:38', '2026-09-25 10:03:45', '2026-09-25 10:03:53', NULL, 1, '2026-09-25 17:03:28', '2026-09-25 17:03:53'),
(73, 'BAST/IT/2026/054', 55, 52, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'e2b98c704fd4e93843891bbb8756c9c30c0ebdb5', 'assets/uploads/signatures/ttd-admin-73-1790330684.png', 'assets/uploads/signatures/ttd-penerima-73-1790330697.png', 'assets/uploads/signatures/ttd-atasan-73-1790330706.png', '2026-09-25 10:04:44', '2026-09-25 10:04:57', '2026-09-25 10:05:06', NULL, 1, '2026-09-25 17:04:34', '2026-09-25 17:05:06'),
(74, 'BAST/IT/2026/055', 56, 105, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'pindah grup', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '131ed9b8dd7b9350cf22bb91d992d158f3eeca2b', 'assets/uploads/signatures/ttd-admin-74-1790330791.png', 'assets/uploads/signatures/ttd-penerima-74-1790330797.png', 'assets/uploads/signatures/ttd-atasan-74-1790330804.png', '2026-09-25 10:06:31', '2026-09-25 10:06:37', '2026-09-25 10:06:44', NULL, 1, '2026-09-25 17:06:26', '2026-09-25 17:06:44'),
(75, 'BAST/IT/2026/056', 57, 54, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'selesai', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '3d70acd0f2c34fcefebf7950052b176cfe9dc705', 'assets/uploads/signatures/ttd-admin-75-1790330875.png', 'assets/uploads/signatures/ttd-penerima-75-1790330881.png', 'assets/uploads/signatures/ttd-atasan-75-1790330888.png', '2026-09-25 10:07:55', '2026-09-25 10:08:01', '2026-09-25 10:08:08', NULL, 1, '2026-09-25 17:07:50', '2026-09-25 17:08:54'),
(76, 'BAST/IT/2026/057', 57, 54, 'pengembalian', '2026-09-25', NULL, NULL, NULL, 'baik', '{\"kondisi_fisik\":\"baik\",\"layar\":\"baik\",\"keyboard\":\"baik\",\"charger\":\"baik\",\"baterai\":\"baik\",\"port_usb\":\"baik\",\"sistem_operasi\":\"baik\"}', 'mendapat pergantian laptop', 'aktif', 1, 1, NULL, NULL, NULL, NULL, 'eb25e1271d439aee414ae1cea173fa41a5d297f0', 'assets/uploads/signatures/ttd-admin-76-1790330942.png', NULL, NULL, '2026-09-25 10:09:02', NULL, NULL, NULL, 1, '2026-09-25 17:08:54', '2026-09-25 17:09:02'),
(77, 'BAST/IT/2026/058', 57, 130, 'serah_terima_awal', '2026-09-25', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'pengganti laptop yang rusak', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'a6323b22dc2b3a16454cb1a340898f790d541451', 'assets/uploads/signatures/ttd-admin-77-1790331052.png', 'assets/uploads/signatures/ttd-penerima-77-1790331059.png', 'assets/uploads/signatures/ttd-atasan-77-1790331065.png', '2026-09-25 10:10:52', '2026-09-25 10:10:59', '2026-09-25 10:11:05', NULL, 1, '2026-09-25 17:10:47', '2026-09-25 17:11:05'),
(78, 'BAST/IT/2026/059', 58, 55, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '548dade54d4b65506e0d95110218398d513e5278', 'assets/uploads/signatures/ttd-admin-78-1790566869.png', 'assets/uploads/signatures/ttd-penerima-78-1790566875.png', 'assets/uploads/signatures/ttd-atasan-78-1790566885.png', '2026-09-28 03:41:09', '2026-09-28 03:41:15', '2026-09-28 03:41:25', NULL, 1, '2026-09-28 10:41:06', '2026-09-28 10:41:25'),
(79, 'BAST/IT/2026/060', 59, 56, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '50a1cffb23f81c9e1d116602f53832cd2b75e515', 'assets/uploads/signatures/ttd-admin-79-1790587910.png', 'assets/uploads/signatures/ttd-penerima-79-1790587917.png', 'assets/uploads/signatures/ttd-atasan-79-1790587928.png', '2026-09-28 09:31:50', '2026-09-28 09:31:57', '2026-09-28 09:32:08', NULL, 1, '2026-09-28 16:31:41', '2026-09-28 16:32:08'),
(80, 'BAST/IT/2026/061', 60, 57, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '4ba3be048ff1e139eb7204f51a847bf89688b337', 'assets/uploads/signatures/ttd-admin-80-1790587973.png', 'assets/uploads/signatures/ttd-penerima-80-1790587980.png', 'assets/uploads/signatures/ttd-atasan-80-1790587986.png', '2026-09-28 09:32:53', '2026-09-28 09:33:00', '2026-09-28 09:33:06', NULL, 1, '2026-09-28 16:32:47', '2026-09-28 16:33:06'),
(81, 'BAST/IT/2026/062', 61, 58, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'pindah grup', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '559f0114ed2d68464e46271a7701e0e064efc841', 'assets/uploads/signatures/ttd-admin-81-1790588101.png', 'assets/uploads/signatures/ttd-penerima-81-1790588109.png', 'assets/uploads/signatures/ttd-atasan-81-1790588117.png', '2026-09-28 09:35:01', '2026-09-28 09:35:09', '2026-09-28 09:35:17', NULL, 1, '2026-09-28 16:34:55', '2026-09-28 16:35:17'),
(82, 'BAST/IT/2026/063', 62, 59, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'pindah grup', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'fe03c961cce358768ea6cabf1e158be7ba045776', 'assets/uploads/signatures/ttd-admin-82-1790588158.png', 'assets/uploads/signatures/ttd-penerima-82-1790588164.png', 'assets/uploads/signatures/ttd-atasan-82-1790588169.png', '2026-09-28 09:35:58', '2026-09-28 09:36:04', '2026-09-28 09:36:09', NULL, 1, '2026-09-28 16:35:49', '2026-09-28 16:36:09'),
(83, 'BAST/IT/2026/064', 63, 60, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'f4dbd3265af71a5a1e67558416b18d0a861d8be0', 'assets/uploads/signatures/ttd-admin-83-1790588231.png', 'assets/uploads/signatures/ttd-penerima-83-1790588236.png', 'assets/uploads/signatures/ttd-atasan-83-1790588244.png', '2026-09-28 09:37:11', '2026-09-28 09:37:16', '2026-09-28 09:37:24', NULL, 1, '2026-09-28 16:37:06', '2026-09-28 16:37:24'),
(84, 'BAST/IT/2026/065', 64, 61, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '60fc06051ed03ec4989a1714365d6b6fe7d142a9', 'assets/uploads/signatures/ttd-admin-84-1790588327.png', 'assets/uploads/signatures/ttd-penerima-84-1790588333.png', 'assets/uploads/signatures/ttd-atasan-84-1790588340.png', '2026-09-28 09:38:47', '2026-09-28 09:38:53', '2026-09-28 09:39:00', NULL, 1, '2026-09-28 16:38:39', '2026-09-28 16:39:00'),
(85, 'BAST/IT/2026/066', 65, 62, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'ef4a88829380084ea041373b575408888c34c2db', 'assets/uploads/signatures/ttd-admin-85-1790588380.png', 'assets/uploads/signatures/ttd-penerima-85-1790588387.png', 'assets/uploads/signatures/ttd-atasan-85-1790588393.png', '2026-09-28 09:39:40', '2026-09-28 09:39:47', '2026-09-28 09:39:53', NULL, 1, '2026-09-28 16:39:32', '2026-09-28 16:39:53'),
(86, 'BAST/IT/2026/067', 66, 63, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '7610ff063e848c2b13c9ed27e513ecffb55a79f5', 'assets/uploads/signatures/ttd-admin-86-1790588425.png', 'assets/uploads/signatures/ttd-penerima-86-1790588430.png', 'assets/uploads/signatures/ttd-atasan-86-1790588436.png', '2026-09-28 09:40:25', '2026-09-28 09:40:30', '2026-09-28 09:40:36', NULL, 1, '2026-09-28 16:40:20', '2026-09-28 16:40:36'),
(87, 'BAST/IT/2026/068', 67, 64, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '460fab9bc8d45860f6a7a933619861a3f414f458', 'assets/uploads/signatures/ttd-admin-87-1790588474.png', 'assets/uploads/signatures/ttd-penerima-87-1790588480.png', 'assets/uploads/signatures/ttd-atasan-87-1790588487.png', '2026-09-28 09:41:14', '2026-09-28 09:41:20', '2026-09-28 09:41:27', NULL, 1, '2026-09-28 16:41:10', '2026-09-28 16:41:27');
INSERT INTO `bast` (`id`, `bast_number`, `laptop_id`, `employee_id`, `handover_type`, `handover_date`, `location`, `purpose`, `expected_return_date`, `condition_on_handover`, `checklist`, `notes`, `status`, `signed_by_receiver`, `signed_by_approver`, `approver_name`, `approver_role`, `signer_name`, `signer_role`, `signature_token`, `admin_signature`, `receiver_signature`, `approver_signature`, `admin_signed_at`, `receiver_signed_at`, `approver_signed_at`, `qr_code`, `created_by`, `created_at`, `updated_at`) VALUES
(88, 'BAST/IT/2026/069', 68, 65, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'ba2bd6f7e81e49cb0da8176496441ca1a60f4bd2', 'assets/uploads/signatures/ttd-admin-88-1790588541.png', 'assets/uploads/signatures/ttd-penerima-88-1790588547.png', 'assets/uploads/signatures/ttd-atasan-88-1790588556.png', '2026-09-28 09:42:21', '2026-09-28 09:42:27', '2026-09-28 09:42:36', NULL, 1, '2026-09-28 16:42:17', '2026-09-28 16:42:36'),
(89, 'BAST/IT/2026/070', 69, 69, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '3adaf427ad2dc82264aee5398d934d98557690da', 'assets/uploads/signatures/ttd-admin-89-1790588595.png', 'assets/uploads/signatures/ttd-penerima-89-1790588601.png', 'assets/uploads/signatures/ttd-atasan-89-1790588607.png', '2026-09-28 09:43:15', '2026-09-28 09:43:21', '2026-09-28 09:43:27', NULL, 1, '2026-09-28 16:43:11', '2026-09-28 16:43:27'),
(90, 'BAST/IT/2026/071', 70, 67, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'pindah grup', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '7ef9e5ebed00716b789809e9b93908ef8994c4d3', 'assets/uploads/signatures/ttd-admin-90-1790588640.png', 'assets/uploads/signatures/ttd-penerima-90-1790588646.png', 'assets/uploads/signatures/ttd-atasan-90-1790588692.png', '2026-09-28 09:44:00', '2026-09-28 09:44:06', '2026-09-28 09:44:52', NULL, 1, '2026-09-28 16:43:56', '2026-09-28 16:44:52'),
(91, 'BAST/IT/2026/072', 71, 68, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '7a790a70dc786b85914145f3211097b1623d5307', 'assets/uploads/signatures/ttd-admin-91-1790588721.png', 'assets/uploads/signatures/ttd-penerima-91-1790588727.png', 'assets/uploads/signatures/ttd-atasan-91-1790588734.png', '2026-09-28 09:45:21', '2026-09-28 09:45:27', '2026-09-28 09:45:34', NULL, 1, '2026-09-28 16:45:17', '2026-09-28 16:45:34'),
(92, 'BAST/IT/2026/073', 72, 69, 'serah_terima_awal', '2026-09-28', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '92466dfcbe3e861f6a87e44712f6741f18ecd508', 'assets/uploads/signatures/ttd-admin-92-1790589114.png', 'assets/uploads/signatures/ttd-penerima-92-1790589121.png', 'assets/uploads/signatures/ttd-atasan-92-1790589128.png', '2026-09-28 09:51:54', '2026-09-28 09:52:01', '2026-09-28 09:52:08', NULL, 1, '2026-09-28 16:51:49', '2026-09-28 16:52:08'),
(93, 'BAST/IT/2026/074', 73, 70, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'da58999621b8b234f6e57539cc416aedfa6d20b3', 'assets/uploads/signatures/ttd-admin-93-1790651069.png', 'assets/uploads/signatures/ttd-penerima-93-1790651082.png', 'assets/uploads/signatures/ttd-atasan-93-1790651090.png', '2026-09-29 03:04:29', '2026-09-29 03:04:42', '2026-09-29 03:04:50', NULL, 2, '2026-09-29 10:04:24', '2026-09-29 10:04:50'),
(94, 'BAST/IT/2026/075', 74, 71, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'b54392ccc89a22cb0462a8241fcab8e12615c202', 'assets/uploads/signatures/ttd-admin-94-1790651196.png', 'assets/uploads/signatures/ttd-penerima-94-1790651202.png', 'assets/uploads/signatures/ttd-atasan-94-1790651209.png', '2026-09-29 03:06:36', '2026-09-29 03:06:42', '2026-09-29 03:06:49', NULL, 2, '2026-09-29 10:06:20', '2026-09-29 10:06:49'),
(95, 'BAST/IT/2026/076', 75, 72, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '07c7964216e3c99e7f241e92723c6a530e5f229c', 'assets/uploads/signatures/ttd-admin-95-1790651301.png', 'assets/uploads/signatures/ttd-penerima-95-1790651307.png', 'assets/uploads/signatures/ttd-atasan-95-1790651312.png', '2026-09-29 03:08:21', '2026-09-29 03:08:27', '2026-09-29 03:08:32', NULL, 2, '2026-09-29 10:08:16', '2026-09-29 10:08:32'),
(96, 'BAST/IT/2026/077', 76, 73, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'b3f5e0fd4fa5d2aa8a94dabd8104553a46af34df', 'assets/uploads/signatures/ttd-admin-96-1790651402.png', 'assets/uploads/signatures/ttd-penerima-96-1790651410.png', 'assets/uploads/signatures/ttd-atasan-96-1790651416.png', '2026-09-29 03:10:02', '2026-09-29 03:10:10', '2026-09-29 03:10:16', NULL, 2, '2026-09-29 10:09:55', '2026-09-29 10:10:16'),
(97, 'BAST/IT/2026/078', 77, 74, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'b80291781edd7b427844b0313c92b5f32a99f9e0', 'assets/uploads/signatures/ttd-admin-97-1790651534.png', 'assets/uploads/signatures/ttd-penerima-97-1790651543.png', 'assets/uploads/signatures/ttd-atasan-97-1790651551.png', '2026-09-29 03:12:14', '2026-09-29 03:12:23', '2026-09-29 03:12:31', NULL, 1, '2026-09-29 10:12:08', '2026-09-29 10:12:31'),
(98, 'BAST/IT/2026/079', 78, 75, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '2a713c2bf7e2b722e2febc8061e33235f931166e', 'assets/uploads/signatures/ttd-admin-98-1790652917.png', 'assets/uploads/signatures/ttd-penerima-98-1790652922.png', 'assets/uploads/signatures/ttd-atasan-98-1790652930.png', '2026-09-29 03:35:17', '2026-09-29 03:35:22', '2026-09-29 03:35:30', NULL, 1, '2026-09-29 10:35:04', '2026-09-29 10:35:30'),
(99, 'BAST/IT/2026/080', 79, 76, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'e53890bb848b74502e54bcadd3981d5515797dd9', 'assets/uploads/signatures/ttd-admin-99-1790653008.png', 'assets/uploads/signatures/ttd-penerima-99-1790653014.png', 'assets/uploads/signatures/ttd-atasan-99-1790653021.png', '2026-09-29 03:36:48', '2026-09-29 03:36:54', '2026-09-29 03:37:01', NULL, 1, '2026-09-29 10:36:43', '2026-09-29 10:37:01'),
(100, 'BAST/IT/2026/081', 80, 77, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '20f96d25281889ea58a3b0a0d799c69ec28ac4ab', 'assets/uploads/signatures/ttd-admin-100-1790653055.png', 'assets/uploads/signatures/ttd-penerima-100-1790653062.png', 'assets/uploads/signatures/ttd-atasan-100-1790653070.png', '2026-09-29 03:37:35', '2026-09-29 03:37:42', '2026-09-29 03:37:50', NULL, 1, '2026-09-29 10:37:30', '2026-09-29 10:37:50'),
(101, 'BAST/IT/2026/082', 81, 78, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'bda2effd12ee383f25f4b0b6f86fe4dd4e561043', 'assets/uploads/signatures/ttd-admin-101-1790653178.png', 'assets/uploads/signatures/ttd-penerima-101-1790653184.png', 'assets/uploads/signatures/ttd-atasan-101-1790653190.png', '2026-09-29 03:39:38', '2026-09-29 03:39:44', '2026-09-29 03:39:50', NULL, 1, '2026-09-29 10:39:33', '2026-09-29 10:39:50'),
(102, 'BAST/IT/2026/083', 82, 79, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'f9f6cdc7be9cbe8d8bd504d51da1b783c7c68c25', 'assets/uploads/signatures/ttd-admin-102-1790653259.png', 'assets/uploads/signatures/ttd-penerima-102-1790653264.png', 'assets/uploads/signatures/ttd-atasan-102-1790653273.png', '2026-09-29 03:40:59', '2026-09-29 03:41:04', '2026-09-29 03:41:13', NULL, 1, '2026-09-29 10:40:18', '2026-09-29 10:41:13'),
(103, 'BAST/IT/2026/084', 83, 80, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'pindah grup', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '14706b808928d8b617d6cd7d94b823727d653f0b', 'assets/uploads/signatures/ttd-admin-103-1790653342.png', 'assets/uploads/signatures/ttd-penerima-103-1790653350.png', 'assets/uploads/signatures/ttd-atasan-103-1790653356.png', '2026-09-29 03:42:22', '2026-09-29 03:42:30', '2026-09-29 03:42:36', NULL, 1, '2026-09-29 10:42:17', '2026-09-29 10:42:36'),
(104, 'BAST/IT/2026/085', 84, 81, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '07d26968c097227de8453740bc2f8f5d682c2f15', 'assets/uploads/signatures/ttd-admin-104-1790653393.png', 'assets/uploads/signatures/ttd-penerima-104-1790653398.png', 'assets/uploads/signatures/ttd-atasan-104-1790653405.png', '2026-09-29 03:43:13', '2026-09-29 03:43:18', '2026-09-29 03:43:25', NULL, 1, '2026-09-29 10:43:08', '2026-09-29 10:43:25'),
(105, 'BAST/IT/2026/086', 85, 82, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'a227aea10a67cf854d0e42a0ba26ea76385317c4', 'assets/uploads/signatures/ttd-admin-105-1790654070.png', 'assets/uploads/signatures/ttd-penerima-105-1790654078.png', 'assets/uploads/signatures/ttd-atasan-105-1790654098.png', '2026-09-29 03:54:30', '2026-09-29 03:54:38', '2026-09-29 03:54:58', NULL, 1, '2026-09-29 10:54:25', '2026-09-29 10:54:58'),
(106, 'BAST/IT/2026/087', 86, 83, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'f770ae69db69966b0b111e7681f3d07eb0ec7997', 'assets/uploads/signatures/ttd-admin-106-1790655168.png', 'assets/uploads/signatures/ttd-penerima-106-1790655175.png', 'assets/uploads/signatures/ttd-atasan-106-1790655184.png', '2026-09-29 04:12:48', '2026-09-29 04:12:55', '2026-09-29 04:13:04', NULL, 1, '2026-09-29 11:12:42', '2026-09-29 11:13:04'),
(107, 'BAST/IT/2026/088', 87, 84, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '2a8821c5097486afe36909d9172334e695897c91', 'assets/uploads/signatures/ttd-admin-107-1790655639.png', 'assets/uploads/signatures/ttd-penerima-107-1790655645.png', 'assets/uploads/signatures/ttd-atasan-107-1790655652.png', '2026-09-29 04:20:39', '2026-09-29 04:20:45', '2026-09-29 04:20:52', NULL, 1, '2026-09-29 11:20:34', '2026-09-29 11:20:52'),
(108, 'BAST/IT/2026/089', 88, 85, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'pindah grup', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '34925452168e162d76345500485fe48b5b698ecb', 'assets/uploads/signatures/ttd-admin-108-1790656022.png', 'assets/uploads/signatures/ttd-penerima-108-1790656029.png', 'assets/uploads/signatures/ttd-atasan-108-1790656036.png', '2026-09-29 04:27:02', '2026-09-29 04:27:09', '2026-09-29 04:27:16', NULL, 1, '2026-09-29 11:26:58', '2026-09-29 11:27:16'),
(109, 'BAST/IT/2026/090', 89, 86, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'aea1eaa282d7384cc47a54773fd3ab6bdbcbcf6b', 'assets/uploads/signatures/ttd-admin-109-1790656981.png', 'assets/uploads/signatures/ttd-penerima-109-1790656988.png', 'assets/uploads/signatures/ttd-atasan-109-1790656993.png', '2026-09-29 04:43:01', '2026-09-29 04:43:08', '2026-09-29 04:43:13', NULL, 1, '2026-09-29 11:42:54', '2026-09-29 11:43:13'),
(110, 'BAST/IT/2026/091', 90, 87, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '5eaeda52900c7bcb83f1ca0f2a098c35c56a09b3', 'assets/uploads/signatures/ttd-admin-110-1790662838.png', 'assets/uploads/signatures/ttd-penerima-110-1790662844.png', 'assets/uploads/signatures/ttd-atasan-110-1790662850.png', '2026-09-29 06:20:38', '2026-09-29 06:20:44', '2026-09-29 06:20:50', NULL, 1, '2026-09-29 13:20:29', '2026-09-29 13:20:50'),
(111, 'BAST/IT/2026/092', 91, 20, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'keluar', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '8fdae06e570d900e41caac893c6f0e71719fc03f', 'assets/uploads/signatures/ttd-admin-111-1790662981.png', 'assets/uploads/signatures/ttd-penerima-111-1790662988.png', 'assets/uploads/signatures/ttd-atasan-111-1790662997.png', '2026-09-29 06:23:01', '2026-09-29 06:23:08', '2026-09-29 06:23:17', NULL, 1, '2026-09-29 13:22:56', '2026-09-29 13:23:17'),
(112, 'BAST/IT/2026/093', 92, 89, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '91e3ed3a7656a225be9532f81db8c946841da503', 'assets/uploads/signatures/ttd-admin-112-1790663052.png', 'assets/uploads/signatures/ttd-penerima-112-1790663060.png', 'assets/uploads/signatures/ttd-atasan-112-1790663067.png', '2026-09-29 06:24:12', '2026-09-29 06:24:20', '2026-09-29 06:24:27', NULL, 1, '2026-09-29 13:24:07', '2026-09-29 13:24:27'),
(113, 'BAST/IT/2026/094', 93, 90, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'c8eefd1676ca5c7b7b35e97d24eb89b67c885bd8', 'assets/uploads/signatures/ttd-admin-113-1790664987.png', 'assets/uploads/signatures/ttd-penerima-113-1790664992.png', 'assets/uploads/signatures/ttd-atasan-113-1790665000.png', '2026-09-29 06:56:27', '2026-09-29 06:56:32', '2026-09-29 06:56:40', NULL, 1, '2026-09-29 13:56:22', '2026-09-29 13:56:40'),
(114, 'BAST/IT/2026/095', 94, 11, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '2081022d27e1587f5def7114b83bd9e135a14963', 'assets/uploads/signatures/ttd-admin-114-1790665370.png', 'assets/uploads/signatures/ttd-penerima-114-1790665378.png', 'assets/uploads/signatures/ttd-atasan-114-1790665384.png', '2026-09-29 07:02:50', '2026-09-29 07:02:58', '2026-09-29 07:03:04', NULL, 1, '2026-09-29 14:02:32', '2026-09-29 14:03:04'),
(115, 'BAST/IT/2026/096', 95, 93, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', 'ganti laptop', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '2effd3d88a0a1d08c767092043822810437d7f32', 'assets/uploads/signatures/ttd-admin-115-1790666653.png', 'assets/uploads/signatures/ttd-penerima-115-1790666660.png', 'assets/uploads/signatures/ttd-atasan-115-1790666665.png', '2026-09-29 07:24:13', '2026-09-29 07:24:20', '2026-09-29 07:24:25', NULL, 1, '2026-09-29 14:24:08', '2026-09-29 14:24:25'),
(116, 'BAST/IT/2026/097', 96, 95, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '0f7c300a1fd9b62ca5ff26dc7f6c1cb0bdd05246', 'assets/uploads/signatures/ttd-admin-116-1790667314.png', 'assets/uploads/signatures/ttd-penerima-116-1790667321.png', 'assets/uploads/signatures/ttd-atasan-116-1790667328.png', '2026-09-29 07:35:14', '2026-09-29 07:35:21', '2026-09-29 07:35:28', NULL, 1, '2026-09-29 14:35:06', '2026-09-29 14:35:28'),
(117, 'BAST/IT/2026/098', 97, 96, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'cb77f4d3444951ba097644dfdbba35c606f13ecd', 'assets/uploads/signatures/ttd-admin-117-1790667366.png', 'assets/uploads/signatures/ttd-penerima-117-1790667371.png', 'assets/uploads/signatures/ttd-atasan-117-1790667377.png', '2026-09-29 07:36:06', '2026-09-29 07:36:11', '2026-09-29 07:36:17', NULL, 1, '2026-09-29 14:36:01', '2026-09-29 14:36:17'),
(118, 'BAST/IT/2026/099', 98, 97, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'ae2d0768e211fd43704b78792dfdb1bbbbab8f94', 'assets/uploads/signatures/ttd-admin-118-1790667500.png', 'assets/uploads/signatures/ttd-penerima-118-1790667507.png', 'assets/uploads/signatures/ttd-atasan-118-1790667520.png', '2026-09-29 07:38:20', '2026-09-29 07:38:27', '2026-09-29 07:38:40', NULL, 1, '2026-09-29 14:38:14', '2026-09-29 14:38:40'),
(119, 'BAST/IT/2026/100', 99, 26, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '1c837da8c1d4f05d573259887b66f05e8f57c83d', 'assets/uploads/signatures/ttd-admin-119-1790667582.png', 'assets/uploads/signatures/ttd-penerima-119-1790667587.png', 'assets/uploads/signatures/ttd-atasan-119-1790667597.png', '2026-09-29 07:39:42', '2026-09-29 07:39:47', '2026-09-29 07:39:57', NULL, 1, '2026-09-29 14:39:36', '2026-09-29 14:39:57'),
(120, 'BAST/IT/2026/101', 100, 99, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '5a360e1d40ef99ab10082da42c0dcf733c992ed7', 'assets/uploads/signatures/ttd-admin-120-1790667742.png', 'assets/uploads/signatures/ttd-penerima-120-1790667746.png', 'assets/uploads/signatures/ttd-atasan-120-1790667754.png', '2026-09-29 07:42:22', '2026-09-29 07:42:26', '2026-09-29 07:42:34', NULL, 1, '2026-09-29 14:42:01', '2026-09-29 14:42:34'),
(121, 'BAST/IT/2026/102', 101, 65, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'menunggu', 1, 0, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '7b14eff37d7e00028865e85709eed984ab0049a5', 'assets/uploads/signatures/ttd-admin-121-1790667903.png', 'assets/uploads/signatures/ttd-penerima-121-1790667910.png', NULL, '2026-09-29 07:45:03', '2026-09-29 07:45:10', NULL, NULL, 1, '2026-09-29 14:44:53', '2026-09-29 14:45:10'),
(122, 'BAST/IT/2026/103', 102, 101, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '91d098e0dc45a2cec0c8a924548d5adae7ab8c89', 'assets/uploads/signatures/ttd-admin-122-1790668727.png', 'assets/uploads/signatures/ttd-penerima-122-1790668732.png', 'assets/uploads/signatures/ttd-atasan-122-1790668738.png', '2026-09-29 07:58:47', '2026-09-29 07:58:52', '2026-09-29 07:58:58', NULL, 1, '2026-09-29 14:46:36', '2026-09-29 14:58:58'),
(123, 'BAST/IT/2026/104', 103, 24, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'keperluan POC', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '4a258b71f71292348e2c40c0e5f4f53f857d6f15', 'assets/uploads/signatures/ttd-admin-123-1790668974.png', 'assets/uploads/signatures/ttd-penerima-123-1790668979.png', 'assets/uploads/signatures/ttd-atasan-123-1790668986.png', '2026-09-29 08:02:54', '2026-09-29 08:02:59', '2026-09-29 08:03:06', NULL, 1, '2026-09-29 15:02:49', '2026-09-29 15:03:06'),
(124, 'BAST/IT/2026/105', 104, 24, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'keperluan POC', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '9d3b16bddb699f8b81d6e2d6934af2ee804c5785', 'assets/uploads/signatures/ttd-admin-124-1790671104.png', 'assets/uploads/signatures/ttd-penerima-124-1790671109.png', 'assets/uploads/signatures/ttd-atasan-124-1790671118.png', '2026-09-29 08:38:24', '2026-09-29 08:38:29', '2026-09-29 08:38:38', NULL, 1, '2026-09-29 15:38:08', '2026-09-29 15:38:38'),
(125, 'BAST/IT/2026/106', 105, 103, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', 'b8ee7dcdf940930afcca4847ddcb3c08e346cfed', 'assets/uploads/signatures/ttd-admin-125-1790671230.png', 'assets/uploads/signatures/ttd-penerima-125-1790671235.png', 'assets/uploads/signatures/ttd-atasan-125-1790671241.png', '2026-09-29 08:40:30', '2026-09-29 08:40:35', '2026-09-29 08:40:41', NULL, 1, '2026-09-29 15:40:24', '2026-09-29 15:40:41'),
(126, 'BAST/IT/2026/107', 106, 57, 'serah_terima_awal', '2026-09-29', 'BRI 2', 'Keperluan operasional', NULL, 'Baik / Layak Pakai', '{\"unit_laptop\":\"lengkap\",\"charger\":\"lengkap\",\"tas\":\"tidak_ada\",\"mouse\":\"tidak_ada\",\"adapter\":\"tidak_ada\",\"aksesoris_lain\":\"tidak_ada\"}', '', 'aktif', 1, 1, 'Nanang Andri Hidayat', 'Team Leader', NULL, 'Admin IT Asset Management', '7b61e6c7d90a91ef7393f8aeb624ce4b522093be', 'assets/uploads/signatures/ttd-admin-126-1790671326.png', 'assets/uploads/signatures/ttd-penerima-126-1790671333.png', 'assets/uploads/signatures/ttd-atasan-126-1790671344.png', '2026-09-29 08:42:06', '2026-09-29 08:42:13', '2026-09-29 08:42:24', NULL, 1, '2026-09-29 15:41:59', '2026-09-29 15:42:24');

-- --------------------------------------------------------

--
-- Table structure for table `bast_templates`
--

CREATE TABLE `bast_templates` (
  `id` int UNSIGNED NOT NULL,
  `handover_type` enum('serah_terima_awal','peminjaman','pengembalian') NOT NULL,
  `title` varchar(150) NOT NULL,
  `document_title` varchar(255) NOT NULL,
  `statement_text` text NOT NULL,
  `signer_name` varchar(150) DEFAULT NULL COMMENT 'Nama tetap Pihak Pertama/Menyerahkan. Kosongkan untuk pakai nama admin yang login.',
  `signer_role` varchar(150) DEFAULT NULL COMMENT 'Jabatan Pihak Pertama/Menyerahkan',
  `approver_name` varchar(150) DEFAULT NULL COMMENT 'Nama tetap Atasan/Mengetahui untuk template ini',
  `approver_role` varchar(150) DEFAULT NULL COMMENT 'Jabatan Atasan/Mengetahui',
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `bast_templates`
--

INSERT INTO `bast_templates` (`id`, `handover_type`, `title`, `document_title`, `statement_text`, `signer_name`, `signer_role`, `approver_name`, `approver_role`, `updated_at`) VALUES
(1, 'serah_terima_awal', 'Template Serah Terima Awal', 'BERITA ACARA SERAH TERIMA PERANGKAT LAPTOP', 'Pihak Kedua menyatakan telah menerima perangkat dalam kondisi baik dan bertanggung jawab penuh atas pemeliharaan serta keamanan perangkat tersebut, dan wajib mengembalikannya sesuai dengan ketentuan perusahaan yang berlaku.', NULL, 'Admin IT Asset Management', 'Nanang Andri Hidayat', 'Team Leader', '2026-09-17 14:35:00'),
(2, 'peminjaman', 'Template Serah Terima Sementara', 'BERITA ACARA SERAH TERIMA SEMENTARA PERANGKAT LAPTOP', 'Pihak Kedua menyatakan telah menerima perangkat dalam kondisi baik untuk keperluan sementara sebagaimana disebutkan di atas, dan wajib mengembalikan perangkat tersebut paling lambat pada tanggal estimasi pengembalian dalam kondisi baik dan lengkap.', NULL, 'Admin IT Asset Management', 'Nanang Andri Hidayat', 'Team Leader', '2026-09-17 14:35:07'),
(3, 'pengembalian', 'Template Pengembalian Aset', 'BERITA ACARA PENGEMBALIAN PERANGKAT LAPTOP', 'Dokumen ini menyatakan bahwa Pihak Kedua telah mengembalikan perangkat sebagaimana disebutkan di atas kepada Pihak Pertama, beserta kondisi dan kelengkapan sebagaimana tercatat, dan dengan ini tanggung jawab Pihak Kedua atas perangkat tersebut dinyatakan berakhir.', NULL, 'Admin IT Asset Management', 'Nanang Andri Hidayat', 'Team Leader', '2026-09-17 14:35:10');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int UNSIGNED NOT NULL,
  `nik` varchar(30) NOT NULL,
  `name` varchar(150) NOT NULL,
  `position` varchar(100) DEFAULT NULL,
  `group_id` int UNSIGNED DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `nik`, `name`, `position`, `group_id`, `is_active`, `created_at`, `email`, `phone`) VALUES
(11, '1', 'Muharto', 'Division Head', 14, 1, '2026-09-03 11:54:02', '', ''),
(12, '2', 'Tri Danarto', 'Departement Head', 15, 1, '2026-09-03 11:54:02', '', ''),
(13, '3', 'Arief Bandung Wahyudi', 'Departement Head', 16, 1, '2026-09-03 11:54:02', '', ''),
(14, '4', 'Primanio', 'Senior Manager', 17, 1, '2026-09-03 11:54:02', '', ''),
(15, '5', 'Hadit Jusiardhy', 'Senior Manager', 13, 1, '2026-09-03 11:54:02', '', ''),
(16, '6', 'Yusuf Oktofani', 'Manager', 12, 1, '2026-09-03 11:54:02', '', ''),
(17, '7', 'Annisa Nur Hidayatillah', 'Assistant Manager', 8, 1, '2026-09-03 11:54:02', '', ''),
(18, '8', 'Marsha Chikita Intania Putri', 'Trainee BFLP 11', 8, 1, '2026-09-03 11:54:02', '', ''),
(19, '9', 'Tartila Bima Prasetyo', 'Associate IT - Project Officer 1 Level 2', 18, 1, '2026-09-03 11:54:02', '', ''),
(20, '10', 'Indra Toha', 'Manager', 19, 1, '2026-09-03 11:54:02', '', ''),
(21, '11', 'Muhammad Faris Mas\'ud', 'Officer', 20, 1, '2026-09-03 11:54:02', '', ''),
(23, '13', 'Ester Gyo Fanny Siallagan', 'Assistant Manager', 11, 1, '2026-09-03 11:54:02', '', ''),
(24, '14', 'M.Rafly Arya Putra', 'Officer', 10, 1, '2026-09-03 11:54:02', '', ''),
(25, '15', 'Aldy Gustav Darma Liwoso', 'Assistant Manager', 10, 1, '2026-09-03 11:54:02', '', ''),
(26, '16', 'Setio Wahono', 'Junior Manager', 10, 1, '2026-09-03 11:54:02', '', ''),
(27, '17', 'Raden Achmad Fakih Basyaruddin', 'Manager', 2, 1, '2026-09-03 11:54:02', '', ''),
(28, '18', 'Reza Fahlevi Zulkarnaen', 'Assistant Manager', 2, 1, '2026-09-03 11:54:02', '', ''),
(29, '19', 'Imaniar Ramadhani', 'Assistant Manager', 3, 1, '2026-09-03 11:54:02', '', ''),
(30, '20', 'Rifqi Pratama Nugraha', 'Assistant Manager', 3, 1, '2026-09-03 11:54:02', '', ''),
(31, '21', 'Edi Kurniawan', 'Assistant Manager', 3, 1, '2026-09-03 11:54:02', '', ''),
(32, '22', 'Amroy Casro Lumban Gaol', 'Assistant Manager', 21, 1, '2026-09-03 11:54:02', '', ''),
(33, '23', 'Agung Diananto Pratomo Putro', 'Manager', 22, 1, '2026-09-03 11:54:02', '', ''),
(34, '24', 'Via Aprilia Prabawati', 'Officer', 4, 1, '2026-09-03 11:54:02', '', ''),
(35, '25', 'Fathurrahman Setyo Binamahawana', 'Assistant Manager', 5, 1, '2026-09-03 11:54:02', '', ''),
(36, '26', 'Yunan Lasito', 'Manager', 1, 1, '2026-09-03 11:54:02', '', ''),
(37, '27', 'Landika Hari Suganda', 'Assistant Manager', 2, 1, '2026-09-03 11:54:02', '', ''),
(38, '28', 'M Ryan Fadholi', 'Assistant Manager', 1, 1, '2026-09-03 11:54:02', '', ''),
(39, '29', 'Irham Taufiqurahman', 'Assistant Manager', 1, 1, '2026-09-03 11:54:02', '', ''),
(40, '30', 'Briant Otmen', 'Assistant Manager', 1, 1, '2026-09-03 11:54:02', '', ''),
(41, '31', 'Octgi Ristya Perdana', 'Trainee BFLP 11', 1, 1, '2026-09-03 11:54:02', '', ''),
(42, '32', 'Hadi Krisnawan Azhar', 'Manager', 18, 1, '2026-09-03 11:54:02', '', ''),
(43, '33', 'Agita Novero Sabatanus', 'Assistant Manager', 18, 1, '2026-09-03 11:54:02', '', ''),
(44, '34', 'Bogi Farizna Junior', 'Assistant Manager', 6, 1, '2026-09-03 11:54:02', '', ''),
(45, '35', 'Oktapani Panca Jaya', 'Officer', 23, 1, '2026-09-03 11:54:02', '', ''),
(46, '36', 'Irfan Arachman', 'IT Project Officer', 24, 1, '2026-09-03 11:54:02', '', ''),
(47, '37', 'Yusril Iman', 'IT Project Officer', 18, 1, '2026-09-03 11:54:02', '', ''),
(48, '38', 'Nanang Andri Hidayat', 'Manager', 7, 1, '2026-09-03 11:54:02', '', ''),
(49, '39', 'Adhika Wisaksono', 'Assistant Manager', 5, 1, '2026-09-03 11:54:02', '', ''),
(50, '40', 'Andre Mauludin Mandalip', 'Associate IT Project Officer 1', 5, 1, '2026-09-03 11:54:02', '', ''),
(51, '41', 'Arrazaq Zakaria', 'Assistant Manager', 8, 1, '2026-09-03 11:54:02', '', ''),
(52, '42', 'Iren Herny', 'IT Project Officer', 12, 1, '2026-09-03 11:54:02', '', ''),
(54, '44', 'Blegoh Prasetyo', 'Manager', 4, 1, '2026-09-03 11:54:03', '', ''),
(55, '45', 'Herwin Sunandar', 'Officer', 11, 1, '2026-09-03 11:54:03', '', ''),
(56, '46', 'Muhammad Firzi Nabil', 'Officer', 7, 1, '2026-09-03 11:54:03', '', ''),
(57, '47', 'Muhammad Irhamna Putra', 'Officer', 10, 1, '2026-09-03 11:54:03', '', ''),
(58, '48', 'Mirna Fauziah', 'Officer', 18, 1, '2026-09-03 11:54:03', '', ''),
(59, '49', 'Ariandi Trijaya Saputra', 'Officer', 26, 1, '2026-09-03 11:54:03', '', ''),
(60, '50', 'Nabihah Hanun Atikah', 'Assistant Manager', 7, 1, '2026-09-03 11:54:03', '', ''),
(61, '51', 'Bagas Kurniawan', 'Junior Manager', 9, 1, '2026-09-03 11:54:03', '', ''),
(62, '52', 'Aivelia Mualifatul Risca', 'Junior Manager', 10, 1, '2026-09-03 11:54:03', '', ''),
(63, '53', 'Muhammad Mufid Irfan Farras', 'Junior Manager', 3, 1, '2026-09-03 11:54:03', '', ''),
(64, '54', 'Donie Parulian Siregar', 'Junior Manager', 1, 1, '2026-09-03 11:54:03', '', ''),
(65, '55', 'Qaaid Terrion Riyanto', 'Junior Manager', 4, 1, '2026-09-03 11:54:03', '', ''),
(67, '57', 'Innafajri Insyirah', 'Junior Manager', 10, 1, '2026-09-03 11:54:03', '', ''),
(68, '58', 'Rinaldy Ansyah Pramana Lubsi', 'Junior Manager', 3, 1, '2026-09-03 11:54:03', '', ''),
(69, '59', 'Aria Fajar Ramdhany', 'Junior Manager', 5, 1, '2026-09-03 11:54:03', '', ''),
(70, '60', 'Randy Wahyu Triputra', 'Junior Manager', 1, 1, '2026-09-03 11:54:03', '', ''),
(71, '61', 'Dzaky Ligarwaly Rasendriya', 'Junior Manager', 5, 1, '2026-09-03 11:54:03', '', ''),
(72, '62', 'Muhammad Sultan Aldo', 'Junior Manager', 5, 1, '2026-09-03 11:54:03', '', ''),
(73, '63', 'Abdul Hafis', 'Junior Manager', 12, 1, '2026-09-03 11:54:03', '', ''),
(74, '64', 'Aldi Dwi Putra', 'Junior Manager', 11, 1, '2026-09-03 11:54:03', '', ''),
(75, '65', 'Soni Febriga Aseagih', 'Junior Manager', 7, 1, '2026-09-03 11:54:03', 'ssprasetyo08@gmail.com', ''),
(76, '66', 'Danica Virlianda Marsha', 'Junior Manager', 8, 1, '2026-09-03 11:54:03', '', ''),
(77, '67', 'Muhammad Rizky Nirwan', 'Junior Manager', 18, 1, '2026-09-03 11:54:03', '', ''),
(78, '68', 'Nadya Nur Fadhilah', 'Junior Manager', 1, 1, '2026-09-03 11:54:03', '', ''),
(79, '69', 'Muhammad Rizky Barokah', 'Junior Manager', 12, 1, '2026-09-03 11:54:03', '', ''),
(80, '70', 'Aby Arya Fakhri', 'Junior Manager', 18, 1, '2026-09-03 11:54:03', '', ''),
(81, '71', 'Alif Rizal Maulana', 'Junior Manager', 3, 1, '2026-09-03 11:54:03', '', ''),
(82, '72', 'Dea Ivanka Malaha', 'Junior Manager', 6, 1, '2026-09-03 11:54:03', '', ''),
(83, '73', 'Danny Theodore Dunrui', 'Junior Manager', 1, 1, '2026-09-03 11:54:03', '', ''),
(84, '74', 'Annisa Khodista Syaka', 'Junior Manager', 27, 1, '2026-09-03 11:54:03', '', ''),
(85, '75', 'Fahdiaz Alief', 'Junior Manager', 28, 1, '2026-09-03 11:54:03', '', ''),
(86, '76', 'Muhammad Rifqi Oktova', 'Junior Manager', 3, 1, '2026-09-03 11:54:03', '', ''),
(87, '77', 'Maximilian Cristoporus Nuel Jaya', 'Junior Manager', 6, 1, '2026-09-03 11:54:03', '', ''),
(89, '79', 'Haykal Hutama', 'Junior Manager', 7, 1, '2026-09-03 11:54:03', '', ''),
(90, '80', 'Dian pratama Putra Telaumbanua', 'Projek Officer L1', 2, 1, '2026-09-03 11:54:03', '', ''),
(92, '82', 'Muhammad Rafi Adi Wibowo', 'JUNIOR MANAGER', 6, 1, '2026-09-03 11:54:03', '', ''),
(93, '83', 'Arief Rahman', 'Manager', 3, 1, '2026-09-03 11:54:03', '', ''),
(95, '85', 'Muhammad ajran saputra', 'Junior Manager', 9, 1, '2026-09-03 11:54:03', '', ''),
(96, '86', 'Candra Wiradika', 'Junior Manager', 18, 1, '2026-09-03 11:54:03', '', ''),
(97, '87', 'Muhammad Rasendriya', 'Junior Manager', 21, 1, '2026-09-03 11:54:03', '', ''),
(99, '89', 'Deo Prasetyo Dwi Cahyono', 'Departement Head', 30, 1, '2026-09-03 11:54:03', '', ''),
(101, '91', 'Akmal', 'Junior Manager', 2, 1, '2026-09-03 11:54:03', '', ''),
(103, '93', 'I Putu Windy Arya Sagita', 'Junior Manager', 1, 1, '2026-09-03 11:54:03', '', ''),
(104, '94', 'Nadya Anindita Permana', 'Sekretaris', 7, 1, '2026-09-03 11:54:03', '', ''),
(105, '95', 'Notario Airlangga Putra', 'Departement Head', 26, 1, '2026-09-03 11:54:03', '', ''),
(106, '96', 'Irfan Herdiansyah', 'Junior Manager', 5, 1, '2026-09-03 11:54:03', '', ''),
(108, '98', 'Hefin Imanuel Ginting', 'Junior Manager', 4, 1, '2026-09-03 11:54:03', '', ''),
(110, '100', 'Tb Muhammad Fawwaz Rasyid', 'Junior Manager', 12, 1, '2026-09-03 11:54:03', '', ''),
(111, '101', 'Divya Maharani Lazuardi', 'Junior Manager', 2, 1, '2026-09-03 11:54:03', '', ''),
(112, '102', 'Yoga Yosepino Sinaga', 'Junior Manager', 10, 1, '2026-09-03 11:54:03', '', ''),
(114, '104', 'Shelinna Dwiforizqi Usti', 'Associate IT - Project Officer 1 Level 4', 9, 1, '2026-09-03 11:54:03', '', ''),
(116, '106', 'Arya Wardhana Setawan', 'BFLP', 10, 1, '2026-09-03 11:54:03', '', ''),
(117, '107', 'Asyer Maindan Wibisana A', 'Team Leader', 11, 1, '2026-09-03 11:54:03', '', ''),
(122, '112', 'Irene Nandasari', 'Team Leader', 9, 1, '2026-09-03 11:54:03', '', ''),
(123, '113', 'Rhema riesaputra', 'Group Head', 14, 1, '2026-09-03 11:54:03', '', ''),
(124, '114', 'Fathra Primadhana', 'Team Leader', 3, 1, '2026-09-03 11:54:03', '', ''),
(125, '115', 'Aldi Dwi Febriyanto', 'BFLP', 10, 1, '2026-09-03 11:54:03', '', ''),
(126, '116', 'moh sulthan arief rahmatullah', 'BFLP', 3, 1, '2026-09-03 11:54:03', '', ''),
(127, '151', 'Felicia Dinatali Manullang', 'Intern tim VAM', 2, 1, '2026-09-03 13:44:53', '', ''),
(128, '152', 'Sigit Prasetyo', 'assisstent', 7, 1, '2026-09-07 16:16:08', 'ssprasetyo08@gmail.com', '085156033706'),
(130, '153', 'Galih Fathoni', 'Senior Manager', 12, 1, '2026-09-25 17:10:08', '', ''),
(131, '154', 'Adrian Rose Jayanto', 'Senior Manager', 14, 1, '2026-09-28 10:37:48', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'CIA'),
(2, 'VAM'),
(3, 'ASE'),
(4, 'DSM'),
(5, 'EPS'),
(6, 'SEA'),
(7, 'SGO'),
(8, 'SCA'),
(9, 'SPO'),
(10, 'SPM'),
(11, 'IDP'),
(12, 'UAM'),
(13, 'PVA'),
(14, 'CISO'),
(15, 'SSP'),
(16, 'SOD'),
(17, 'SGA'),
(18, 'DCS'),
(19, 'COE'),
(20, 'HBO'),
(21, 'SAE'),
(22, 'DSE'),
(23, 'CLO'),
(24, 'INW'),
(25, 'AFG'),
(26, 'IAM'),
(27, 'SRM'),
(28, 'SCR'),
(29, 'ISC'),
(30, 'DDS'),
(31, '-');

-- --------------------------------------------------------

--
-- Table structure for table `laptops`
--

CREATE TABLE `laptops` (
  `id` int UNSIGNED NOT NULL,
  `asset_id` varchar(30) NOT NULL,
  `serial_number` varchar(100) NOT NULL,
  `brand_id` int UNSIGNED DEFAULT NULL,
  `category_id` int UNSIGNED DEFAULT NULL,
  `model` varchar(150) NOT NULL,
  `processor` varchar(100) DEFAULT NULL,
  `ram` varchar(30) DEFAULT NULL,
  `storage` varchar(50) DEFAULT NULL,
  `os` varchar(50) DEFAULT NULL,
  `purchase_year` year DEFAULT NULL,
  `purchase_price` decimal(14,2) DEFAULT NULL,
  `location` varchar(100) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `status` enum('tersedia','digunakan','maintenance','dipinjamkan','rusak','nonaktif') NOT NULL DEFAULT 'tersedia',
  `condition_notes` text,
  `current_employee_id` int UNSIGNED DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laptops`
--

INSERT INTO `laptops` (`id`, `asset_id`, `serial_number`, `brand_id`, `category_id`, `model`, `processor`, `ram`, `storage`, `os`, `purchase_year`, `purchase_price`, `location`, `photo`, `status`, `condition_notes`, `current_employee_id`, `created_at`, `updated_at`) VALUES
(11, 'CIS-129/AST-L/2023', 'PW-04CALK', 1, 3, 'Thinkpad L13', 'Core i5 Gen 13', '16 GB', '512GB', 'Windows 11 Pro', 2023, NULL, 'BRI 2', NULL, 'dipinjamkan', NULL, 127, '2026-09-03 13:46:29', '2026-09-17 16:07:21'),
(12, 'CIS-130/AST-L/2017', 'C02W33P4HV29', 8, 3, 'MacBook Pro 13', '', '8 GB', '', 'Windows 11 Pro', 2017, NULL, 'BRI 2', NULL, 'digunakan', NULL, 11, '2026-09-03 16:55:07', '2026-09-24 15:53:28'),
(13, 'CIS-131/AST-L/2020', 'C02DW8U1ML7H', 8, 3, 'MacBook Pro 13\"', '', '', '', 'MacOS', 2020, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(14, 'CIS-132/AST-L/2017', 'FVFWN2JQHV22', 8, 3, 'MacBook Pro 13\"', '', '', '', 'MacOS', 2017, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(15, 'CIS-133/AST-L/2021', 'PF2QDB6L', 1, 3, 'Lenovo ThinkPad T14 Gen 1', 'Core i5 Gen 13', '16 GB', '512GB', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:46:36'),
(16, 'CIS-134/AST-L/2019', 'PF2472EW', 1, 3, 'Lenovo ThinkPad T14 Gen 1', '', '', '', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(17, 'CIS-135/AST-L/2019', 'PW04CHBA', 1, 3, 'Lenovo ThinkPad L13 Gen 3', '', '', '', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(18, 'CIS-136/AST-L/2019', 'M8NXCV18W709347', 3, 3, 'Asus ExpertBook 1400C', 'I5 1135G7', '8Gb', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(19, 'CIS-137/AST-L/2022', 'MCNXCV1224550A', 3, 3, 'Asus ExpertBook 1400C', 'I5 1135G7', '8Gb', '512GB', 'Windows 11 Pro', 2022, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(20, 'CIS-138/AST-L/2019', 'PC14RLDL', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(21, 'CIS-139/AST-L/2021', '5CG1063XRP', 4, 3, 'HP Elitebook 850 G8', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(22, 'CIS-140/AST-L/2021', 'PC17SR2W', 1, 3, 'Lenovo ThinkPad T480s', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 18, '2026-09-03 16:55:07', '2026-09-24 15:57:00'),
(23, 'CIS-141/AST-L/2021', 'PF24ACMB', 1, 3, 'Lenovo ThinkPad T14 Gen 1', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 21, '2026-09-03 16:55:07', '2026-09-24 16:01:46'),
(24, 'CIS-142/AST-L/2021', 'MCNXCV12220950G', 3, 3, 'Asus ExpertBook 1400C', 'I5 1135G7', '8Gb', '512GB', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'dipinjamkan', NULL, 23, '2026-09-03 16:55:07', '2026-09-24 16:06:12'),
(25, 'CIS-143/AST-L/2019', 'PC17SR55', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 23, '2026-09-03 16:55:07', '2026-09-24 16:23:06'),
(26, 'CIS-144/AST-L/2022', '5CG012C131', 4, 3, 'HP Elitebook 840 G6', '', '', '', 'Windows 11 Pro', 2022, NULL, 'BRI 2', NULL, 'digunakan', NULL, 24, '2026-09-03 16:55:07', '2026-09-24 16:24:10'),
(27, 'CIS-145/AST-L/2021', '5CG012C1F4', 4, 3, 'HP Elitebook 840 G6', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 25, '2026-09-03 16:55:07', '2026-09-24 16:33:23'),
(28, 'CIS-146/AST-L/2021', 'M9NXCV06D05436A', 3, 3, 'Asus ExpertBook 1400C', 'I5 1135G7', '8 GB', '512GB', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'rusak', '', NULL, '2026-09-03 16:55:07', '2026-09-28 10:08:56'),
(29, 'CIS-147/AST-L/2026', 'BVJK963', 2, 3, 'Dell', '', '', '', 'Windows 11 Pro', 2026, NULL, 'BRI 2', NULL, 'digunakan', NULL, 26, '2026-09-03 16:55:07', '2026-09-24 16:40:50'),
(30, 'CIS-148/AST-L/2022', 'NXVP9SN001203035D62N00', 6, 3, 'Acer i5 TMP414-51G-575X', '', '', '', 'Windows 11 Pro', 2022, NULL, 'BRI 2', NULL, 'digunakan', NULL, 27, '2026-09-03 16:55:07', '2026-09-24 16:44:27'),
(31, 'CIS-149/AST-L/2019', 'PC17SR2Z', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 28, '2026-09-03 16:55:07', '2026-09-24 16:45:37'),
(32, 'CIS-150/AST-L/2019', 'PC17SR52', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 29, '2026-09-03 16:55:07', '2026-09-24 16:47:06'),
(33, 'CIS-151/AST-L/2019', 'PC17SR46', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 30, '2026-09-03 16:55:07', '2026-09-24 16:48:08'),
(34, 'CIS-152/AST-L/2020', '5CG1063WYX', 4, 3, 'HP Elitebook 850 G8', '', '', '', 'Windows 11 Pro', 2020, NULL, 'BRI 2', NULL, 'digunakan', NULL, 31, '2026-09-03 16:55:07', '2026-09-25 09:01:00'),
(35, 'CIS-153/AST-L/2019', 'PC17SR5Y', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 32, '2026-09-03 16:55:07', '2026-09-25 09:10:19'),
(36, 'CIS-154/AST-L/2021', 'FVFDK2QKM6KG', 8, 3, 'MacBook Air 13', '', '8 GB', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'rusak', 'laptop tidak bisa menyala, mati motherboard', 33, '2026-09-03 16:55:07', '2026-09-25 09:20:15'),
(37, 'CIS-155/AST-L/2019', 'PC1D6YXE', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 34, '2026-09-03 16:55:07', '2026-09-25 09:23:17'),
(38, 'CIS-156/AST-L/2022', 'N1NXCV082162024', 3, 3, 'Asus ExpertBook 1400C', 'I5 1135G7', '8GB', '512GB', 'Windows 11 Pro', 2022, NULL, 'BRI 2', NULL, 'digunakan', NULL, 35, '2026-09-03 16:55:07', '2026-09-25 10:55:46'),
(39, 'CIS-157/AST-L/2020', 'PF2474PK', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2020, NULL, 'BRI 2', NULL, 'digunakan', NULL, 36, '2026-09-03 16:55:07', '2026-09-25 10:56:52'),
(40, 'CIS-158/AST-L/2019', 'PC17SR2X', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 37, '2026-09-03 16:55:07', '2026-09-25 14:52:20'),
(41, 'CIS-159/AST-L/2019', 'PC17SR3Z', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 38, '2026-09-03 16:55:07', '2026-09-25 14:53:21'),
(42, 'CIS-160/AST-L/2019', 'PC17SR2G', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 39, '2026-09-03 16:55:07', '2026-09-25 15:02:10'),
(43, 'CIS-161/AST-L/2019', 'PC17SR4M', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 40, '2026-09-03 16:55:07', '2026-09-25 15:19:50'),
(44, 'CIS-162/AST-L/2026', 'C62L2B3', 2, 3, 'Dell', '', '', '', 'Windows 11 Pro', 2026, NULL, 'BRI 2', NULL, 'digunakan', NULL, 41, '2026-09-03 16:55:07', '2026-09-25 15:22:12'),
(45, 'CIS-163/AST-L/2020', 'PF247CEZ', 1, 3, 'Lenovo ThinkPad T14 Gen 1', '', '', '', 'Windows 11 Pro', 2020, NULL, 'BRI 2', NULL, 'digunakan', NULL, 42, '2026-09-03 16:55:07', '2026-09-25 16:13:00'),
(46, 'CIS-164/AST-L/2021', 'M7NXCV23A27730F', 3, 3, 'Asus ExpertBook 1400C', 'I5 1135G7', '8GB', '512GB', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 43, '2026-09-03 16:55:07', '2026-09-25 16:14:02'),
(47, 'CIS-165/AST-L/2019', 'PF1MM0WF', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 44, '2026-09-03 16:55:07', '2026-09-25 16:40:16'),
(48, 'CIS-166/AST-L/2019', 'PC1D6YY1', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 45, '2026-09-03 16:55:07', '2026-09-25 16:47:09'),
(49, 'CIS-167/AST-L/2021', 'PF247JK7', 1, 3, 'Lenovo ThinkPad T14 Gen 1', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 46, '2026-09-03 16:55:07', '2026-09-25 16:48:28'),
(50, 'CIS-168/AST-L/2021', 'PF2472GW', 1, 3, 'Lenovo ThinkPad T14 Gen 1', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 47, '2026-09-03 16:55:07', '2026-09-25 16:57:24'),
(51, 'CIS-169/AST-L/2020', 'PC1D6YW2', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2020, NULL, 'BRI 2', NULL, 'digunakan', NULL, 48, '2026-09-03 16:55:07', '2026-09-25 16:59:12'),
(52, 'CIS-170/AST-L/2020', 'PC1D6YV8', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2020, NULL, 'BRI 2', NULL, 'digunakan', NULL, 49, '2026-09-03 16:55:07', '2026-09-25 17:00:14'),
(53, 'CIS-171/AST-L/2021', 'PF24ABQK', 1, 3, 'Lenovo ThinkPad T14 Gen 1', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 50, '2026-09-03 16:55:07', '2026-09-25 17:01:34'),
(54, 'CIS-172/AST-L/2021', 'M7NXCV23A323309', 3, 3, 'Asus ExpertBook 1400C', 'I5 1135G7', '8GB', '512GB', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 51, '2026-09-03 16:55:07', '2026-09-25 17:03:28'),
(55, 'CIS-173/AST-L/2021', 'M7NXCV23A272309', 3, 3, 'Asus ExpertBook 1400C', 'I5 1135G7', '8GB', '512GB', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 52, '2026-09-03 16:55:07', '2026-09-25 17:04:34'),
(56, 'CIS-174/AST-L/2022', '5CG028HG4', 4, 3, 'HP Elitebook 840 G6', '', '8 GB', '', 'Windows 11 Pro', 2022, NULL, 'BRI 2', NULL, 'rusak', 'engsel rusak', 105, '2026-09-03 16:55:07', '2026-09-25 17:07:10'),
(57, 'CIS-175/AST-L/2020', 'PC1D6YTY', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2020, NULL, 'BRI 2', NULL, 'digunakan', NULL, 130, '2026-09-03 16:55:07', '2026-09-25 17:10:47'),
(58, 'CIS-176/AST-L/2020', 'PF247EBA', 1, 3, 'Lenovo ThinkPad T14 Gen 1', '', '', '', 'Windows 11 Pro', 2020, NULL, 'BRI 2', NULL, 'digunakan', NULL, 55, '2026-09-03 16:55:07', '2026-09-28 10:41:06'),
(59, 'CIS-177/AST-L/2022', '5CG21834NN', 4, 3, 'HP Elitebook 830 G8', '', '', '', 'Windows 11 Pro', 2022, NULL, 'BRI 2', NULL, 'digunakan', NULL, 56, '2026-09-03 16:55:07', '2026-09-28 16:31:41'),
(60, 'CIS-178/AST-L/2022', '5CG22333HM', 4, 3, 'HP Elitebook 830 G8', 'Core i5 Gen 13', '8 GB', '512GB', 'Windows 11 Pro', 2022, NULL, 'BRI 2', NULL, 'rusak', 'motherboard mati', 57, '2026-09-03 16:55:07', '2026-09-28 16:34:00'),
(61, 'CIS-179/AST-L/2022', '5CG21834LJ', 4, 3, 'HP Elitebook 830 G8', '', '', '', 'Windows 11 Pro', 2022, NULL, 'BRI 2', NULL, 'digunakan', NULL, 58, '2026-09-03 16:55:07', '2026-09-28 16:34:55'),
(62, 'CIS-180/AST-L/2022', '5CG22333JD', 4, 3, 'HP Elitebook 830 G8', '', '', '', 'Windows 11 Pro', 2022, NULL, 'BRI 2', NULL, 'digunakan', NULL, 59, '2026-09-03 16:55:07', '2026-09-28 16:35:49'),
(63, 'CIS-181/AST-L/2018', 'FVFXMLK1HV22', 8, 3, 'MacBook Pro (13-inch, 2017, Two Thunderbolt 3 ports)', '', '', '', 'MacOS', 2018, NULL, 'BRI 2', NULL, 'digunakan', NULL, 60, '2026-09-03 16:55:07', '2026-09-28 16:37:06'),
(64, 'CIS-182/AST-L/2021', 'DQ811B3', 9, 3, 'Laptop Dell Latitude 3410', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 61, '2026-09-03 16:55:07', '2026-09-28 16:38:39'),
(65, 'CIS-183/AST-L/2021', '5P811B3', 9, 3, 'Laptop Dell Latitude 3410', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 62, '2026-09-03 16:55:07', '2026-09-28 16:39:32'),
(66, 'CIS-184/AST-L/2021', '1P811B3', 9, 3, 'Laptop Dell Latitude 3410', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 63, '2026-09-03 16:55:07', '2026-09-28 16:40:20'),
(67, 'CIS-185/AST-L/2021', '6P811B3', 9, 3, 'Laptop Dell Latitude 3410', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 64, '2026-09-03 16:55:07', '2026-09-28 16:41:10'),
(68, 'CIS-186/AST-L/2021', '9N811B3', 9, 3, 'Laptop Dell Latitude 3410', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 65, '2026-09-03 16:55:07', '2026-09-28 16:42:17'),
(69, 'CIS-187/AST-L/2021', 'FP811B3', 9, 3, 'Laptop Dell Latitude 3410', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 69, '2026-09-03 16:55:07', '2026-09-28 16:43:11'),
(70, 'CIS-188/AST-L/2021', 'FN811B3', 9, 3, 'Laptop Dell Latitude 3410', '', '', '', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 67, '2026-09-03 16:55:07', '2026-09-28 16:43:56'),
(71, 'CIS-189/AST-L/2024', 'PW04CGXL', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 68, '2026-09-03 16:55:07', '2026-09-28 16:45:17'),
(72, 'CIS-190/AST-L/2024', 'PW04CH1N', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 69, '2026-09-03 16:55:07', '2026-09-28 16:51:49'),
(73, 'CIS-191/AST-L/2024', 'PW04CHNH', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 70, '2026-09-03 16:55:07', '2026-09-29 10:04:24'),
(74, 'CIS-192/AST-L/2024', 'PW04DFLM', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 71, '2026-09-03 16:55:07', '2026-09-29 10:06:21'),
(75, 'CIS-193/AST-L/2024', 'PW04CH0T', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 72, '2026-09-03 16:55:07', '2026-09-29 10:08:16'),
(76, 'CIS-194/AST-L/2024', 'PW04CH41', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 73, '2026-09-03 16:55:07', '2026-09-29 10:09:55'),
(77, 'CIS-195/AST-L/2024', 'PW04CGPY', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 74, '2026-09-03 16:55:07', '2026-09-29 10:12:08'),
(78, 'CIS-196/AST-L/2024', 'PW04CXA9', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 75, '2026-09-03 16:55:07', '2026-09-29 10:35:04'),
(79, 'CIS-197/AST-L/2024', 'PW04CXC5', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 76, '2026-09-03 16:55:07', '2026-09-29 10:36:43'),
(80, 'CIS-198/AST-L/2024', 'PW04DFMB', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '8 GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'nonaktif', '', 77, '2026-09-03 16:55:07', '2026-09-29 10:38:49'),
(81, 'CIS-199/AST-L/2024', 'PW04CX37', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 78, '2026-09-03 16:55:07', '2026-09-29 10:39:33'),
(82, 'CIS-200/AST-L/2024', 'PW04CGKX', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 79, '2026-09-03 16:55:07', '2026-09-29 10:40:18'),
(83, 'CIS-201/AST-L/2024', 'PW04CX0F', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 80, '2026-09-03 16:55:07', '2026-09-29 10:42:17'),
(84, 'CIS-202/AST-L/2024', 'PW04CGR5', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 81, '2026-09-03 16:55:07', '2026-09-29 10:43:08'),
(85, 'CIS-203/AST-L/2024', 'PW04DFH9', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 82, '2026-09-03 16:55:07', '2026-09-29 10:54:25'),
(86, 'CIS-204/AST-L/2024', 'PW04CX25', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 83, '2026-09-03 16:55:07', '2026-09-29 11:12:42'),
(87, 'CIS-205/AST-L/2024', 'PW04DGMR', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 84, '2026-09-03 16:55:07', '2026-09-29 11:20:34'),
(88, 'CIS-206/AST-L/2024', 'PW04CGYJ', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '8 GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'nonaktif', '', 85, '2026-09-03 16:55:07', '2026-09-29 11:27:39'),
(89, 'CIS-207/AST-L/2024', 'PW04CGX8', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 86, '2026-09-03 16:55:07', '2026-09-29 11:42:54'),
(90, 'CIS-208/AST-L/2024', 'PW04CHRB', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 2', NULL, 'digunakan', NULL, 87, '2026-09-03 16:55:07', '2026-09-29 13:20:29'),
(91, 'CIS-209/AST-L/2019', 'SCG1063XRP', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 20, '2026-09-03 16:55:07', '2026-09-29 13:22:56'),
(92, 'CIS-210/AST-L/2022', 'PW04DGDH', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2022, NULL, 'BRI 2', NULL, 'digunakan', NULL, 89, '2026-09-03 16:55:07', '2026-09-29 13:24:07'),
(93, 'CIS-211/AST-L/2026', 'PF1F8GA0', 2, 3, 'Dell', '', '', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 2', NULL, 'digunakan', NULL, 90, '2026-09-03 16:55:07', '2026-09-29 13:56:22'),
(94, 'CIS-212/AST-L/2025', 'N5PGMGVYG6', 8, 3, 'MacBook Pro 13\"', '', '', '512GB', 'MacOS', 2025, NULL, 'BRI 2', NULL, 'digunakan', NULL, 11, '2026-09-03 16:55:07', '2026-09-29 14:02:32'),
(95, 'CIS-213/AST-L/2019', 'PF1MLYVX', 1, 3, 'Lenovo ThinkPad T480', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 93, '2026-09-03 16:55:07', '2026-09-29 14:24:08'),
(96, 'CIS-214/AST-L/2019', 'PC14LRDL', 1, 3, 'Lenovo ThinkPad T480s', 'I5 Gen 8', '16GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 95, '2026-09-03 16:55:07', '2026-09-29 14:35:06'),
(97, 'CIS-215/AST-L/2019', 'SP811B3', 9, 3, 'Laptop Dell Latitude 3410', '', '', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 96, '2026-09-03 16:55:07', '2026-09-29 14:36:01'),
(98, 'CIS-216/AST-L/2022', '5CG21834MR', 4, 3, 'HP Elitebook 830 G8', '', '', '512GB', 'Windows 11 Pro', 2022, NULL, 'BRI 2', NULL, 'digunakan', NULL, 97, '2026-09-03 16:55:07', '2026-09-29 14:38:14'),
(99, 'CIS-217/AST-L/2019', 'XLTPQL06WM', 8, 3, 'Macbook Pro', '', '', '512GB', 'MacOS', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 26, '2026-09-03 16:55:07', '2026-09-29 14:39:36'),
(100, 'CIS-218/AST-L/2019', 'MCNXCV12634506', 3, 3, 'Asus ExpertBook', 'I5 1135G7', '8GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 99, '2026-09-03 16:55:07', '2026-09-29 14:42:01'),
(101, 'CIS-219/AST-L/2021', 'PW04CAPA', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 65, '2026-09-03 16:55:07', '2026-09-29 14:44:53'),
(102, 'CIS-220/AST-L/2021', 'HQ811B3', 9, 3, 'Laptop Dell Latitude 3410', '', '', '512GB', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 101, '2026-09-03 16:55:07', '2026-09-29 14:46:36'),
(103, 'CIS-221/AST-L/2021', 'PQ822B4', 9, 3, 'Laptop Dell Latitude 3410', '', '', '512GB', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 24, '2026-09-03 16:55:07', '2026-09-29 15:02:49'),
(104, 'CIS-222/AST-L/2021', '3Q811B3', 9, 3, 'Laptop Dell Latitude 3411', '', '', '512GB', 'Windows 11 Pro', 2021, NULL, 'BRI 2', NULL, 'digunakan', NULL, 24, '2026-09-03 16:55:07', '2026-09-29 15:38:08'),
(105, 'CIS-223/AST-L/2025', '5CD5144J2D', 9, 3, 'Laptop HP Elitbook 640 G11', '', '', '512GB', 'Windows 11 Pro', 2025, NULL, 'BRI 2', NULL, 'digunakan', NULL, 103, '2026-09-03 16:55:07', '2026-09-29 15:40:24'),
(106, 'CIS-224/AST-L/2025', '5CD144J36', 9, 3, 'Laptop HP Elitbook 640 G11', '', '', '512GB', 'Windows 11 Pro', 2025, NULL, 'BRI 2', NULL, 'digunakan', NULL, 57, '2026-09-03 16:55:07', '2026-09-29 15:41:59'),
(107, 'CIS-225/AST-L/2025', '5CD5222K5P', 9, 3, 'Laptop HP Elitbook 640 G11', '', '', '512GB', 'Windows 11 Pro', 2025, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(108, 'CIS-226/AST-L/2025', '5CD5222K6B', 9, 3, 'Laptop HP Elitbook 640 G11', '', '', '512GB', 'Windows 11 Pro', 2025, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(109, 'CIS-227/AST-L/2026', '9R92SB4', 2, 3, 'Dell Latitude 5450 U7', '', '', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(110, 'CIS-228/AST-L/2026', '4Q02SB4', 2, 3, 'Dell Latitude 5450 U7', '', '', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(111, 'CIS-229/AST-L/2026', 'H2W1SB4', 2, 3, 'Dell Latitude 5450 U7', '', '', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 2', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(112, 'CIS-230/AST-L/2026', 'F6Q1SB4', 2, 3, 'Dell Latitude 5450 U7', 'Intel Ultra 7', '', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 3', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(113, 'CIS-231/AST-L/2019', 'PF1MM0VN', 9, 3, 'Laptop Lenovo thinkpad T480', '', '', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 4', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(114, 'CIS-232/AST-L/2026', '8B370B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 5', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(115, 'CIS-233/AST-L/2026', '9W270B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 6', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(116, 'CIS-234/AST-L/2026', 'CM17OB4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 7', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(117, 'CIS-235/AST-L/2026', '9F570B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 8', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(118, 'CIS-236/AST-L/2026', '6Y170B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 9', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(119, 'CIS-237/AST-L/2026', '8G570B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 10', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-03 16:55:07'),
(120, 'CIS-238/AST-L/2026', 'HH170B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 11', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(121, 'CIS-239/AST-L/2026', 'H1370B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 12', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(122, 'CIS-240/AST-L/2026', '7D570B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 13', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(123, 'CIS-241/AST-L/2026', '4B170B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 14', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(124, 'CIS-242/AST-L/2026', 'JF470B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 15', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(125, 'CIS-243/AST-L/2026', 'BV270B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 16', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(126, 'CIS-244/AST-L/2026', 'FVI70B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 17', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(127, 'CIS-245/AST-L/2026', '2C170B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 18', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(128, 'CIS-246/AST-L/2026', 'F2370B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 19', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(129, 'CIS-247/AST-L/2026', 'JB170B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 20', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(130, 'CIS-248/AST-L/2026', 'HV270B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 21', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(131, 'CIS-249/AST-L/2026', 'JS170B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 22', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(132, 'CIS-250/AST-L/2026', 'F8170B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 23', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(133, 'CIS-251/AST-L/2026', '9Y370B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 24', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(134, 'CIS-252/AST-L/2026', 'FD370B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 25', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(135, 'CIS-253/AST-L/2026', 'BW070B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 26', NULL, 'tersedia', NULL, NULL, '2026-09-03 16:55:07', '2026-09-17 14:42:55'),
(136, 'CIS-254/AST-L/2026', 'BB170B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 27', NULL, 'digunakan', NULL, 73, '2026-09-03 16:55:07', '2026-09-18 16:57:57'),
(137, 'CIS-255/AST-L/2026', 'C4370B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 28', NULL, 'digunakan', NULL, 17, '2026-09-03 16:55:07', '2026-09-18 16:55:59'),
(138, 'CIS-256/AST-L/2026', 'DK170B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 29', NULL, 'digunakan', NULL, 78, '2026-09-03 16:55:07', '2026-09-18 16:54:21'),
(139, 'CIS-257/AST-L/2026', 'JG470B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 30', NULL, 'digunakan', NULL, 77, '2026-09-03 16:55:07', '2026-09-24 15:37:34'),
(140, 'CIS-258/AST-L/2026', 'B7370B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 31', NULL, 'digunakan', NULL, 62, '2026-09-03 16:55:07', '2026-09-24 14:39:51'),
(141, 'CIS-259/AST-L/2026', 'H4370B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 32', NULL, 'digunakan', NULL, 32, '2026-09-03 16:55:07', '2026-09-18 16:33:54'),
(142, 'CIS-260/AST-L/2026', 'CG570B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2026, NULL, 'BRI 33', NULL, 'digunakan', NULL, 122, '2026-09-03 16:55:07', '2026-09-18 16:32:21'),
(143, 'CIS-261/AST-L/2025', 'LXQFMF66D', 8, 3, 'Macbook Pro M5', 'M5', '16GB', '512GB', 'Windows 11 Pro', 2025, NULL, 'BRI 34', NULL, 'digunakan', NULL, 78, '2026-09-03 16:55:07', '2026-09-17 14:53:56'),
(144, 'CIS-262/AST-L/2025', '7w270B4', 2, 3, 'Dell Latitude 3450', 'Intel Ultra 5', '16GB', '512GB', 'Windows 11 Pro', 2025, NULL, 'BRI 35', NULL, 'digunakan', NULL, 124, '2026-09-03 16:55:07', '2026-09-17 15:05:26'),
(145, 'CIS-263/AST-L/2024', 'PW04C9X2', 1, 3, 'Lenovo ThinkPad L13 Gen 3', 'I5 Gen 13', '16GB', '512GB', 'Windows 11 Pro', 2024, NULL, 'BRI 36', NULL, 'digunakan', NULL, 125, '2026-09-03 16:55:07', '2026-09-17 14:58:07'),
(146, 'CIS-264/AST-L/2019', 'M8NXCV032232317', 3, 3, 'Expertbook', 'Core i5 Gen 13', '16 GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'digunakan', NULL, 128, '2026-09-07 16:34:31', '2026-09-24 15:45:34'),
(147, 'CIS-265/AST-L/2026', 'PW04CAH5', 1, 3, 'Thinkpad L13', 'Core i5 Gen 13', '16 GB', '512GB', 'Windows 11 Pro', 2023, NULL, 'BRI 2', NULL, 'rusak', 'butuh intal ulang windows', NULL, '2026-09-08 14:10:30', '2026-09-17 15:59:31'),
(148, 'CIS-266/AST-L/2019', 'M9NXCV06D023368', 3, 3, 'Expertbook B1400C', 'Core i5 Gen 12', '8 GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'rusak', '', 25, '2026-09-08 14:23:42', '2026-09-17 15:11:06'),
(149, 'CIS-267/AST-L/2019', 'M9NXCV06C98936A', 3, 3, 'Expertbook B1400C', 'Core i5 Gen 12', '8 GB', '512GB', 'Windows 11 Pro', 2019, NULL, 'BRI 2', NULL, 'rusak', '', NULL, '2026-09-08 14:28:17', '2026-09-28 10:09:11'),
(150, 'CIS-268/AST-L/2019', 'PC14RLFW', 1, 3, 'Thinkpad T480s', 'Core i5 Gen 12', '16 GB', '512GB', 'Windows 10 Pro', 2019, NULL, 'BRI 2 Lantai 9', NULL, 'nonaktif', 'Butuh install ulang', NULL, '2026-09-28 10:39:41', '2026-09-28 10:39:41');

-- --------------------------------------------------------

--
-- Table structure for table `laptop_brands`
--

CREATE TABLE `laptop_brands` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laptop_brands`
--

INSERT INTO `laptop_brands` (`id`, `name`, `logo`, `created_at`) VALUES
(1, 'Lenovo', NULL, '2026-09-03 10:53:16'),
(2, 'Dell', NULL, '2026-09-03 10:53:16'),
(3, 'ASUS', NULL, '2026-09-03 10:53:16'),
(4, 'HP', NULL, '2026-09-03 10:53:16'),
(5, 'Apple', NULL, '2026-09-03 10:53:16'),
(6, 'Acer', NULL, '2026-09-03 10:53:16'),
(7, 'MSI', NULL, '2026-09-03 10:53:16'),
(8, 'Macbook', NULL, '2026-09-03 16:55:07'),
(9, 'Laptop', NULL, '2026-09-03 16:55:07');

-- --------------------------------------------------------

--
-- Table structure for table `laptop_categories`
--

CREATE TABLE `laptop_categories` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laptop_categories`
--

INSERT INTO `laptop_categories` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'Ultrabook', 'Laptop tipis & ringan untuk mobilitas tinggi', '2026-09-03 10:53:16'),
(2, 'Business Laptop', 'Laptop standar operasional kantor', '2026-09-03 10:53:16'),
(3, 'Workstation', 'Laptop performa tinggi untuk desain/engineering', '2026-09-03 10:53:16'),
(4, 'Netbook', 'Laptop entry level untuk tugas ringan', '2026-09-03 10:53:16');

-- --------------------------------------------------------

--
-- Table structure for table `laptop_usage`
--

CREATE TABLE `laptop_usage` (
  `id` int UNSIGNED NOT NULL,
  `laptop_id` int UNSIGNED NOT NULL,
  `employee_id` int UNSIGNED DEFAULT NULL,
  `bast_id` int UNSIGNED DEFAULT NULL,
  `return_bast_id` int UNSIGNED DEFAULT NULL COMMENT 'BAST Pengembalian yang dibuat otomatis saat laptop ini dikembalikan',
  `start_date` date NOT NULL,
  `end_date` date DEFAULT NULL,
  `expected_return_date` date DEFAULT NULL,
  `return_condition` varchar(100) DEFAULT NULL,
  `return_notes` text,
  `return_photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `laptop_usage`
--

INSERT INTO `laptop_usage` (`id`, `laptop_id`, `employee_id`, `bast_id`, `return_bast_id`, `start_date`, `end_date`, `expected_return_date`, `return_condition`, `return_notes`, `return_photo`, `is_active`, `created_at`) VALUES
(16, 143, 78, 17, NULL, '2026-09-17', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-17 14:53:56'),
(17, 145, 125, 18, NULL, '2026-09-17', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-17 14:58:07'),
(18, 144, 124, 19, NULL, '2026-09-17', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-17 15:05:26'),
(19, 148, 25, 20, NULL, '2026-09-17', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-17 15:10:23'),
(20, 11, 127, 21, NULL, '2026-09-17', NULL, '2026-12-17', NULL, NULL, NULL, 1, '2026-09-17 16:07:21'),
(21, 142, 122, 22, NULL, '2026-09-18', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-18 16:32:21'),
(22, 141, 32, 23, NULL, '2026-09-18', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-18 16:33:54'),
(23, 140, 82, 24, NULL, '2026-09-18', '2026-09-18', NULL, 'baik', '', NULL, 0, '2026-09-18 16:36:35'),
(24, 138, 78, 25, NULL, '2026-09-18', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-18 16:54:21'),
(25, 137, 17, 26, NULL, '2026-09-18', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-18 16:55:59'),
(26, 136, 73, 27, NULL, '2026-09-18', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-18 16:57:57'),
(29, 140, 62, 31, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 14:49:22'),
(30, 139, 77, 32, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 15:37:34'),
(31, 149, 114, 33, NULL, '2026-09-24', '2026-09-24', NULL, 'ada_kerusakan', 'OS perlu install ulang dan baterai tidak tahan lama', NULL, 0, '2026-09-24 15:39:54'),
(32, 146, 128, 35, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 15:45:34'),
(33, 12, 11, 36, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 15:53:28'),
(34, 22, 21, 37, NULL, '2026-09-24', '2026-09-24', NULL, 'baik', '', NULL, 0, '2026-09-24 15:55:04'),
(35, 22, 18, 39, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 15:57:00'),
(36, 23, 21, 40, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 16:01:46'),
(37, 24, 23, 41, NULL, '2026-09-24', NULL, '2030-01-24', NULL, NULL, NULL, 1, '2026-09-24 16:06:12'),
(38, 25, 23, 42, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 16:23:06'),
(39, 26, 24, 43, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 16:24:10'),
(40, 27, 25, 44, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 16:33:23'),
(41, 28, 25, 45, NULL, '2026-09-24', '2026-09-24', NULL, 'ada_kerusakan', '', NULL, 0, '2026-09-24 16:35:14'),
(42, 29, 26, 47, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 16:40:50'),
(43, 30, 27, 48, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 16:44:27'),
(44, 31, 28, 49, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 16:45:37'),
(45, 32, 29, 50, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 16:47:06'),
(46, 33, 30, 51, NULL, '2026-09-24', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-24 16:48:08'),
(47, 34, 31, 52, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 09:01:00'),
(48, 35, 32, 53, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 09:10:19'),
(49, 36, 33, 54, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 09:18:39'),
(50, 37, 34, 55, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 09:23:17'),
(51, 38, 35, 56, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 10:55:46'),
(52, 39, 36, 57, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 10:56:52'),
(53, 40, 37, 58, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 14:52:20'),
(54, 41, 38, 59, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 14:53:21'),
(55, 42, 39, 60, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 15:02:10'),
(56, 43, 40, 61, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 15:19:50'),
(57, 44, 41, 62, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 15:22:12'),
(58, 45, 42, 63, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 16:13:00'),
(59, 46, 43, 64, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 16:14:02'),
(60, 47, 44, 65, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 16:40:16'),
(61, 48, 45, 66, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 16:47:09'),
(62, 49, 46, 67, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 16:48:28'),
(63, 50, 47, 68, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 16:57:24'),
(64, 51, 48, 69, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 16:59:12'),
(65, 52, 49, 70, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 17:00:14'),
(66, 53, 50, 71, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 17:01:34'),
(67, 54, 51, 72, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 17:03:28'),
(68, 55, 52, 73, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 17:04:34'),
(69, 56, 105, 74, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 17:06:26'),
(70, 57, 54, 75, NULL, '2026-09-25', '2026-09-25', NULL, 'baik', 'mendapat pergantian laptop', NULL, 0, '2026-09-25 17:07:50'),
(71, 57, 130, 77, NULL, '2026-09-25', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-25 17:10:47'),
(72, 58, 55, 78, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 10:41:06'),
(73, 59, 56, 79, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:31:41'),
(74, 60, 57, 80, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:32:47'),
(75, 61, 58, 81, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:34:55'),
(76, 62, 59, 82, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:35:49'),
(77, 63, 60, 83, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:37:06'),
(78, 64, 61, 84, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:38:39'),
(79, 65, 62, 85, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:39:32'),
(80, 66, 63, 86, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:40:20'),
(81, 67, 64, 87, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:41:10'),
(82, 68, 65, 88, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:42:17'),
(83, 69, 69, 89, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:43:11'),
(84, 70, 67, 90, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:43:56'),
(85, 71, 68, 91, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:45:17'),
(86, 72, 69, 92, NULL, '2026-09-28', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-28 16:51:49'),
(87, 73, 70, 93, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:04:24'),
(88, 74, 71, 94, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:06:21'),
(89, 75, 72, 95, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:08:16'),
(90, 76, 73, 96, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:09:55'),
(91, 77, 74, 97, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:12:08'),
(92, 78, 75, 98, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:35:04'),
(93, 79, 76, 99, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:36:43'),
(94, 80, 77, 100, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:37:30'),
(95, 81, 78, 101, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:39:33'),
(96, 82, 79, 102, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:40:18'),
(97, 83, 80, 103, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:42:17'),
(98, 84, 81, 104, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:43:08'),
(99, 85, 82, 105, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 10:54:25'),
(100, 86, 83, 106, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 11:12:42'),
(101, 87, 84, 107, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 11:20:34'),
(102, 88, 85, 108, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 11:26:58'),
(103, 89, 86, 109, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 11:42:54'),
(104, 90, 87, 110, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 13:20:29'),
(105, 91, 20, 111, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 13:22:56'),
(106, 92, 89, 112, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 13:24:07'),
(107, 93, 90, 113, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 13:56:22'),
(108, 94, 11, 114, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 14:02:32'),
(109, 95, 93, 115, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 14:24:08'),
(110, 96, 95, 116, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 14:35:06'),
(111, 97, 96, 117, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 14:36:01'),
(112, 98, 97, 118, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 14:38:14'),
(113, 99, 26, 119, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 14:39:36'),
(114, 100, 99, 120, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 14:42:01'),
(115, 101, 65, 121, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 14:44:53'),
(116, 102, 101, 122, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 14:46:36'),
(117, 103, 24, 123, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 15:02:49'),
(118, 104, 24, 124, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 15:38:08'),
(119, 105, 103, 125, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 15:40:24'),
(120, 106, 57, 126, NULL, '2026-09-29', NULL, NULL, NULL, NULL, NULL, 1, '2026-09-29 15:41:59');

-- --------------------------------------------------------

--
-- Table structure for table `maintenance`
--

CREATE TABLE `maintenance` (
  `id` int UNSIGNED NOT NULL,
  `laptop_id` int UNSIGNED NOT NULL,
  `issue` varchar(255) NOT NULL,
  `technician` varchar(150) DEFAULT NULL,
  `date_in` date NOT NULL,
  `estimated_date_out` date DEFAULT NULL,
  `date_out` date DEFAULT NULL,
  `cost` decimal(12,2) DEFAULT NULL,
  `status` enum('menunggu-sparepart','proses','selesai') NOT NULL DEFAULT 'proses',
  `notes` text,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int UNSIGNED NOT NULL,
  `type` varchar(30) NOT NULL DEFAULT 'info',
  `title` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `link` varchar(255) DEFAULT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `division` varchar(100) DEFAULT 'IT Asset Management',
  `role` enum('super_admin','admin','viewer') NOT NULL DEFAULT 'admin',
  `avatar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `phone`, `division`, `role`, `avatar`, `is_active`, `last_login`, `created_at`, `updated_at`) VALUES
(1, 'Sigit Prasetyo', 'Admin', '$2y$10$9r8k.AcHD8h745pd47xmeOu03KKNkNdF6Hv5hCYGCuJvZfuc2yWCW', '0813-2233-4455', 'IT Asset Management', 'super_admin', NULL, 1, '2026-09-29 07:34:38', '2026-09-03 10:53:16', '2026-09-29 14:34:38'),
(2, 'Nanang', 'user', '$2y$10$9r8k.AcHD8h745pd47xmeOu03KKNkNdF6Hv5hCYGCuJvZfuc2yWCW', '0812-9988-1122', 'IT Asset Management', 'admin', NULL, 1, '2026-09-29 02:56:42', '2026-09-03 10:53:16', '2026-09-29 09:56:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_log_user` (`user_id`);

--
-- Indexes for table `bast`
--
ALTER TABLE `bast`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_bast_number` (`bast_number`),
  ADD UNIQUE KEY `uq_bast_signature_token` (`signature_token`),
  ADD KEY `fk_bast_laptop` (`laptop_id`),
  ADD KEY `fk_bast_employee` (`employee_id`),
  ADD KEY `fk_bast_user` (`created_by`);

--
-- Indexes for table `bast_templates`
--
ALTER TABLE `bast_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_bast_templates_type` (`handover_type`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_employees_nik` (`nik`),
  ADD KEY `fk_employees_group` (`group_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laptops`
--
ALTER TABLE `laptops`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_laptops_asset_id` (`asset_id`),
  ADD UNIQUE KEY `uq_laptops_sn` (`serial_number`),
  ADD KEY `fk_laptops_brand` (`brand_id`),
  ADD KEY `fk_laptops_category` (`category_id`),
  ADD KEY `fk_laptops_employee` (`current_employee_id`);

--
-- Indexes for table `laptop_brands`
--
ALTER TABLE `laptop_brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laptop_categories`
--
ALTER TABLE `laptop_categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `laptop_usage`
--
ALTER TABLE `laptop_usage`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usage_laptop` (`laptop_id`),
  ADD KEY `fk_usage_employee` (`employee_id`),
  ADD KEY `fk_usage_bast` (`bast_id`),
  ADD KEY `fk_usage_return_bast` (`return_bast_id`);

--
-- Indexes for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_maintenance_laptop` (`laptop_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_users_email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_log`
--
ALTER TABLE `activity_log`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bast`
--
ALTER TABLE `bast`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `bast_templates`
--
ALTER TABLE `bast_templates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `laptops`
--
ALTER TABLE `laptops`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `laptop_brands`
--
ALTER TABLE `laptop_brands`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `laptop_categories`
--
ALTER TABLE `laptop_categories`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `laptop_usage`
--
ALTER TABLE `laptop_usage`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT for table `maintenance`
--
ALTER TABLE `maintenance`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_log`
--
ALTER TABLE `activity_log`
  ADD CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `bast`
--
ALTER TABLE `bast`
  ADD CONSTRAINT `fk_bast_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bast_laptop` FOREIGN KEY (`laptop_id`) REFERENCES `laptops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_bast_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `fk_employees_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `laptops`
--
ALTER TABLE `laptops`
  ADD CONSTRAINT `fk_laptops_brand` FOREIGN KEY (`brand_id`) REFERENCES `laptop_brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_laptops_category` FOREIGN KEY (`category_id`) REFERENCES `laptop_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_laptops_employee` FOREIGN KEY (`current_employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `laptop_usage`
--
ALTER TABLE `laptop_usage`
  ADD CONSTRAINT `fk_usage_bast` FOREIGN KEY (`bast_id`) REFERENCES `bast` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_usage_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_usage_laptop` FOREIGN KEY (`laptop_id`) REFERENCES `laptops` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usage_return_bast` FOREIGN KEY (`return_bast_id`) REFERENCES `bast` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `maintenance`
--
ALTER TABLE `maintenance`
  ADD CONSTRAINT `fk_maintenance_laptop` FOREIGN KEY (`laptop_id`) REFERENCES `laptops` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
