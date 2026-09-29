<div class="page-head">
	<div>
		<h1 class="page-title">Data Laptop</h1>
		<p class="page-sub">Kelola dan monitor seluruh aset laptop perusahaan.</p>
	</div>
	<div class="btn-row">
		<a href="<?= site_url('laptop/import') ?>" class="btn btn-ghost"><?= ic('upload',15) ?> Import Excel</a>
		<a href="#" class="btn btn-ghost"><?= ic('download',15) ?> Export Data</a>
		<a href="<?= site_url('laptop/tambah') ?>" class="btn btn-primary"><?= ic('plus',15) ?> Tambah Laptop</a>
	</div>
</div>

<form method="get" action="<?= site_url('laptop') ?>" class="filter-bar">
	<div class="search-bar" style="width:280px;background:var(--bg);"><?= ic('search',15) ?><input type="text" name="q" value="<?= htmlspecialchars($filters['q']) ?>" placeholder="Cari Asset ID, SN, atau nama pengguna"></div>
	<select class="select" name="status" onchange="this.form.submit()">
		<option value="">Semua Status</option>
		<?php foreach (['tersedia'=>'Tersedia','digunakan'=>'Digunakan','maintenance'=>'Maintenance','dipinjamkan'=>'Dipinjamkan','rusak'=>'Rusak','nonaktif'=>'Tidak Aktif'] as $k=>$v): ?>
			<option value="<?= $k ?>" <?= $filters['status']===$k?'selected':'' ?>><?= $v ?></option>
		<?php endforeach; ?>
	</select>
	<select class="select" name="group_id" onchange="this.form.submit()">
		<option value="">Semua Grup</option>
		<?php foreach ($groups as $d): ?>
			<option value="<?= $d['id'] ?>" <?= $filters['group_id']==$d['id']?'selected':'' ?>><?= $d['name'] ?></option>
		<?php endforeach; ?>
	</select>
	<select class="select" name="brand_id" onchange="this.form.submit()">
		<option value="">Semua Merk</option>
		<?php foreach ($brands as $b): ?>
			<option value="<?= $b['id'] ?>" <?= $filters['brand_id']==$b['id']?'selected':'' ?>><?= $b['name'] ?></option>
		<?php endforeach; ?>
	</select>
	<button type="submit" class="btn btn-ghost"><?= ic('filter',15) ?> Terapkan Filter</button>
</form>

<form method="post" action="<?= site_url('laptop/label-bulk') ?>" target="_blank" id="label-bulk-form">
<div class="table-wrap">
	<div class="table-toolbar">
		<span style="font-size:13px;font-weight:600;"><?= $total ?> Laptop ditemukan</span>
		<div class="btn-row">
			<button type="submit" class="btn btn-soft btn-sm" id="btn-print-selected" disabled><?= ic('printer',13) ?> Cetak Label Terpilih (<span id="selected-count">0</span>)</button>
			<a href="<?= site_url('laptop') ?>" class="btn btn-ghost btn-sm"><?= ic('refresh',13) ?> Reset Filter</a>
		</div>
	</div>
	<table>
		<thead><tr>
			<th style="width:36px;"><input type="checkbox" id="check-all"></th>
			<th>Asset ID</th><th></th><th>Merk / Model</th><th>Serial Number</th><th>Spesifikasi</th><th>Pengguna</th><th>Grup</th><th>Status</th><th>Tgl Pengadaan</th><th>Aksi</th>
		</tr></thead>
		<tbody>
		<?php if (empty($laptops)): ?>
			<tr><td colspan="11"><div class="empty-state"><div class="empty-ic"><?= ic('laptop',22) ?></div><p>Tidak ada data laptop yang cocok dengan filter.</p></div></td></tr>
		<?php else: foreach ($laptops as $l): ?>
			<tr>
				<td><input type="checkbox" name="ids[]" value="<?= $l['id'] ?>" class="row-check"></td>
				<td><span class="asset-tag"><?= $l['asset_id'] ?></span></td>
				<td><div class="thumb"><?= ic('laptop',16) ?></div></td>
				<td class="cell-main"><?= $l['brand_name'] ?> <?= $l['model'] ?></td>
				<td class="cell-sub" style="font-family:var(--font-mono);"><?= $l['serial_number'] ?></td>
				<td class="cell-sub"><?= $l['processor'] ?> · <?= $l['ram'] ?> · <?= $l['storage'] ?></td>
				<td><?= $l['employee_name'] ?: '—' ?></td>
				<td><?= $l['group_name'] ?: '—' ?></td>
				<td><?= status_badge($l['status']) ?></td>
				<td class="cell-sub"><?= $l['purchase_year'] ?></td>
				<td>
					<div class="row-actions">
						<a class="act-btn" title="Lihat" href="<?= site_url('laptop/detail/'.$l['id']) ?>"><?= ic('eye',14) ?></a>
						<a class="act-btn" title="Edit" href="<?= site_url('laptop/edit/'.$l['id']) ?>"><?= ic('edit',14) ?></a>
						<a class="act-btn" title="Cetak Label" href="<?= site_url('laptop/label/'.$l['id']) ?>" target="_blank"><?= ic('qr',14) ?></a>
						<a class="act-btn" title="Buat BAST" href="<?= site_url('bast/buat?laptop_id='.$l['id']) ?>"><?= ic('filesig',14) ?></a>
						<a class="act-btn" title="Hapus" href="<?= site_url('laptop/hapus/'.$l['id']) ?>" data-confirm="Data laptop <?= $l['asset_id'] ?> akan dihapus permanen dari inventaris." data-confirm-title="Hapus Laptop?" data-confirm-ok="Ya, Hapus"><?= ic('x',14) ?></a>
					</div>
				</td>
			</tr>
		<?php endforeach; endif; ?>
		</tbody>
	</table>
	<div class="table-foot">
		<span>Menampilkan <?= $laptops ? (($page-1)*$per_page+1) : 0 ?>–<?= min($page*$per_page, $total) ?> dari <?= $total ?> data</span>
		<div class="pagination">
			<?php
			$qs = $_GET; unset($qs['page']);
			$base = site_url('laptop') . '?' . http_build_query($qs) . '&page=';
			for ($p=1; $p<=$total_pages; $p++):
			?>
				<a href="<?= $base . $p ?>" class="page-btn <?= $p==$page?'active':'' ?>"><?= $p ?></a>
			<?php endfor; ?>
		</div>
	</div>
</div>
</form>

<script>
(function () {
	var checkAll = document.getElementById('check-all');
	var rowChecks = document.querySelectorAll('.row-check');
	var printBtn = document.getElementById('btn-print-selected');
	var countEl = document.getElementById('selected-count');

	function updateState() {
		var checked = document.querySelectorAll('.row-check:checked').length;
		countEl.textContent = checked;
		printBtn.disabled = checked === 0;
	}
	if (checkAll) {
		checkAll.addEventListener('change', function () {
			rowChecks.forEach(function (c) { c.checked = checkAll.checked; });
			updateState();
		});
	}
	rowChecks.forEach(function (c) { c.addEventListener('change', updateState); });
	updateState();
})();
</script>
