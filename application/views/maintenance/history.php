<div class="crumb"><a href="<?= site_url('maintenance') ?>">Maintenance</a> / <b>Riwayat Maintenance</b></div>
<div class="page-head"><div><h1 class="page-title">Riwayat Maintenance</h1><p class="page-sub">Seluruh histori perbaikan aset laptop perusahaan.</p></div></div>
<div class="card card-pad">
	<?php if (empty($items)): ?>
		<div class="empty-state"><div class="empty-ic"><?= ic('wrench',22) ?></div><p>Belum ada riwayat maintenance.</p></div>
	<?php else: ?>
	<div class="timeline">
		<?php foreach ($items as $m): ?>
		<div class="t-item">
			<div class="t-dot"><?= ic($m['status']=='selesai' ? 'check' : 'wrench',10) ?></div>
			<div class="t-date"><?= format_tanggal($m['date_in']) ?></div>
			<div class="t-title"><?= $m['asset_id'] ?> — <?= $m['issue'] ?></div>
			<div class="t-desc">Ditangani oleh <?= $m['technician'] ?> · <?= status_label($m['status']) ?><?= $m['date_out'] ? ' · Selesai '.format_tanggal($m['date_out']) : '' ?></div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>
