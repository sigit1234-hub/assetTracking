<div class="page-head">
	<div>
		<h1 class="page-title">Dashboard Aset Laptop</h1>
		<p class="page-sub">Ringkasan kondisi dan aktivitas aset laptop perusahaan hari ini.</p>
	</div>
</div>

<div class="stat-grid">
	<?php
	function stat_card($icon,$label,$num,$unit,$color){
		$colors=['blue'=>['var(--primary-soft)','var(--primary)'],'green'=>['var(--green-soft)','var(--green)'],
			'amber'=>['var(--amber-soft)','var(--amber)'],'purple'=>['var(--purple-soft)','var(--purple)'],
			'teal'=>['var(--teal-soft)','var(--teal)'],'red'=>['var(--red-soft)','var(--red)']];
		$c=$colors[$color];
		echo '<div class="stat-card"><div class="stat-top"><div class="stat-icon" style="background:'.$c[0].';color:'.$c[1].';">'.ic($icon,16).'</div></div>
		<div><div class="stat-num">'.$num.' <span style="font-size:12px;color:var(--ink-soft);font-weight:600;">'.$unit.'</span></div>
		<div class="stat-label">'.$label.'</div></div></div>';
	}
	stat_card('box','Total Laptop',$total_laptop,'Unit','blue');
	stat_card('users','Sedang Digunakan',$status['digunakan'],'Unit','blue');
	stat_card('check','Tersedia',$status['tersedia'],'Unit','green');
	stat_card('wrench','Dalam Perbaikan',$status['maintenance'],'Unit','amber');
	stat_card('swap','Dipinjamkan',$status['dipinjamkan'],'Unit','purple');
	stat_card('filesig','BAST Aktif',$bast_active,'Dokumen','teal');
	?>
</div>

<div class="grid-2 mb-20">
	<div class="card card-pad">
		<div class="flex justify-between items-center mb-14">
			<h3 class="section-title" style="margin:0;">Grafik Penggunaan Laptop</h3>
		</div>
		<canvas id="chartUsage" height="150"></canvas>
	</div>
	<div class="card card-pad">
		<h3 class="section-title">Status Laptop</h3>
		<canvas id="chartStatus" height="180"></canvas>
		<div style="display:flex;flex-direction:column;gap:8px;margin-top:14px;">
			<?php
			$legend = [
				['var(--primary)','Digunakan',$status['digunakan']],
				['var(--green)','Tersedia',$status['tersedia']],
				['var(--amber)','Maintenance',$status['maintenance']],
				['var(--red)','Rusak',$status['rusak']],
				['var(--slate)','Tidak Aktif',$status['nonaktif']],
			];
			foreach ($legend as $l):
			?>
			<div class="flex justify-between items-center" style="font-size:12.5px;">
				<span class="flex items-center gap-8"><span style="width:9px;height:9px;border-radius:3px;background:<?= $l[0] ?>;display:inline-block;"></span><?= $l[1] ?></span><b><?= $l[2] ?></b>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<div class="grid-2">
	<div class="card">
		<div class="table-toolbar">
			<h3 class="section-title" style="margin:0;">Laptop Terbaru</h3>
			<a style="font-size:12.5px;color:var(--primary);font-weight:600;" href="<?= site_url('laptop') ?>">Lihat semua <?= ic('arrowRight',12) ?></a>
		</div>
		<div class="table-wrap" style="border:none;border-radius:0;">
			<table style="min-width:600px;">
				<thead><tr><th>Asset ID</th><th>User</th><th>Grup</th><th>Laptop</th><th>Status</th><th></th></tr></thead>
				<tbody>
				<?php if (empty($recent)): ?>
					<tr><td colspan="6" class="muted" style="text-align:center;padding:24px;">Belum ada data laptop.</td></tr>
				<?php else: foreach ($recent as $l): ?>
					<tr>
						<td><span class="asset-tag"><?= $l['asset_id'] ?></span></td>
						<td><?= $l['employee_name'] ?: '—' ?></td>
						<td><?= $l['group_name'] ?: '—' ?></td>
						<td class="cell-main"><?= $l['brand_name'] . ' ' . $l['model'] ?></td>
						<td><?= status_badge($l['status']) ?></td>
						<td><a class="act-btn" href="<?= site_url('laptop/detail/'.$l['id']) ?>"><?= ic('eye',14) ?></a></td>
					</tr>
				<?php endforeach; endif; ?>
				</tbody>
			</table>
		</div>
	</div>

	<div class="card card-pad">
		<h3 class="section-title">Perlu Perhatian</h3>
		<?php if ( ! empty($due_soon)): ?>
		<div class="alert-item">
			<div class="alert-ic" style="background:var(--amber-soft);color:var(--amber);"><?= ic('clock',16) ?></div>
			<div><div class="alert-title"><?= count($due_soon) ?> laptop mendekati batas pengembalian</div>
			<div class="alert-desc"><?= implode(', ', array_slice(array_column($due_soon,'asset_id'),0,3)) ?> — dalam 7 hari.</div></div>
		</div>
		<?php endif; ?>
		<?php if ( ! empty($overdue)): ?>
		<div class="alert-item">
			<div class="alert-ic" style="background:var(--red-soft);color:var(--red);"><?= ic('alert',16) ?></div>
			<div><div class="alert-title"><?= count($overdue) ?> laptop overdue pengembalian</div>
			<div class="alert-desc">Sudah melewati estimasi tanggal kembali.</div></div>
		</div>
		<?php endif; ?>
		<?php if ($bast_waiting > 0): ?>
		<div class="alert-item">
			<div class="alert-ic" style="background:var(--primary-soft);color:var(--primary);"><?= ic('filesig',16) ?></div>
			<div><div class="alert-title"><?= $bast_waiting ?> BAST belum ditandatangani</div>
			<div class="alert-desc">Menunggu tanda tangan penerima atau atasan.</div></div>
		</div>
		<?php endif; ?>
		<?php if ($maint_active > 0): ?>
		<div class="alert-item">
			<div class="alert-ic" style="background:var(--slate-soft);color:var(--slate);"><?= ic('wrench',16) ?></div>
			<div><div class="alert-title"><?= $maint_active ?> laptop dalam proses maintenance</div>
			<div class="alert-desc">Sedang ditangani teknisi internal / vendor.</div></div>
		</div>
		<?php endif; ?>
		<?php if (empty($due_soon) && empty($overdue) && $bast_waiting == 0 && $maint_active == 0): ?>
			<div class="empty-state"><div class="empty-ic"><?= ic('check',22) ?></div><p>Semua aset dalam kondisi baik. Tidak ada yang perlu ditindaklanjuti.</p></div>
		<?php endif; ?>
	</div>
</div>

<script>
new Chart(document.getElementById('chartUsage'), {
	type: 'line',
	data: {
		labels: <?= json_encode($usage_trend['labels']) ?>,
		datasets: [{ label: 'Digunakan', data: <?= json_encode($usage_trend['data']) ?>, borderColor:'#2A5FE0', backgroundColor:'#2A5FE022', fill:true, tension:.4, pointRadius:3, pointBackgroundColor:'#2A5FE0' }]
	},
	options: { plugins:{legend:{display:false}}, scales:{ y:{grid:{color:'#EEF1F6'}}, x:{grid:{display:false}} } }
});
new Chart(document.getElementById('chartStatus'), {
	type: 'doughnut',
	data: {
		labels: ['Digunakan','Tersedia','Maintenance','Rusak','Tidak Aktif'],
		datasets: [{ data: [<?= $status['digunakan'] ?>,<?= $status['tersedia'] ?>,<?= $status['maintenance'] ?>,<?= $status['rusak'] ?>,<?= $status['nonaktif'] ?>],
			backgroundColor:['#2A5FE0','#0E8F5C','#B76B00','#C22A3C','#5B6B82'], borderWidth:0 }]
	},
	options: { cutout:'68%', plugins:{legend:{display:false}} }
});
</script>
