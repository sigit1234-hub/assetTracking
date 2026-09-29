-- =========================================================
-- Migration: Override manual nama penandatangan per-dokumen BAST
-- Jalankan HANYA jika database sudah pernah di-install sebelumnya.
-- =========================================================

USE `assettrack`;

ALTER TABLE `bast`
	ADD COLUMN `approver_role` VARCHAR(150) DEFAULT NULL AFTER `approver_name`,
	ADD COLUMN `signer_name` VARCHAR(150) DEFAULT NULL COMMENT 'Override manual nama Pihak Pertama/Menyerahkan khusus BAST ini' AFTER `approver_role`,
	ADD COLUMN `signer_role` VARCHAR(150) DEFAULT NULL COMMENT 'Override manual jabatan Pihak Pertama/Menyerahkan khusus BAST ini' AFTER `signer_name`;
