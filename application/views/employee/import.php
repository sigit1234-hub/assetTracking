<div class="crumb"><a href="<?= site_url('pekerja') ?>">Data Pekerja</a> / <b>Import Data</b></div>
<div class="page-head"><div><h1 class="page-title">Import Data Pekerja</h1><p class="page-sub">Unggah data karyawan secara massal menggunakan template Excel.</p></div></div>

<?php if ( ! empty($import_result)): ?>
<div class="card card-pad mb-20" style="border-color:<?= empty($import_result['errors']) ? 'var(--green-line)' : 'var(--amber-line)' ?>;">
	<div class="flex items-center gap-10 mb-14">
		<div class="alert-ic" style="background:var(--green-soft);color:var(--green);"><?= ic('check',18) ?></div>
		<div>
			<div style="font-weight:700;font-size:14.5px;"><?= $import_result['inserted'] ?> pekerja berhasil ditambahkan</div>
			<?php if ($import_result['skipped'] > 0): ?>
				<div class="cell-sub"><?= $import_result['skipped'] ?> baris dilewati — lihat detail di bawah.</div>
			<?php endif; ?>
		</div>
	</div>
	<?php if ( ! empty($import_result['errors'])): ?>
	<div style="background:var(--amber-soft);border:1px solid var(--amber-line);border-radius:9px;padding:12px 14px;max-height:220px;overflow-y:auto;">
		<?php foreach ($import_result['errors'] as $err): ?>
			<div style="font-size:12.5px;color:var(--amber);padding:3px 0;"><?= htmlspecialchars($err) ?></div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
	<div class="btn-row" style="margin-top:14px;">
		<a href="<?= site_url('pekerja') ?>" class="btn btn-primary"><?= ic('eye',15) ?> Lihat Data Pekerja</a>
		<a href="<?= site_url('pekerja/import') ?>" class="btn btn-ghost">Import Lagi</a>
	</div>
</div>
<?php endif; ?>

<div class="grid-2">
	<div class="card card-pad">
		<form method="post" enctype="multipart/form-data" action="<?= site_url('pekerja/import') ?>">
			<div style="border:1.5px dashed var(--border);border-radius:11px;padding:44px 20px;text-align:center;color:var(--ink-soft);">
				<?= ic('upload',30) ?>
				<p style="font-weight:600;color:var(--ink);margin:14px 0 4px;">Pilih file Excel dari komputer Anda</p>
				<p style="font-size:12.5px;margin:0 0 14px;">Format .xlsx atau .csv, maksimal 10MB</p>
				<input type="file" name="file" accept=".xlsx,.csv" required>
			</div>
			<button type="submit" class="btn btn-primary" style="margin-top:16px;">Proses Import</button>
		</form>
	</div>
	<div class="card card-pad">
		<h3 class="section-title">Panduan Import</h3>
		<div class="timeline">
			<div class="t-item"><div class="t-dot"><?= ic('download',10) ?></div><div class="t-title">Unduh template</div><div class="t-desc">Gunakan format kolom resmi agar data terbaca benar.</div></div>
			<div class="t-item"><div class="t-dot"><?= ic('edit',10) ?></div><div class="t-title">Isi data pekerja</div><div class="t-desc">Satu baris untuk satu pekerja. Kolom PN &amp; Nama wajib diisi.</div></div>
			<div class="t-item"><div class="t-dot"><?= ic('upload',10) ?></div><div class="t-title">Unggah &amp; validasi</div><div class="t-desc">Sistem memeriksa duplikasi PN secara otomatis.</div></div>
			<div class="t-item"><div class="t-dot"><?= ic('check',10) ?></div><div class="t-title">Konfirmasi import</div><div class="t-desc">Ringkasan baris berhasil / dilewati ditampilkan setelah proses.</div></div>
		</div>
		<a href="<?= site_url('pekerja/template') ?>" class="btn btn-soft btn-sm" style="margin-top:14px;"><?= ic('download',14) ?> Unduh Template Excel</a>

		<hr class="hr">
		<h3 class="section-title" style="margin-bottom:8px;">Kolom Template</h3>
		<p class="cell-sub" style="line-height:1.8;">
			<code>pn</code>, <code>nama</code>, <code>jabatan</code>, <code>grup</code>, <code>email</code>, <code>no_hp</code>
		</p>
		<p class="cell-sub">Grup yang belum terdaftar akan otomatis dibuat.</p>
	</div>
</div>
