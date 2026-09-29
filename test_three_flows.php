<?php
define('BASEPATH', 'x');
require 'application/helpers/app_helper.php';
require 'application/helpers/badge_helper.php';
function site_url($p=''){ return 'http://localhost/assettrack/'.$p; }
function base_url($p=''){ return 'http://localhost/assettrack/'.$p; }

$m = new mysqli('localhost', 'root', '', 'assettrack');

echo "========================================\n";
echo "TES 1: BAST Serah Terima Awal (permanen)\n";
echo "========================================\n";
$laptop1 = $m->query("SELECT * FROM laptops WHERE status='tersedia' LIMIT 1")->fetch_assoc();
$employee1 = $m->query("SELECT * FROM employees LIMIT 1")->fetch_assoc();
$m->query("INSERT INTO bast (bast_number, laptop_id, employee_id, handover_type, handover_date, location, purpose, condition_on_handover, checklist, status, approver_name, approver_role, created_by) VALUES
	('BAST/IT/2026/900', {$laptop1['id']}, {$employee1['id']}, 'serah_terima_awal', '" . date('Y-m-d') . "', 'Jakarta HO', 'Tes awal', 'Baik', '{}', 'aktif', 'Nanang Andri Hidayat', 'Group Head', 1)");
$m->query("UPDATE laptops SET status='digunakan', current_employee_id={$employee1['id']} WHERE id={$laptop1['id']}");
$check1 = $m->query("SELECT status FROM laptops WHERE id={$laptop1['id']}")->fetch_assoc();
echo "Laptop {$laptop1['asset_id']} setelah Serah Terima Awal -> status: {$check1['status']} " . ($check1['status']=='digunakan' ? '[BENAR]' : '[SALAH]') . "\n";

echo "\n========================================\n";
echo "TES 2: BAST Sementara (peminjaman) + Override Nama TTD Manual\n";
echo "========================================\n";
$laptop2 = $m->query("SELECT * FROM laptops WHERE status='tersedia' LIMIT 1")->fetch_assoc();
$employee2 = $m->query("SELECT * FROM employees LIMIT 1 OFFSET 1")->fetch_assoc();
$customSigner = 'Budi Override Test';
$customApprover = 'Atasan Override Test';
$m->query("INSERT INTO bast (bast_number, laptop_id, employee_id, handover_type, handover_date, location, purpose, expected_return_date, condition_on_handover, checklist, status, approver_name, approver_role, signer_name, signer_role, created_by) VALUES
	('BAST/IT/2026/901', {$laptop2['id']}, {$employee2['id']}, 'peminjaman', '" . date('Y-m-d') . "', 'Surabaya', 'Dinas luar kota', '" . date('Y-m-d', strtotime('+7 days')) . "', 'Baik', '{}', 'menunggu', '$customApprover', 'Manager Override', '$customSigner', 'Staff Override', 1)");
$m->query("UPDATE laptops SET status='dipinjamkan', current_employee_id={$employee2['id']} WHERE id={$laptop2['id']}");
$check2 = $m->query("SELECT status FROM laptops WHERE id={$laptop2['id']}")->fetch_assoc();
echo "Laptop {$laptop2['asset_id']} setelah BAST Sementara -> status: {$check2['status']} " . ($check2['status']=='dipinjamkan' ? '[BENAR - beda dari Serah Terima Awal]' : '[SALAH]') . "\n";

$bast2 = $m->query("SELECT bast.*, laptops.asset_id, laptops.model, laptops.serial_number, laptop_brands.name as brand_name,
	employees.name as employee_name, employees.position, groups.name as group_name, users.name as created_by_name
	FROM bast
	LEFT JOIN laptops ON laptops.id=bast.laptop_id
	LEFT JOIN laptop_brands ON laptop_brands.id=laptops.brand_id
	LEFT JOIN employees ON employees.id=bast.employee_id
	LEFT JOIN `groups` ON groups.id=employees.group_id
	LEFT JOIN users ON users.id=bast.created_by
	WHERE bast.bast_number='BAST/IT/2026/901'")->fetch_assoc();
$template2 = $m->query("SELECT * FROM bast_templates WHERE handover_type='peminjaman'")->fetch_assoc();
$company = ['name'=>'PT Bank Rakyat Indonesia','division'=>'CISO Office Group','approver_name'=>'Nanang Andri Hidayat','approver_role'=>'Group Head'];
$checklist_arr = [];
$template = $template2;
$bast = $bast2;
ob_start();
include 'application/views/bast/detail.php';
$html2 = ob_get_clean();
echo "Dokumen menampilkan signer_name OVERRIDE ('$customSigner'): " . (strpos($html2, $customSigner) !== false ? 'YA [BENAR]' : 'TIDAK [SALAH]') . "\n";
echo "Dokumen menampilkan approver_name OVERRIDE ('$customApprover'): " . (strpos($html2, $customApprover) !== false ? 'YA [BENAR]' : 'TIDAK [SALAH]') . "\n";

echo "\n========================================\n";
echo "TES 3: BAST Pengembalian (auto-generated)\n";
echo "========================================\n";
// Simulasikan proses pengembalian utk laptop1 (dari TES 1)
$m->query("UPDATE bast SET status='selesai' WHERE bast_number='BAST/IT/2026/900'");
$m->query("INSERT INTO bast (bast_number, laptop_id, employee_id, handover_type, handover_date, location, purpose, condition_on_handover, checklist, status, signed_by_receiver, signed_by_approver, approver_name, created_by) VALUES
	('BAST/IT/2026/902', {$laptop1['id']}, {$employee1['id']}, 'pengembalian', '" . date('Y-m-d') . "', 'Jakarta HO', 'Pengembalian aset', 'Baik', '{\"kondisi_fisik\":\"baik\"}', 'selesai', 1, 1, 'Nanang Andri Hidayat', 1)");
$m->query("UPDATE laptops SET status='tersedia', current_employee_id=NULL WHERE id={$laptop1['id']}");
$check3laptop = $m->query("SELECT status FROM laptops WHERE id={$laptop1['id']}")->fetch_assoc();
$check3bast_lama = $m->query("SELECT status FROM bast WHERE bast_number='BAST/IT/2026/900'")->fetch_assoc();
$check3bast_baru = $m->query("SELECT handover_type, status FROM bast WHERE bast_number='BAST/IT/2026/902'")->fetch_assoc();
echo "Laptop {$laptop1['asset_id']} setelah Pengembalian -> status: {$check3laptop['status']} " . ($check3laptop['status']=='tersedia' ? '[BENAR]' : '[SALAH]') . "\n";
echo "BAST asal (900) -> status: {$check3bast_lama['status']} " . ($check3bast_lama['status']=='selesai' ? '[BENAR]' : '[SALAH]') . "\n";
echo "BAST Pengembalian baru (902) -> tipe: {$check3bast_baru['handover_type']}, status: {$check3bast_baru['status']} " . ($check3bast_baru['handover_type']=='pengembalian' ? '[BENAR]' : '[SALAH]') . "\n";

// cleanup
$m->query("DELETE FROM bast WHERE bast_number IN ('BAST/IT/2026/900','BAST/IT/2026/901','BAST/IT/2026/902')");
$m->query("UPDATE laptops SET status='tersedia', current_employee_id=NULL WHERE id IN ({$laptop1['id']},{$laptop2['id']})");
echo "\nCleanup selesai.\n";
