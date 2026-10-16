<div class="page-head">
	<div><h1 class="page-title">Riwayat Penggunaan</h1><p class="page-sub">Jejak lengkap perpindahan penggunaan seluruh aset laptop.</p></div>
</div>

<?php $this->load->view('usage/_filter', ['filters'=>$filters,'groups'=>$groups,'brands'=>$brands,'show_status'=>TRUE]); ?>
<?php if (array_filter($filters)): ?><p class="cell-sub" style="margin:0 0 10px;">Menampilkan <b><?= count($history) ?></b> hasil sesuai filter.</p><?php endif; ?>

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
			<div class="t-desc"><?= htmlspecialchars(trim($h['brand_name'].' '.$h['model'])) ?> · SN: <?= htmlspecialchars($h['serial_number']) ?> · PN: <?= htmlspecialchars($h['employee_nik']) ?> <?= $h['end_date'] ? '· Dikembalikan '.format_tanggal($h['end_date']) : '' ?></div>
			<div class="t-desc">
				<?php if ($h['bast_number']): ?>BAST Serah Terima: <a href="<?= site_url('bast/detail/'.$h['bast_id']) ?>"><b><?= $h['bast_number'] ?></b></a><?php endif; ?>
				<?php if ($h['return_bast_number']): ?> &nbsp;·&nbsp; BAST Pengembalian: <a href="<?= site_url('bast/detail/'.$h['return_bast_id']) ?>"><b><?= $h['return_bast_number'] ?></b></a><?php endif; ?>
			</div>
		</div>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>
</div>
