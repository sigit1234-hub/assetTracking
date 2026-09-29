-- =========================================================
-- Migration: Template BAST + Pengembalian Aset Otomatis
-- Jalankan file ini HANYA jika database Anda sudah pernah
-- di-import sebelumnya (instalasi lama). Kalau baru install
-- dari nol, TIDAK PERLU — cukup import assettrack.sql yang
-- sudah termasuk semua perubahan ini.
-- =========================================================

USE `assettrack`;

ALTER TABLE `laptop_usage`
	ADD COLUMN `return_bast_id` INT UNSIGNED DEFAULT NULL COMMENT 'BAST Pengembalian yang dibuat otomatis saat laptop ini dikembalikan' AFTER `bast_id`,
	ADD KEY `fk_usage_return_bast` (`return_bast_id`),
	ADD CONSTRAINT `fk_usage_return_bast` FOREIGN KEY (`return_bast_id`) REFERENCES `bast` (`id`) ON DELETE SET NULL;

DROP TABLE IF EXISTS `bast_templates`;
CREATE TABLE `bast_templates` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `handover_type` ENUM('serah_terima_awal','peminjaman','pengembalian') NOT NULL,
  `title` VARCHAR(150) NOT NULL,
  `document_title` VARCHAR(255) NOT NULL,
  `statement_text` TEXT NOT NULL,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_bast_templates_type` (`handover_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `bast_templates` (`handover_type`,`title`,`document_title`,`statement_text`) VALUES
('serah_terima_awal','Template Serah Terima Awal','BERITA ACARA SERAH TERIMA PERANGKAT LAPTOP',
 'Pihak Kedua menyatakan telah menerima perangkat dalam kondisi baik dan bertanggung jawab penuh atas pemeliharaan serta keamanan perangkat tersebut, dan wajib mengembalikannya sesuai dengan ketentuan perusahaan yang berlaku.'),
('peminjaman','Template Serah Terima Sementara','BERITA ACARA SERAH TERIMA SEMENTARA PERANGKAT LAPTOP',
 'Pihak Kedua menyatakan telah menerima perangkat dalam kondisi baik untuk keperluan sementara sebagaimana disebutkan di atas, dan wajib mengembalikan perangkat tersebut paling lambat pada tanggal estimasi pengembalian dalam kondisi baik dan lengkap.'),
('pengembalian','Template Pengembalian Aset','BERITA ACARA PENGEMBALIAN PERANGKAT LAPTOP',
 'Dokumen ini menyatakan bahwa Pihak Kedua telah mengembalikan perangkat sebagaimana disebutkan di atas kepada Pihak Pertama, beserta kondisi dan kelengkapan sebagaimana tercatat, dan dengan ini tanggung jawab Pihak Kedua atas perangkat tersebut dinyatakan berakhir.');
