<div class="crumb"><a href="<?= site_url('laptop') ?>">Data Laptop</a> / <b><?= $laptop['asset_id'] ?></b></div>

<div class="card card-pad mb-20">
	<div class="flex" style="gap:22px;flex-wrap:wrap;">
		<div class="thumb" style="width:120px;height:96px;border-radius:12px;"><?= ic('laptop',40) ?></div>
		<div style="flex:1;min-width:220px;">
			<div class="flex items-center gap-10 mb-6"><span class="asset-tag"><?= $laptop['asset_id'] ?></span><?= status_badge($laptop['status']) ?></div>
			<h2 style="margin:0 0 4px;font-size:19px;"><?= $laptop['brand_name'] ?> <?= $laptop['model'] ?></h2>
			<p class="muted" style="margin:0;font-size:13px;">SN: <?= $laptop['serial_number'] ?> · Pengadaan <?= $laptop['purchase_year'] ?></p>
		</div>
		<div class="btn-row" style="align-items:flex-start;">
			<a href="<?= site_url('laptop/edit/'.$laptop['id']) ?>" class="btn btn-ghost"><?= ic('edit',15) ?> Edit Data</a>
			<a href="<?= site_url('bast/buat?laptop_id='.$laptop['id']) ?>" class="btn btn-soft"><?= ic('filesig',15) ?> Buat BAST</a>
			<a href="<?= site_url('maintenance/tambah') ?>" class="btn btn-ghost"><?= ic('wrench',15) ?> Maintenance</a>
			<a href="<?= site_url('laptop/label/'.$laptop['id']) ?>" target="_blank" class="btn btn-ghost"><?= ic('qr',15) ?> Cetak Label</a>
		</div>
	</div>
</div>

<div class="tabs" data-tab-group="detail">
	<div class="tab active" data-tab="info">Informasi Laptop</div>
	<div class="tab" data-tab="current">Pengguna Saat Ini</div>
	<div class="tab" data-tab="history">Riwayat Penggunaan</div>
	<div class="tab" data-tab="maint">Riwayat Maintenance</div>
	<div class="tab" data-tab="doc">Dokumen BAST</div>
</div>

<div data-tab-panel-group="detail" data-tab-panel="info" class="tab-panel active">
	<div class="card card-pad"><div class="form-grid">
		<?php
		function irow($l,$v){ echo '<div><div style="font-size:11.5px;color:var(--ink-soft);margin-bottom:3px;">'.$l.'</div><div style="font-size:13.5px;font-weight:600;">'.($v ?: '-').'</div></div>'; }
		irow('Asset ID',$laptop['asset_id']); irow('Serial Number',$laptop['serial_number']);
		irow('Merk',$laptop['brand_name']); irow('Model',$laptop['model']);
		irow('Processor',$laptop['processor']); irow('RAM',$laptop['ram']);
		irow('Storage',$laptop['storage']); irow('Sistem Operasi',$laptop['os']);
		irow('Tahun Pengadaan',$laptop['purchase_year']); irow('Lokasi',$laptop['location']);
		irow('Catatan Kondisi',$laptop['condition_notes']);
		?>
	</div></div>
</div>

<div data-tab-panel-group="detail" data-tab-panel="current" class="tab-panel">
	<div class="card card-pad">
	<?php if ($laptop['employee_name']): ?>
		<div class="flex gap-14" style="align-items:center;margin-bottom:18px;">
			<div class="avatar" style="width:52px;height:52px;font-size:16px;"><?= initials($laptop['employee_name']) ?></div>
			<div><h3 style="margin:0;font-size:16px;"><?= $laptop['employee_name'] ?></h3><p class="muted" style="margin:2px 0 0;font-size:13px;"><?= $laptop['group_name'] ?></p></div>
		</div>
		<div class="form-grid">
			<?php irow('Grup',$laptop['group_name']); irow('Status Laptop', status_label($laptop['status'])); ?>
		</div>
	<?php else: ?>
		<div class="empty-state"><div class="empty-ic"><?= ic('user',22) ?></div><p>Laptop ini belum digunakan oleh siapa pun saat ini.</p></div>
	<?php endif; ?>
	</div>
</div>

<div data-tab-panel-group="detail" data-tab-panel="history" class="tab-panel">
	<div class="card card-pad">
		<?php if (empty($usage_history)): ?>
			<div class="empty-state"><div class="empty-ic"><?= ic('clock',22) ?></div><p>Belum ada riwayat penggunaan.</p></div>
		<?php else: ?>
		<div class="timeline">
			<?php foreach ($usage_history as $u): ?>
			<div class="t-item">
				<div class="t-dot"><?= ic('swap',10) ?></div>
				<div class="t-date"><?= format_tanggal($u['start_date']) ?></div>
				<div class="t-title"><?= $u['employee_name'] ?: '—' ?> menggunakan laptop ini</div>
				<div class="t-desc">
					<?php if ($u['bast_number']): ?>BAST Serah Terima: <a href="<?= site_url('bast/detail/'.$u['bast_id']) ?>"><b><?= $u['bast_number'] ?></b></a> · <?php endif; ?>
					<?php if ($u['return_bast_number']): ?>BAST Pengembalian: <a href="<?= site_url('bast/detail/'.$u['return_bast_id']) ?>"><b><?= $u['return_bast_number'] ?></b></a> · <?php endif; ?>
					<?= $u['end_date'] ? 'Dikembalikan '.format_tanggal($u['end_date']) : (($u['is_active']) ? 'Masih berlangsung' : '') ?>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
	</div>
</div>

<div data-tab-panel-group="detail" data-tab-panel="maint" class="tab-panel">
	<div class="table-wrap">
	<table><thead><tr><th>Tanggal Masuk</th><th>Keluhan</th><th>Teknisi</th><th>Status</th><th>Tgl Selesai</th></tr></thead>
	<tbody>
	<?php if (empty($maintenance_history)): ?>
		<tr><td colspan="5" class="muted" style="text-align:center;padding:20px;">Belum ada riwayat maintenance.</td></tr>
	<?php else: foreach ($maintenance_history as $m): ?>
		<tr><td><?= format_tanggal($m['date_in']) ?></td><td><?= $m['issue'] ?></td><td><?= $m['technician'] ?></td><td><?= status_badge($m['status']) ?></td><td><?= format_tanggal($m['date_out']) ?></td></tr>
	<?php endforeach; endif; ?>
	</tbody></table>
	</div>
</div>

<div data-tab-panel-group="detail" data-tab-panel="doc" class="tab-panel">
	<div class="table-wrap">
	<table><thead><tr><th>Nomor BAST</th><th>Penerima</th><th>Tanggal</th><th>Status</th><th></th></tr></thead>
	<tbody>
	<?php if (empty($bast_docs)): ?>
		<tr><td colspan="5" class="muted" style="text-align:center;padding:20px;">Belum ada dokumen BAST untuk laptop ini.</td></tr>
	<?php else: foreach ($bast_docs as $b): ?>
		<tr><td class="asset-tag"><?= $b['bast_number'] ?></td><td><?= $b['employee_name'] ?></td><td><?= format_tanggal($b['handover_date']) ?></td><td><?= status_badge($b['status']) ?></td>
		<td><a class="act-btn" href="<?= site_url('bast/detail/'.$b['id']) ?>"><?= ic('eye',14) ?></a></td></tr>
	<?php endforeach; endif; ?>
	</tbody></table>
	</div>
</div>
