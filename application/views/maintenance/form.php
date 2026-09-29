<div class="crumb"><a href="<?= site_url('maintenance') ?>">Maintenance</a> / <b>Catat Maintenance</b></div>
<div class="page-head"><div><h1 class="page-title">Catat Maintenance Baru</h1><p class="page-sub">Daftarkan laptop yang perlu ditangani teknisi.</p></div></div>
<div class="card card-pad" style="max-width:640px;">
<form method="post">
	<div class="field mb-14">
		<label>Pilih Laptop</label>
		<select class="select" name="laptop_id" style="width:100%;" required>
			<option value="">— Pilih Laptop —</option>
			<?php foreach ($laptops as $l): ?>
				<option value="<?= $l['id'] ?>"><?= $l['asset_id'] ?> — <?= $l['brand_name'] ?> <?= $l['model'] ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="field mb-14"><label>Keluhan / Kerusakan</label><textarea class="input" name="issue" rows="3" required placeholder="Contoh: Keyboard tidak responsif"></textarea></div>
	<div class="form-grid mb-14">
		<div class="field"><label>Teknisi / Vendor</label><input class="input" name="technician" placeholder="Contoh: Internal IT / Vendor Compnet"></div>
		<div class="field"><label>Tanggal Masuk</label><input class="input" type="date" name="date_in" value="<?= date('Y-m-d') ?>"></div>
		<div class="field"><label>Estimasi Selesai</label><input class="input" type="date" name="estimated_date_out"></div>
	</div>
	<div class="btn-row">
		<button type="submit" class="btn btn-primary"><?= ic('check',15) ?> Simpan</button>
		<a href="<?= site_url('maintenance') ?>" class="btn btn-ghost">Batal</a>
	</div>
</form>
</div>
