-- =========================================================
-- Migration: Fitur TTD Digital pada BAST
-- Jalankan file ini HANYA jika database Anda sudah pernah
-- di-import sebelumnya (instalasi lama) dan ingin menambahkan
-- fitur tanda tangan digital tanpa install ulang dari nol.
--
-- Jika Anda baru pertama kali install, TIDAK PERLU menjalankan
-- file ini — cukup import assettrack.sql yang sudah termasuk
-- kolom-kolom berikut.
-- =========================================================

USE `assettrack`;

ALTER TABLE `bast`
	ADD COLUMN `signature_token` VARCHAR(64) DEFAULT NULL COMMENT 'Token unik untuk link tanda tangan publik (tanpa login)' AFTER `approver_name`,
	ADD COLUMN `admin_signature` VARCHAR(255) DEFAULT NULL COMMENT 'Path file gambar TTD admin (menyerahkan)' AFTER `signature_token`,
	ADD COLUMN `receiver_signature` VARCHAR(255) DEFAULT NULL COMMENT 'Path file gambar TTD penerima' AFTER `admin_signature`,
	ADD COLUMN `approver_signature` VARCHAR(255) DEFAULT NULL COMMENT 'Path file gambar TTD atasan' AFTER `receiver_signature`,
	ADD COLUMN `admin_signed_at` DATETIME DEFAULT NULL AFTER `approver_signature`,
	ADD COLUMN `receiver_signed_at` DATETIME DEFAULT NULL AFTER `admin_signed_at`,
	ADD COLUMN `approver_signed_at` DATETIME DEFAULT NULL AFTER `receiver_signed_at`,
	ADD UNIQUE KEY `uq_bast_signature_token` (`signature_token`);

-- Generate token unik untuk BAST yang sudah ada sebelumnya (agar tetap bisa dipakai fitur TTD)
UPDATE `bast` SET `signature_token` = SUBSTRING(MD5(RAND()), 1, 32) WHERE `signature_token` IS NULL;
