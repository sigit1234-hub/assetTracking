-- Hubungkan BAST Pengembalian lama ke sesi penggunaan (riwayat laptop)
-- Jalankan hanya jika kolom return_bast_id sudah ada (lihat migration_bast_templates.sql)
UPDATE laptop_usage lu
JOIN bast b ON b.laptop_id = lu.laptop_id
	AND b.handover_type = 'pengembalian'
	AND b.employee_id = lu.employee_id
	AND b.handover_date = lu.end_date
SET lu.return_bast_id = b.id
WHERE lu.return_bast_id IS NULL AND lu.end_date IS NOT NULL;
