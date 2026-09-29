<?php $isEdit = ! empty($employee); ?>
<div class="crumb"><a href="<?= site_url('pekerja') ?>">Data Pekerja</a> / <b><?= $isEdit ? 'Edit Pekerja' : 'Tambah Pekerja' ?></b></div>
<div class="page-head">
	<div>
		<h1 class="page-title"><?= $isEdit ? 'Edit Pekerja — '.$employee['name'] : 'Tambah Pekerja Baru' ?></h1>
		<p class="page-sub">Lengkapi data karyawan sebagai calon penerima laptop.</p>
	</div>
</div>

<div class="card card-pad" style="max-width:640px;">
<form method="post" action="<?= $isEdit ? site_url('pekerja/edit/'.$employee['id']) : site_url('pekerja/tambah') ?>">
	<div class="form-grid mb-14">
		<div class="field">
			<label>PN</label>
			<input class="input" name="nik" required value="<?= $isEdit ? $employee['nik'] : '' ?>" placeholder="EMP-2026-0001" <?= $isEdit ? 'disabled' : '' ?>>
			<?php if ($isEdit): ?><span class="hint">PN tidak dapat diubah setelah dibuat.</span><?php endif; ?>
		</div>
		<div class="field"><label>Nama Lengkap</label><input class="input" name="name" required value="<?= $isEdit ? $employee['name'] : '' ?>" placeholder="Nama karyawan"></div>
		<div class="field"><label>Jabatan</label><input class="input" name="position" value="<?= $isEdit ? $employee['position'] : '' ?>" placeholder="Contoh: Sales Executive"></div>
		<div class="field"><label>Grup</label>
			<select class="select" name="group_id" style="width:100%;">
				<option value="">— Pilih Grup —</option>
				<?php foreach ($groups as $g): ?>
					<option value="<?= $g['id'] ?>" <?= ($isEdit && $employee['group_id']==$g['id']) ? 'selected':'' ?>><?= $g['name'] ?></option>
				<?php endforeach; ?>
			</select>
		</div>
		<div class="field"><label>Email</label><input class="input" type="email" name="email" value="<?= $isEdit ? $employee['email'] : '' ?>" placeholder="nama@nusantaradigital.co.id"></div>
		<div class="field"><label>Nomor HP</label><input class="input" name="phone" value="<?= $isEdit ? $employee['phone'] : '' ?>" placeholder="0812-xxxx-xxxx"></div>
	</div>
	<?php if ($isEdit): ?>
	<label class="flex items-center gap-8 mb-14" style="font-size:13px;">
		<input type="checkbox" name="is_active" value="1" <?= $employee['is_active'] ? 'checked' : '' ?>> Pekerja aktif
	</label>
	<?php endif; ?>
	<div class="btn-row">
		<button type="submit" class="btn btn-primary"><?= ic('check',15) ?> Simpan</button>
		<a href="<?= site_url('pekerja') ?>" class="btn btn-ghost">Batal</a>
	</div>
</form>
</div>
