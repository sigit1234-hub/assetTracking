<div class="page-head">
	<div><h1 class="page-title">Daftar BAST Pengembalian</h1><p class="page-sub">Seluruh dokumen Berita Acara Pengembalian laptop. Setiap dokumen tercatat pada Riwayat Penggunaan laptop.</p></div>
	<div class="btn-row">
		<a href="#" class="btn btn-ghost"><?= ic('download',15) ?> Export</a>
		<a href="<?= site_url('penggunaan/pengembalian') ?>" class="btn btn-primary"><?= ic('plus',15) ?> Proses Pengembalian</a>
	</div>
</div>

<div class="stat-grid cols-4">
	<?php
	$s = $summary;
	if ( ! function_exists('bstat')) { function bstat($icon,$label,$num,$color){
		$colors=['green'=>['var(--green-soft)','var(--green)'],'amber'=>['var(--amber-soft)','var(--amber)'],'slate'=>['var(--slate-soft)','var(--slate)'],'red'=>['var(--red-soft)','var(--red)']];
		$c=$colors[$color];
		echo '<div class="stat-card"><div class="stat-top"><div class="stat-icon" style="background:'.$c[0].';color:'.$c[1].';">'.ic($icon,16).'</div></div><div><div class="stat-num">'.$num.'</div><div class="stat-label">'.$label.'</div></div></div>';
	} }
	bstat('filesig','BAST Aktif',$s['aktif'],'green');
	bstat('clock','Menunggu TTD',$s['menunggu'],'amber');
	bstat('check','Selesai',$s['selesai'],'slate');
	bstat('x','Dibatalkan',$s['dibatalkan'],'red');
	?>
</div>

<form method="get" class="filter-bar">
	<div class="search-bar" style="width:260px;background:var(--bg);"><?= ic('search',15) ?><input type="text" name="q" value="<?= htmlspecialchars($filters['q']) ?>" placeholder="Cari nomor BAST / nama penerima"></div>
	<select class="select" name="status" onchange="this.form.submit()">
		<option value="">Semua Status</option>
		<?php foreach (['draft'=>'Draft','menunggu'=>'Menunggu TTD','aktif'=>'Aktif','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan'] as $k=>$v): ?>
			<option value="<?= $k ?>" <?= $filters['status']===$k?'selected':'' ?>><?= $v ?></option>
		<?php endforeach; ?>
	</select>
	<select class="select" name="group_id" onchange="this.form.submit()">
		<option value="">Semua Grup</option>
		<?php foreach ($groups as $d): ?><option value="<?= $d['id'] ?>" <?= $filters['group_id']==$d['id']?'selected':'' ?>><?= $d['name'] ?></option><?php endforeach; ?>
	</select>
	<button type="submit" class="btn btn-ghost"><?= ic('filter',15) ?> Terapkan</button>
</form>

<div class="table-wrap">
	<table>
		<thead><tr><th>Nomor BAST</th><th>Asset ID</th><th>Yang Mengembalikan</th><th>Grup</th><th>Tgl Pengembalian</th><th>Status</th><th>Aksi</th></tr></thead>
		<tbody>
		<?php if (empty($bast_list)): ?>
			<tr><td colspan="7"><div class="empty-state"><div class="empty-ic"><?= ic('filesig',22) ?></div><p>Belum ada BAST Pengembalian.</p></div></td></tr>
		<?php else: foreach ($bast_list as $b): ?>
			<tr>
				<td><span class="asset-tag"><?= $b['bast_number'] ?></span></td>
				<td><?= $b['asset_id'] ?></td>
				<td class="cell-main"><?= $b['employee_name'] ?></td>
				<td><?= $b['group_name'] ?></td>
				<td class="cell-sub"><?= format_tanggal($b['handover_date']) ?></td>
				<td><?= status_badge($b['status']) ?></td>
				<td><div class="row-actions">
					<a class="act-btn" href="<?= site_url('bast/detail/'.$b['id']) ?>"><?= ic('eye',14) ?></a>
					<a class="act-btn" href="<?= site_url('bast/pdf/'.$b['id']) ?>"><?= ic('download',14) ?></a>
				</div></td>
			</tr>
		<?php endforeach; endif; ?>
		</tbody>
	</table>
</div>
