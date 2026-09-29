<div class="page-head">
	<div><h1 class="page-title">Laptop Dalam Perbaikan</h1><p class="page-sub">Pantau laptop yang sedang dalam proses maintenance.</p></div>
	<div class="btn-row"><a href="<?= site_url('maintenance/tambah') ?>" class="btn btn-primary"><?= ic('plus',15) ?> Catat Maintenance</a></div>
</div>

<div class="stat-grid cols-4">
	<?php
	function mstat($icon,$label,$num,$unit,$color){
		$colors=['amber'=>['var(--amber-soft)','var(--amber)'],'blue'=>['var(--primary-soft)','var(--primary)'],'green'=>['var(--green-soft)','var(--green)'],'red'=>['var(--red-soft)','var(--red)']];
		$c=$colors[$color];
		echo '<div class="stat-card"><div class="stat-top"><div class="stat-icon" style="background:'.$c[0].';color:'.$c[1].';">'.ic($icon,16).'</div></div><div><div class="stat-num">'.$num.' <span style="font-size:12px;color:var(--ink-soft);font-weight:600;">'.$unit.'</span></div><div class="stat-label">'.$label.'</div></div></div>';
	}
	mstat('wrench','Dalam Proses',$count_active,'Unit','amber');
	mstat('clock','Rata-rata Durasi',$avg_duration,'Hari','blue');
	mstat('check','Selesai Bulan Ini',$count_done,'Unit','green');
	mstat('alert','Menunggu Sparepart',$count_waiting,'Unit','red');
	?>
</div>

<div class="table-wrap">
	<table>
		<thead><tr><th>Asset ID</th><th>Laptop</th><th>Keluhan</th><th>Teknisi</th><th>Tgl Masuk</th><th>Estimasi Selesai</th><th>Status</th><th>Aksi</th></tr></thead>
		<tbody>
		<?php if (empty($items)): ?>
			<tr><td colspan="8"><div class="empty-state"><div class="empty-ic"><?= ic('wrench',22) ?></div><p>Tidak ada laptop yang sedang dalam perbaikan.</p></div></td></tr>
		<?php else: foreach ($items as $m): ?>
			<tr>
				<td><span class="asset-tag"><?= $m['asset_id'] ?></span></td>
				<td class="cell-main"><?= $m['brand_name'] ?> <?= $m['model'] ?></td>
				<td><?= $m['issue'] ?></td>
				<td class="cell-sub"><?= $m['technician'] ?></td>
				<td class="cell-sub"><?= format_tanggal($m['date_in']) ?></td>
				<td class="cell-sub"><?= $m['estimated_date_out'] ? format_tanggal($m['estimated_date_out']) : '—' ?></td>
				<td><?= status_badge($m['status']) ?></td>
				<td><div class="row-actions">
					<a class="act-btn" href="<?= site_url('laptop/detail/'.$m['laptop_id']) ?>"><?= ic('eye',14) ?></a>
					<a class="act-btn" href="<?= site_url('maintenance/selesai/'.$m['id']) ?>" data-confirm="Laptop <?= $m['asset_id'] ?> akan ditandai selesai diperbaiki dan statusnya kembali menjadi Tersedia." data-confirm-title="Tandai Selesai?" data-confirm-ok="Ya, Selesai"><?= ic('check',14) ?></a>
				</div></td>
			</tr>
		<?php endforeach; endif; ?>
		</tbody>
	</table>
</div>
