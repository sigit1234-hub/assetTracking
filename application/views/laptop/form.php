<?php $isEdit = ! empty($laptop); ?>
<div class="crumb"><a href="<?= site_url('laptop') ?>">Data Laptop</a> / <b><?= $isEdit ? 'Edit Laptop' : 'Tambah Laptop' ?></b></div>
<div class="page-head">
	<div>
		<h1 class="page-title"><?= $isEdit ? 'Edit Laptop — '.$laptop['asset_id'] : 'Tambah Laptop Baru' ?></h1>
		<p class="page-sub">Lengkapi data aset laptop untuk <?= $isEdit ? 'memperbarui' : 'menambahkannya ke' ?> inventaris.</p>
	</div>
</div>

<form method="post" action="<?= $isEdit ? site_url('laptop/edit/'.$laptop['id']) : site_url('laptop/tambah') ?>">
<div class="grid-2">
	<div class="card card-pad">
		<h3 class="section-title">Informasi Aset</h3>
		<div class="form-grid mb-14">
			<div class="field"><label>Asset ID</label><input class="input" id="asset-id-preview" value="<?= $isEdit ? $laptop['asset_id'] : 'CIS-'.$next_seq.'/AST-L/'.date('Y').' (otomatis)' ?>" disabled><span class="hint">Terbentuk otomatis: CIS-{nomor}/AST-L/{tahun pengadaan}</span></div>
			<div class="field"><label>Serial Number</label><input class="input" name="serial_number" required value="<?= $isEdit ? $laptop['serial_number'] : set_value('serial_number') ?>" placeholder="Contoh: PF3K9X22"></div>

			<div class="field"><label>Merk</label>
				<select class="select" name="brand_id" style="width:100%;">
					<option value="">— Pilih Merk —</option>
					<?php foreach ($brands as $b): ?>
						<option value="<?= $b['id'] ?>" <?= ($isEdit && $laptop['brand_id']==$b['id']) ? 'selected':'' ?>><?= $b['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="field"><label>Model</label><input class="input" name="model" required value="<?= $isEdit ? $laptop['model'] : '' ?>" placeholder="Contoh: ThinkPad X1 Carbon"></div>

			<div class="field"><label>Kategori</label>
				<select class="select" name="category_id" style="width:100%;">
					<option value="">— Pilih Kategori —</option>
					<?php foreach ($categories as $c): ?>
						<option value="<?= $c['id'] ?>" <?= ($isEdit && $laptop['category_id']==$c['id']) ? 'selected':'' ?>><?= $c['name'] ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="field"><label>Processor</label><input class="input" name="processor" value="<?= $isEdit ? $laptop['processor'] : '' ?>" placeholder="Contoh: Intel Core i7-1355U"></div>

			<div class="field"><label>RAM</label>
				<select class="select" name="ram" style="width:100%;">
					<?php foreach (['8 GB','16 GB','32 GB'] as $r): ?>
						<option <?= ($isEdit && $laptop['ram']==$r)?'selected':'' ?>><?= $r ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="field"><label>Storage</label><input class="input" name="storage" value="<?= $isEdit ? $laptop['storage'] : '' ?>" placeholder="Contoh: 512GB SSD"></div>

			<div class="field"><label>Sistem Operasi</label>
				<select class="select" name="os" style="width:100%;">
					<?php foreach (['Windows 11 Pro','Windows 10 Pro','macOS','Linux'] as $o): ?>
						<option <?= ($isEdit && $laptop['os']==$o)?'selected':'' ?>><?= $o ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="field"><label>Tahun Pengadaan</label><input class="input" type="number" id="purchase-year-input" name="purchase_year" min="2000" max="2100" value="<?= $isEdit ? $laptop['purchase_year'] : date('Y') ?>" <?= $isEdit ? '' : 'oninput="document.getElementById(\'asset-id-preview\').value = \'CIS-'.$next_seq.'/AST-L/\' + (this.value || '.date('Y').') + \' (otomatis)\';"' ?>></div>

			<div class="field"><label>Lokasi</label><input class="input" name="location" value="<?= $isEdit ? $laptop['location'] : '' ?>" placeholder="Contoh: Jakarta HO"></div>

			<div class="field"><label>Status Awal</label>
				<select class="select" name="status" style="width:100%;">
					<?php foreach (['tersedia'=>'Tersedia','maintenance'=>'Dalam Perbaikan','nonaktif'=>'Tidak Aktif','digunakan'=>'Sedang Digunakan','dipinjamkan'=>'Dipinjamkan','rusak'=>'Rusak'] as $k=>$v): ?>
						<option value="<?= $k ?>" <?= ($isEdit && $laptop['status']==$k)?'selected':'' ?>><?= $v ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		<hr class="hr">
		<div class="field"><label>Catatan Tambahan <span class="hint">(opsional)</span></label><textarea class="input" name="condition_notes" rows="3" placeholder="Catatan kondisi, kelengkapan, dsb."><?= $isEdit ? $laptop['condition_notes'] : '' ?></textarea></div>
		<div class="btn-row" style="margin-top:20px;">
			<button type="submit" class="btn btn-primary"><?= ic('check',15) ?> Simpan Laptop</button>
			<a href="<?= site_url('laptop') ?>" class="btn btn-ghost">Batal</a>
		</div>
	</div>
	<div class="card card-pad" style="align-self:flex-start;">
		<h3 class="section-title">Foto Perangkat</h3>
		<div style="border:1.5px dashed var(--border);border-radius:11px;padding:30px 16px;text-align:center;color:var(--ink-soft);">
			<?= ic('camera',26) ?>
			<p style="font-size:12.5px;margin:10px 0 12px;">Seret foto ke sini atau klik untuk unggah<br>PNG/JPG, maks 5MB</p>
			<input type="file" name="photo" accept="image/*">
		</div>
		<hr class="hr">
		<div class="alert-item" style="background:var(--primary-soft);border-color:#CBDBFC;">
			<div class="alert-ic" style="background:#fff;color:var(--primary);"><?= ic('qr',16) ?></div>
			<div><div class="alert-title">Asset ID &amp; QR akan digenerate otomatis</div><div class="alert-desc">Digunakan untuk pelacakan fisik &amp; label aset.</div></div>
		</div>
	</div>
</div>
</form>
