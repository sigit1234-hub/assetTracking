<?php
// Filter bersama. Variabel: $filters, $groups, $brands, $show_status (bool), $show_kondisi (bool)
$f = $filters;
$has_filter = count(array_filter($f, function($v){ return $v !== '' && $v !== NULL; })) > 0;
?>
<form method="get" class="filter-bar" style="flex-wrap:wrap;gap:10px;">
	<div class="search-bar" style="width:340px;background:var(--bg);"><?= ic('search',15) ?><input type="text" name="q" value="<?= htmlspecialchars($f['q']) ?>" placeholder="Cari SN, Asset ID, nama laptop, nama karyawan, PN, no. BAST"></div>
	<select class="select" name="group_id">
		<option value="">Semua Grup</option>
		<?php foreach ($groups as $d): ?><option value="<?= $d['id'] ?>" <?= $f['group_id']==$d['id']?'selected':'' ?>><?= htmlspecialchars($d['name']) ?></option><?php endforeach; ?>
	</select>
	<select class="select" name="brand_id">
		<option value="">Semua Merek</option>
		<?php foreach ($brands as $b): ?><option value="<?= $b['id'] ?>" <?= $f['brand_id']==$b['id']?'selected':'' ?>><?= htmlspecialchars($b['name']) ?></option><?php endforeach; ?>
	</select>
	<select class="select" name="jenis">
		<option value="">Semua Jenis</option>
		<option value="tetap" <?= $f['jenis']==='tetap'?'selected':'' ?>>Aset Tetap</option>
		<option value="sementara" <?= $f['jenis']==='sementara'?'selected':'' ?>>Sementara (Dipinjam)</option>
	</select>
	<?php if ( ! empty($show_kondisi)): ?>
	<select class="select" name="kondisi">
		<option value="">Semua Kondisi</option>
		<option value="segera" <?= $f['kondisi']==='segera'?'selected':'' ?>>Akan Dikembalikan (7 hari)</option>
		<option value="overdue" <?= $f['kondisi']==='overdue'?'selected':'' ?>>Overdue</option>
	</select>
	<?php endif; ?>
	<?php if ( ! empty($show_status)): ?>
	<select class="select" name="status">
		<option value="">Semua Status</option>
		<option value="aktif" <?= $f['status']==='aktif'?'selected':'' ?>>Masih Digunakan</option>
		<option value="selesai" <?= $f['status']==='selesai'?'selected':'' ?>>Sudah Dikembalikan</option>
	</select>
	<?php endif; ?>
	<label class="cell-sub" style="display:flex;align-items:center;gap:6px;">Serah terima
		<input type="date" class="select" name="date_from" value="<?= htmlspecialchars($f['date_from']) ?>">
		s/d
		<input type="date" class="select" name="date_to" value="<?= htmlspecialchars($f['date_to']) ?>">
	</label>
	<button type="submit" class="btn btn-primary"><?= ic('filter',15) ?> Terapkan</button>
	<?php if ($has_filter): ?><a href="<?= current_url() ?>" class="btn btn-ghost">Reset</a><?php endif; ?>
</form>
