-- =========================================================
-- AssetTrack - Sistem Tracking Laptop & Manajemen BAST
-- Database: MySQL 5.7+ / MariaDB 10.3+
-- =========================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE DATABASE IF NOT EXISTS `assettrack` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `assettrack`;

-- ---------------------------------------------------------
-- users  (Admin / operator sistem)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(30) DEFAULT NULL,
  `division` VARCHAR(100) DEFAULT 'IT Asset Management',
  `role` ENUM('super_admin','admin','viewer') NOT NULL DEFAULT 'admin',
  `avatar` VARCHAR(255) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `last_login` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- password for all seed users = "password123"  (bcrypt)
-- password untuk semua akun seed = "password123"
INSERT INTO `users` (`name`,`email`,`password`,`phone`,`division`,`role`) VALUES
('Dimas Ramadhan','admin.it@nusantaradigital.co.id','$2y$10$9r8k.AcHD8h745pd47xmeOu03KKNkNdF6Hv5hCYGCuJvZfuc2yWCW','0813-2233-4455','IT Asset Management','super_admin'),
('Nadia Putri','nadia.putri@nusantaradigital.co.id','$2y$10$9r8k.AcHD8h745pd47xmeOu03KKNkNdF6Hv5hCYGCuJvZfuc2yWCW','0812-9988-1122','IT Asset Management','admin');

-- ---------------------------------------------------------
-- laptop_categories
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `laptop_categories`;
CREATE TABLE `laptop_categories` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `laptop_categories` (`name`,`description`) VALUES
('Ultrabook','Laptop tipis & ringan untuk mobilitas tinggi'),
('Business Laptop','Laptop standar operasional kantor'),
('Workstation','Laptop performa tinggi untuk desain/engineering'),
('Netbook','Laptop entry level untuk tugas ringan');

-- ---------------------------------------------------------
-- laptop_brands
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `laptop_brands`;
CREATE TABLE `laptop_brands` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `logo` VARCHAR(255) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `laptop_brands` (`name`) VALUES
('Lenovo'),('Dell'),('ASUS'),('HP'),('Apple'),('Acer'),('MSI');

-- ---------------------------------------------------------
-- groups (grup/departemen pekerja)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `groups` (`name`) VALUES
('Finance'),('Marketing'),('Sales'),('Design'),('Human Resources'),('Operations'),('IT'),('Legal');

-- ---------------------------------------------------------
-- employees (calon / pengguna penerima laptop)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nik` VARCHAR(30) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `position` VARCHAR(100) DEFAULT NULL,
  `group_id` INT UNSIGNED DEFAULT NULL,
  `email` VARCHAR(150) DEFAULT NULL,
  `phone` VARCHAR(30) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_employees_nik` (`nik`),
  KEY `fk_employees_group` (`group_id`),
  CONSTRAINT `fk_employees_group` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `employees` (`nik`,`name`,`position`,`group_id`,`email`,`phone`) VALUES
('EMP-2019-0341','Budi Santoso','Finance Staff',1,'budi.santoso@nusantaradigital.co.id','0812-1111-2222'),
('EMP-2020-0212','Siti Aminah','Marketing Executive',2,'siti.aminah@nusantaradigital.co.id','0812-3333-4444'),
('EMP-2021-0187','Rahmat Hidayat','Sales Executive',3,'rahmat.hidayat@nusantaradigital.co.id','0812-3456-7890'),
('EMP-2022-0098','Clara Wijaya','UI/UX Designer',4,'clara.wijaya@nusantaradigital.co.id','0812-5555-6666'),
('EMP-2018-0055','Andi Prasetyo','HR Generalist',5,'andi.prasetyo@nusantaradigital.co.id','0812-7777-8888'),
('EMP-2023-0301','Novi Lestari','Operations Staff',6,'novi.lestari@nusantaradigital.co.id','0812-9999-0000'),
('EMP-2017-0021','Ade Kurnia','Finance Manager',1,'ade.kurnia@nusantaradigital.co.id','0812-1212-1212'),
('EMP-2022-0140','Yusuf Maulana','Operations Staff',6,'yusuf.maulana@nusantaradigital.co.id','0812-4141-4141');

-- ---------------------------------------------------------
-- laptops (aset utama)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `laptops`;
CREATE TABLE `laptops` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `asset_id` VARCHAR(30) NOT NULL,
  `serial_number` VARCHAR(100) NOT NULL,
  `brand_id` INT UNSIGNED DEFAULT NULL,
  `category_id` INT UNSIGNED DEFAULT NULL,
  `model` VARCHAR(150) NOT NULL,
  `processor` VARCHAR(100) DEFAULT NULL,
  `ram` VARCHAR(30) DEFAULT NULL,
  `storage` VARCHAR(50) DEFAULT NULL,
  `os` VARCHAR(50) DEFAULT NULL,
  `purchase_year` YEAR DEFAULT NULL,
  `purchase_price` DECIMAL(14,2) DEFAULT NULL,
  `location` VARCHAR(100) DEFAULT NULL,
  `photo` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('tersedia','digunakan','maintenance','dipinjamkan','rusak','nonaktif') NOT NULL DEFAULT 'tersedia',
  `condition_notes` TEXT DEFAULT NULL,
  `current_employee_id` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_laptops_asset_id` (`asset_id`),
  UNIQUE KEY `uq_laptops_sn` (`serial_number`),
  KEY `fk_laptops_brand` (`brand_id`),
  KEY `fk_laptops_category` (`category_id`),
  KEY `fk_laptops_employee` (`current_employee_id`),
  CONSTRAINT `fk_laptops_brand` FOREIGN KEY (`brand_id`) REFERENCES `laptop_brands` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_laptops_category` FOREIGN KEY (`category_id`) REFERENCES `laptop_categories` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_laptops_employee` FOREIGN KEY (`current_employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `laptops`
(`asset_id`,`serial_number`,`brand_id`,`category_id`,`model`,`processor`,`ram`,`storage`,`os`,`purchase_year`,`purchase_price`,`location`,`status`,`current_employee_id`) VALUES
('CIS-128/AST-L/2024','PF3K9X21',1,1,'ThinkPad X1 Carbon Gen 11','Intel Core i7-1355U','16 GB','512GB SSD','Windows 11 Pro',2024,24900000,'Jakarta HO',   'digunakan',1),
('CIS-92/AST-L/2023','DL5440-7781',2,2,'Latitude 5440','Intel Core i5-1335U','8 GB','256GB SSD','Windows 11 Pro',2023,17500000,'Gudang IT',    'tersedia',NULL),
('CIS-55/AST-L/2024','AS-EB5-4471',3,2,'ExpertBook B5','Intel Core i5-1240P','16 GB','512GB SSD','Windows 11 Pro',2024,19800000,'Jakarta HO',   'digunakan',2),
('CIS-110/AST-L/2023','HP840-9932',4,2,'EliteBook 840 G9','Intel Core i7-1265U','16 GB','1TB SSD','Windows 11 Pro',2023,21500000,'Surabaya',     'dipinjamkan',3),
('CIS-23/AST-L/2022','TP-T14-1123',1,2,'ThinkPad T14','AMD Ryzen 7 5825U','16 GB','512GB SSD','Windows 10 Pro',2022,16900000,'Workshop IT',  'maintenance',NULL),
('CIS-71/AST-L/2024','MBA-M2-8820',5,1,'MacBook Air M2','Apple M2','8 GB','256GB SSD','macOS',2024,19900000,'Jakarta HO',   'digunakan',4),
('CIS-15/AST-L/2021','AS-VB-3390',3,4,'Vivobook Pro','Intel Core i5-1135G7','8 GB','512GB SSD','Windows 10 Pro',2021,11500000,'Gudang IT',    'rusak',NULL),
('CIS-3/AST-L/2020','DL-V34-0092',2,4,'Vostro 3400','Intel Core i3-1115G4','8 GB','256GB SSD','Windows 10 Pro',2020,9800000,'Gudang IT',     'nonaktif',NULL),
('CIS-44/AST-L/2023','DL5430-1187',2,2,'Latitude 5430','Intel Core i5-1245U','8 GB','256GB SSD','Windows 11 Pro',2023,16800000,'Jakarta HO',   'digunakan',6),
('CIS-66/AST-L/2021','HPPB440-552',4,4,'ProBook 440','Intel Core i5-1135G7','8 GB','256GB SSD','Windows 10 Pro',2021,12500000,'Jakarta HO',   'tersedia',NULL);

-- ---------------------------------------------------------
-- bast (Berita Acara Serah Terima)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `bast`;
CREATE TABLE `bast` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `bast_number` VARCHAR(50) NOT NULL,
  `laptop_id` INT UNSIGNED NOT NULL,
  `employee_id` INT UNSIGNED NOT NULL,
  `handover_type` ENUM('serah_terima_awal','peminjaman','pengembalian') NOT NULL DEFAULT 'serah_terima_awal',
  `handover_date` DATE NOT NULL,
  `location` VARCHAR(150) DEFAULT NULL,
  `purpose` VARCHAR(255) DEFAULT NULL,
  `expected_return_date` DATE DEFAULT NULL,
  `condition_on_handover` VARCHAR(100) DEFAULT 'Baik',
  `checklist` TEXT DEFAULT NULL COMMENT 'JSON kelengkapan: laptop,charger,tas,mouse,adapter,lainnya',
  `notes` TEXT DEFAULT NULL,
  `status` ENUM('draft','menunggu','aktif','selesai','dibatalkan') NOT NULL DEFAULT 'draft',
  `signed_by_receiver` TINYINT(1) NOT NULL DEFAULT 0,
  `signed_by_approver` TINYINT(1) NOT NULL DEFAULT 0,
  `approver_name` VARCHAR(150) DEFAULT NULL,
  `approver_role` VARCHAR(150) DEFAULT NULL,
  `signer_name` VARCHAR(150) DEFAULT NULL COMMENT 'Override manual nama Pihak Pertama/Menyerahkan khusus BAST ini',
  `signer_role` VARCHAR(150) DEFAULT NULL COMMENT 'Override manual jabatan Pihak Pertama/Menyerahkan khusus BAST ini',
  `signature_token` VARCHAR(64) DEFAULT NULL COMMENT 'Token unik untuk link tanda tangan publik (tanpa login)',
  `receiver_token` VARCHAR(64) DEFAULT NULL COMMENT 'Token link TTD penyerah/penerima',
  `approver_token` VARCHAR(64) DEFAULT NULL COMMENT 'Token link TTD Team Leader/atasan',
  `admin_signature` VARCHAR(255) DEFAULT NULL COMMENT 'Path file gambar TTD admin (menyerahkan)',
  `receiver_signature` VARCHAR(255) DEFAULT NULL COMMENT 'Path file gambar TTD penerima',
  `approver_signature` VARCHAR(255) DEFAULT NULL COMMENT 'Path file gambar TTD atasan',
  `admin_signed_at` DATETIME DEFAULT NULL,
  `receiver_signed_at` DATETIME DEFAULT NULL,
  `approver_signed_at` DATETIME DEFAULT NULL,
  `qr_code` VARCHAR(255) DEFAULT NULL,
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_bast_number` (`bast_number`),
  UNIQUE KEY `uq_bast_signature_token` (`signature_token`),
  UNIQUE KEY `uq_bast_receiver_token` (`receiver_token`),
  UNIQUE KEY `uq_bast_approver_token` (`approver_token`),
  KEY `fk_bast_laptop` (`laptop_id`),
  KEY `fk_bast_employee` (`employee_id`),
  KEY `fk_bast_user` (`created_by`),
  CONSTRAINT `fk_bast_laptop` FOREIGN KEY (`laptop_id`) REFERENCES `laptops` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bast_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_bast_user` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `bast`
(`bast_number`,`laptop_id`,`employee_id`,`handover_type`,`handover_date`,`location`,`purpose`,`expected_return_date`,`checklist`,`status`,`signed_by_receiver`,`signed_by_approver`,`approver_name`,`created_by`) VALUES
('BAST/IT/2026/001',1,1,'serah_terima_awal','2024-01-12','Jakarta HO','Operasional harian Finance',NULL,'{"laptop":"lengkap","charger":"lengkap","tas":"lengkap","mouse":"lengkap","adapter":"lengkap"}','aktif',1,1,'Nanang Andri Hidayat',1),
('BAST/IT/2026/002',3,2,'serah_terima_awal','2024-02-22','Jakarta HO','Operasional harian Marketing',NULL,'{"laptop":"lengkap","charger":"lengkap","tas":"lengkap","mouse":"lengkap","adapter":"lengkap"}','aktif',1,1,'Nanang Andri Hidayat',1),
('BAST/IT/2026/003',4,3,'peminjaman','2026-06-18','Surabaya','Perjalanan dinas Sales','2026-08-29','{"laptop":"lengkap","charger":"lengkap","tas":"lengkap","mouse":"tidak_ada","adapter":"lengkap"}','menunggu',0,0,'Nanang Andri Hidayat',1),
('BAST/IT/2026/004',6,4,'serah_terima_awal','2024-03-30','Jakarta HO','Operasional harian Design',NULL,'{"laptop":"lengkap","charger":"lengkap","tas":"lengkap","mouse":"lengkap","adapter":"lengkap"}','aktif',1,1,'Nanang Andri Hidayat',1),
('BAST/IT/2026/005',2,5,'serah_terima_awal','2022-08-01','Jakarta HO','Operasional harian HR','2026-01-01','{"laptop":"lengkap","charger":"lengkap","tas":"lengkap","mouse":"lengkap","adapter":"lengkap"}','selesai',1,1,'Nanang Andri Hidayat',1),
('BAST/IT/2026/006',7,8,'serah_terima_awal','2021-05-14','Gudang IT','Operasional harian Ops',NULL,'{"laptop":"lengkap","charger":"lengkap","tas":"tidak_lengkap","mouse":"tidak_ada","adapter":"lengkap"}','dibatalkan',0,0,NULL,1),
('BAST/IT/2026/007',9,6,'serah_terima_awal','2026-06-10','Jakarta HO','Operasional harian Ops','2026-08-24','{"laptop":"lengkap","charger":"lengkap","tas":"lengkap","mouse":"lengkap","adapter":"lengkap"}','aktif',1,1,'Nanang Andri Hidayat',2);

-- ---------------------------------------------------------
-- laptop_usage (riwayat penggunaan / linimasa aset)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `laptop_usage`;
CREATE TABLE `laptop_usage` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `laptop_id` INT UNSIGNED NOT NULL,
  `employee_id` INT UNSIGNED DEFAULT NULL,
  `bast_id` INT UNSIGNED DEFAULT NULL,
  `return_bast_id` INT UNSIGNED DEFAULT NULL COMMENT 'BAST Pengembalian yang dibuat otomatis saat laptop ini dikembalikan',
  `start_date` DATE NOT NULL,
  `end_date` DATE DEFAULT NULL,
  `expected_return_date` DATE DEFAULT NULL,
  `return_condition` VARCHAR(100) DEFAULT NULL,
  `return_notes` TEXT DEFAULT NULL,
  `return_photo` VARCHAR(255) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_usage_laptop` (`laptop_id`),
  KEY `fk_usage_employee` (`employee_id`),
  KEY `fk_usage_bast` (`bast_id`),
  KEY `fk_usage_return_bast` (`return_bast_id`),
  CONSTRAINT `fk_usage_laptop` FOREIGN KEY (`laptop_id`) REFERENCES `laptops` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_usage_employee` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_usage_bast` FOREIGN KEY (`bast_id`) REFERENCES `bast` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_usage_return_bast` FOREIGN KEY (`return_bast_id`) REFERENCES `bast` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `laptop_usage` (`laptop_id`,`employee_id`,`bast_id`,`start_date`,`end_date`,`expected_return_date`,`is_active`) VALUES
(1,1,1,'2024-01-12',NULL,NULL,1),
(3,2,2,'2024-02-22',NULL,NULL,1),
(4,3,3,'2026-06-18',NULL,'2026-08-29',1),
(6,4,4,'2024-03-30',NULL,NULL,1),
(2,5,5,'2022-08-01','2026-01-01',NULL,0),
(9,6,7,'2026-06-10',NULL,'2026-08-24',1);

-- ---------------------------------------------------------
-- maintenance
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `maintenance`;
CREATE TABLE `maintenance` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `laptop_id` INT UNSIGNED NOT NULL,
  `issue` VARCHAR(255) NOT NULL,
  `technician` VARCHAR(150) DEFAULT NULL,
  `date_in` DATE NOT NULL,
  `estimated_date_out` DATE DEFAULT NULL,
  `date_out` DATE DEFAULT NULL,
  `cost` DECIMAL(12,2) DEFAULT NULL,
  `status` ENUM('menunggu-sparepart','proses','selesai') NOT NULL DEFAULT 'proses',
  `notes` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_maintenance_laptop` (`laptop_id`),
  CONSTRAINT `fk_maintenance_laptop` FOREIGN KEY (`laptop_id`) REFERENCES `laptops` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `maintenance` (`laptop_id`,`issue`,`technician`,`date_in`,`estimated_date_out`,`date_out`,`status`) VALUES
(5,'Keyboard tidak responsif','Vendor: Compnet Service','2026-05-20','2026-05-27',NULL,'proses'),
(7,'Layar retak, motherboard rusak','Internal IT','2026-05-02',NULL,NULL,'menunggu-sparepart'),
(10,'Baterai drop cepat','Internal IT','2026-04-10','2026-04-15','2026-04-15','selesai');

-- ---------------------------------------------------------
-- notifications
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(30) NOT NULL DEFAULT 'info',
  `title` VARCHAR(255) NOT NULL,
  `description` VARCHAR(255) DEFAULT NULL,
  `link` VARCHAR(255) DEFAULT NULL,
  `is_read` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `notifications` (`type`,`title`,`description`,`link`) VALUES
('bast','BAST/IT/2026/003 menunggu tanda tangan','Rahmat Hidayat (Sales) belum menandatangani dokumen.','bast/detail/3'),
('warning','CIS-110/AST-L/2023 akan jatuh tempo pengembalian','Batas pengembalian dalam 3 hari.','laptop/detail/4'),
('maintenance','CIS-23/AST-L/2022 membutuhkan maintenance lanjutan','Vendor melaporkan butuh sparepart tambahan.','maintenance'),
('success','CIS-92/AST-L/2023 telah dikembalikan','Dikembalikan dalam kondisi baik.','laptop/detail/2'),
('bast','BAST/IT/2026/001 telah disetujui atasan','Disetujui oleh Nanang Andri Hidayat (Group Head).','bast/detail/1');

-- ---------------------------------------------------------
-- activity_log (audit trail sederhana)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `activity_log`;
CREATE TABLE `activity_log` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED DEFAULT NULL,
  `action` VARCHAR(255) NOT NULL,
  `module` VARCHAR(50) DEFAULT NULL,
  `reference_id` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_log_user` (`user_id`),
  CONSTRAINT `fk_log_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ---------------------------------------------------------
-- bast_templates (konten dapat disunting lewat menu Template BAST)
-- ---------------------------------------------------------
DROP TABLE IF EXISTS `bast_templates`;
CREATE TABLE `bast_templates` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `handover_type` ENUM('serah_terima_awal','peminjaman','pengembalian') NOT NULL,
  `title` VARCHAR(150) NOT NULL COMMENT 'Nama template, misal: Template Serah Terima Awal',
  `document_title` VARCHAR(255) NOT NULL COMMENT 'Judul dokumen, misal: BERITA ACARA SERAH TERIMA PERANGKAT LAPTOP',
  `statement_text` TEXT NOT NULL COMMENT 'Paragraf pernyataan tanggung jawab pada dokumen',
  `signer_name` VARCHAR(150) DEFAULT NULL COMMENT 'Nama tetap Pihak Pertama/Menyerahkan. Kosongkan untuk pakai nama admin yang login.',
  `signer_role` VARCHAR(150) DEFAULT NULL COMMENT 'Jabatan Pihak Pertama/Menyerahkan, contoh: Admin IT Asset Management',
  `approver_name` VARCHAR(150) DEFAULT NULL COMMENT 'Nama tetap Atasan/Mengetahui untuk template ini. Kosongkan untuk pakai default perusahaan.',
  `approver_role` VARCHAR(150) DEFAULT NULL COMMENT 'Jabatan Atasan/Mengetahui, contoh: Group Head',
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_bast_templates_type` (`handover_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `bast_templates` (`handover_type`,`title`,`document_title`,`statement_text`,`signer_role`,`approver_name`,`approver_role`) VALUES
('serah_terima_awal','Template Serah Terima Awal','BERITA ACARA SERAH TERIMA PERANGKAT LAPTOP',
 'Pihak Kedua menyatakan telah menerima perangkat dalam kondisi baik dan bertanggung jawab penuh atas pemeliharaan serta keamanan perangkat tersebut, dan wajib mengembalikannya sesuai dengan ketentuan perusahaan yang berlaku.',
 'Admin IT Asset Management', 'Nanang Andri Hidayat', 'Group Head'),
('peminjaman','Template Serah Terima Sementara','BERITA ACARA SERAH TERIMA SEMENTARA PERANGKAT LAPTOP',
 'Pihak Kedua menyatakan telah menerima perangkat dalam kondisi baik untuk keperluan sementara sebagaimana disebutkan di atas, dan wajib mengembalikan perangkat tersebut paling lambat pada tanggal estimasi pengembalian dalam kondisi baik dan lengkap.',
 'Admin IT Asset Management', 'Nanang Andri Hidayat', 'Group Head'),
('pengembalian','Template Pengembalian Aset','BERITA ACARA PENGEMBALIAN PERANGKAT LAPTOP',
 'Dokumen ini menyatakan bahwa Pihak Kedua telah mengembalikan perangkat sebagaimana disebutkan di atas kepada Pihak Pertama, beserta kondisi dan kelengkapan sebagaimana tercatat, dan dengan ini tanggung jawab Pihak Kedua atas perangkat tersebut dinyatakan berakhir.',
 'Admin IT Asset Management', 'Nanang Andri Hidayat', 'Group Head');

SET FOREIGN_KEY_CHECKS = 1;
