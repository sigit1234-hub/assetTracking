<div class="page-head">
	<div><h1 class="page-title">Riwayat Penggunaan</h1><p class="page-sub">Jejak lengkap perpindahan penggunaan seluruh aset laptop.</p></div>
</div>

<form method="get" class="filter-bar">
	<select class="select" name="laptop_id" onchange="this.form.submit()">
		<option value="">Semua Laptop</option>
		<?php foreach ($laptops as $l): ?><option value="<?= $l['id'] ?>" <?= $this->input->get('laptop_id')==$l['id']?'selected':'' ?>><?= $l['asset_id'] ?> — <?= $l['model'] ?></option><?php endforeach; ?>
	</select>
	<select class="select" name="group_id" onchange="this.form.submit()">
		<option value="">Semua Grup</option>
		<?php foreach ($groups as $d): ?><option value="<?= $d['id'] ?>" <?= $this->input->get('group_id')==$d['id']?'selected':'' ?>><?= $d['name'] ?></option><?php endforeach; ?>
	</select>
</form>

<div class="card card-pad">
	<?php if (empty($history)): ?>
		<div class="empty-state"><div class="empty-ic"><?= ic('clock',22) ?></div><p>Belum ada riwayat penggunaan yang cocok dengan filter.</p></div>
	<?php else: ?>
	<div class="timeline">
		<?php foreach ($history as $h): ?>
		<div class="t-item">
			<div class="t-dot"><?= ic($h['end_date'] ? 'box' : 'swap',10) ?></div>
			<div class="t-date"><?= format_tanggal($h['start_date']) ?></div>
			<div class="t-title"><?= $h['employee_name'] ?: '—' ?> <?= $h['end_date'] ? 'mengembalikan' : 'mulai menggunakan' ?> <?= $h['asset_id'] ?></div>
			<div class="t-desc"><?= $h['model'] ?> <?= $h['bast_number'] ? '· BAST: '.$h['bast_number'] : '' ?> <?= $h['end_date'] ? '· Dikembalikan '.format_tanggal($h['end_date']) : '' ?></div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>
