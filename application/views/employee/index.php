<div class="page-head">
	<div><h1 class="page-title">Data Pekerja</h1><p class="page-sub">Kelola daftar karyawan penerima laptop beserta grup masing-masing.</p></div>
	<div class="btn-row">
		<a href="<?= site_url('pekerja/import') ?>" class="btn btn-ghost"><?= ic('upload',15) ?> Import Excel</a>
		<a href="<?= site_url('pekerja/tambah') ?>" class="btn btn-primary"><?= ic('plus',15) ?> Tambah Pekerja</a>
	</div>
</div>

<form method="get" action="<?= site_url('pekerja') ?>" class="filter-bar">
	<div class="search-bar" style="width:280px;background:var(--bg);"><?= ic('search',15) ?><input type="text" name="q" value="<?= htmlspecialchars($filters['q']) ?>" placeholder="Cari nama, PN, atau email"></div>
	<select class="select" name="group_id" onchange="this.form.submit()">
		<option value="">Semua Grup</option>
		<?php foreach ($groups as $g): ?>
			<option value="<?= $g['id'] ?>" <?= $filters['group_id']==$g['id']?'selected':'' ?>><?= $g['name'] ?></option>
		<?php endforeach; ?>
	</select>
	<button type="submit" class="btn btn-ghost"><?= ic('filter',15) ?> Terapkan Filter</button>
</form>

<div class="table-wrap">
	<div class="table-toolbar">
		<span style="font-size:13px;font-weight:600;"><?= $total ?> Pekerja ditemukan</span>
		<a href="<?= site_url('pekerja') ?>" class="btn btn-ghost btn-sm"><?= ic('refresh',13) ?> Reset Filter</a>
	</div>
	<table>
		<thead><tr><th>PN</th><th>Nama</th><th>Jabatan</th><th>Grup</th><th>Email</th><th>No. HP</th><th>Status</th><th>Aksi</th></tr></thead>
		<tbody>
		<?php if (empty($employees)): ?>
			<tr><td colspan="8"><div class="empty-state"><div class="empty-ic"><?= ic('users',22) ?></div><p>Tidak ada data pekerja yang cocok dengan filter.</p></div></td></tr>
		<?php else: foreach ($employees as $e): ?>
			<tr>
				<td class="asset-tag"><?= $e['nik'] ?></td>
				<td class="cell-main"><?= $e['name'] ?></td>
				<td><?= $e['position'] ?: '—' ?></td>
				<td><?= $e['group_name'] ?: '—' ?></td>
				<td class="cell-sub"><?= $e['email'] ?: '—' ?></td>
				<td class="cell-sub"><?= $e['phone'] ?: '—' ?></td>
				<td><?= $e['is_active'] ? '<span class="badge b-green"><span class="bdot"></span>Aktif</span>' : '<span class="badge b-slate"><span class="bdot"></span>Nonaktif</span>' ?></td>
				<td>
					<div class="row-actions">
						<a class="act-btn" title="Edit" href="<?= site_url('pekerja/edit/'.$e['id']) ?>"><?= ic('edit',14) ?></a>
						<a class="act-btn" title="Hapus" href="<?= site_url('pekerja/hapus/'.$e['id']) ?>" data-confirm="Data pekerja <?= $e['name'] ?> akan dihapus permanen." data-confirm-title="Hapus Pekerja?" data-confirm-ok="Ya, Hapus"><?= ic('x',14) ?></a>
					</div>
				</td>
			</tr>
		<?php endforeach; endif; ?>
		</tbody>
	</table>
	<div class="table-foot">
		<span>Menampilkan <?= $employees ? (($page-1)*$per_page+1) : 0 ?>–<?= min($page*$per_page, $total) ?> dari <?= $total ?> data</span>
		<div class="pagination">
			<?php
			$qs = $_GET; unset($qs['page']);
			$base = site_url('pekerja') . '?' . http_build_query($qs) . '&page=';
			for ($p=1; $p<=$total_pages; $p++):
			?>
				<a href="<?= $base . $p ?>" class="page-btn <?= $p==$page?'active':'' ?>"><?= $p ?></a>
			<?php endfor; ?>
		</div>
	</div>
</div>
