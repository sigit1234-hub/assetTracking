-- Token TTD terpisah per peran (Penyerah & Team Leader) agar dapat dibuat ulang sendiri-sendiri.
-- Jalankan sekali pada database yang sudah ada.
USE `assettrack`;

ALTER TABLE `bast`
	ADD COLUMN `receiver_token` VARCHAR(64) DEFAULT NULL COMMENT 'Token link TTD penyerah/penerima' AFTER `signature_token`,
	ADD COLUMN `approver_token` VARCHAR(64) DEFAULT NULL COMMENT 'Token link TTD Team Leader/atasan' AFTER `receiver_token`,
	ADD UNIQUE KEY `uq_bast_receiver_token` (`receiver_token`),
	ADD UNIQUE KEY `uq_bast_approver_token` (`approver_token`);

-- Isi token awal untuk semua BAST yang sudah ada
UPDATE `bast` SET `receiver_token` = SHA1(CONCAT(id, RAND(), NOW(), 'r')) WHERE `receiver_token` IS NULL;
UPDATE `bast` SET `approver_token` = SHA1(CONCAT(id, RAND(), NOW(), 'a')) WHERE `approver_token` IS NULL;
