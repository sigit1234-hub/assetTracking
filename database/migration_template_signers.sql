-- =========================================================
-- Migration: Nama & Jabatan Penandatangan dapat diatur per Template BAST
-- Jalankan file ini HANYA jika database Anda sudah pernah
-- di-import sebelumnya. Kalau baru pertama kali install,
-- TIDAK PERLU — assettrack.sql sudah termasuk kolom ini.
-- =========================================================

USE `assettrack`;

ALTER TABLE `bast_templates`
	ADD COLUMN `signer_name` VARCHAR(150) DEFAULT NULL COMMENT 'Nama tetap Pihak Pertama/Menyerahkan. Kosongkan untuk pakai nama admin yang login.' AFTER `statement_text`,
	ADD COLUMN `signer_role` VARCHAR(150) DEFAULT NULL COMMENT 'Jabatan Pihak Pertama/Menyerahkan' AFTER `signer_name`,
	ADD COLUMN `approver_name` VARCHAR(150) DEFAULT NULL COMMENT 'Nama tetap Atasan/Mengetahui untuk template ini' AFTER `signer_role`,
	ADD COLUMN `approver_role` VARCHAR(150) DEFAULT NULL COMMENT 'Jabatan Atasan/Mengetahui' AFTER `approver_name`;

UPDATE `bast_templates` SET
	`signer_role`   = 'Admin IT Asset Management',
	`approver_name` = 'Nanang Andri Hidayat',
	`approver_role` = 'Group Head'
WHERE `signer_role` IS NULL;
