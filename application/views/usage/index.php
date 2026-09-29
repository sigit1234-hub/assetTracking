<div class="page-head">
	<div><h1 class="page-title">Penggunaan Laptop</h1><p class="page-sub">Monitoring laptop yang sedang digunakan, dipinjamkan, atau perlu ditindaklanjuti.</p></div>
</div>

<div class="stat-grid cols-4">
	<?php
	function ustat($icon,$label,$num,$color){
		$colors=['blue'=>['var(--primary-soft)','var(--primary)'],'purple'=>['var(--purple-soft)','var(--purple)'],'amber'=>['var(--amber-soft)','var(--amber)'],'red'=>['var(--red-soft)','var(--red)']];
		$c=$colors[$color];
		echo '<div class="stat-card"><div class="stat-top"><div class="stat-icon" style="background:'.$c[0].';color:'.$c[1].';">'.ic($icon,16).'</div></div><div><div class="stat-num">'.$num.' <span style="font-size:12px;color:var(--ink-soft);font-weight:600;">Unit</span></div><div class="stat-label">'.$label.'</div></div></div>';
	}
	ustat('users','Laptop Digunakan',$count_active,'blue');
	ustat('swap','Laptop Dipinjam',$count_loan,'purple');
	ustat('clock','Akan Dikembalikan',$count_due_soon,'amber');
	ustat('alert','Overdue',$count_overdue,'red');
	?>
</div>

<form method="get" class="filter-bar">
	<div class="search-bar" style="width:280px;background:var(--bg);"><?= ic('search',15) ?><input type="text" name="q" value="<?= htmlspecialchars($filters['q']) ?>" placeholder="Cari nama pengguna / Asset ID"></div>
	<select class="select" name="group_id" onchange="this.form.submit()">
		<option value="">Semua Grup</option>
		<?php foreach ($groups as $d): ?><option value="<?= $d['id'] ?>" <?= $filters['group_id']==$d['id']?'selected':'' ?>><?= $d['name'] ?></option><?php endforeach; ?>
	</select>
	<button type="submit" class="btn btn-ghost"><?= ic('filter',15) ?> Terapkan</button>
</form>

<div class="table-wrap">
	<table>
		<thead><tr><th>Asset ID</th><th>Pengguna</th><th>Grup</th><th>Laptop</th><th>Tgl Serah Terima</th><th>Estimasi Kembali</th><th>Status</th><th>BAST</th><th>Aksi</th></tr></thead>
		<tbody>
		<?php if (empty($usages)): ?>
			<tr><td colspan="9"><div class="empty-state"><div class="empty-ic"><?= ic('users',22) ?></div><p>Tidak ada laptop yang sedang digunakan.</p></div></td></tr>
		<?php else: foreach ($usages as $u):
			$overdue = $u['expected_return_date'] && strtotime($u['expected_return_date']) < strtotime(date('Y-m-d'));
		?>
			<tr>
				<td><span class="asset-tag"><?= $u['asset_id'] ?></span></td>
				<td class="cell-main"><?= $u['employee_name'] ?></td>
				<td><?= $u['group_name'] ?></td>
				<td><?= $u['model'] ?></td>
				<td class="cell-sub"><?= format_tanggal($u['start_date']) ?></td>
				<td class="cell-sub"><?= $u['expected_return_date'] ? format_tanggal($u['expected_return_date']) : 'Aset Tetap' ?></td>
				<td><?= status_badge($overdue ? 'overdue' : $u['laptop_status']) ?></td>
				<td><?php if ($u['bast_number']): ?><a href="<?= site_url('bast/detail/'.$u['bast_id']) ?>"><span class="asset-tag" style="border-style:solid;"><?= $u['bast_number'] ?></span> <?= status_badge($u['bast_status']) ?></a><?php else: ?>—<?php endif; ?></td>
				<td><div class="row-actions">
					<a class="act-btn" href="<?= site_url('laptop/detail/'.$u['laptop_id']) ?>"><?= ic('eye',14) ?></a>
					<a class="act-btn" href="<?= site_url('penggunaan/pengembalian?laptop_id='.$u['laptop_id']) ?>"><?= ic('box',14) ?></a>
				</div></td>
			</tr>
		<?php endforeach; endif; ?>
		</tbody>
	</table>
</div>
