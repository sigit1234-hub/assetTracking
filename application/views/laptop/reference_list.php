<div class="crumb"><a href="<?= site_url('laptop') ?>">Data Laptop</a> / <b><?= $page_title ?></b></div>
<div class="page-head">
	<div><h1 class="page-title"><?= $page_title ?></h1><p class="page-sub">Kelola daftar <?= strtolower($type) ?> laptop yang tersedia di sistem.</p></div>
</div>

<div class="grid-2">
	<div class="card card-pad" style="grid-column:1;">
		<div class="table-wrap" style="border:none;">
		<table><thead><tr><th>Nama</th><th>Jumlah Unit</th></tr></thead>
		<tbody>
		<?php if (empty($items)): ?>
			<tr><td colspan="2" class="muted" style="text-align:center;padding:20px;">Belum ada data.</td></tr>
		<?php else: foreach ($items as $i): ?>
			<tr><td class="cell-main"><?= $i['name'] ?></td><td><?= $i['total_unit'] ?> Unit</td></tr>
		<?php endforeach; endif; ?>
		</tbody></table>
		</div>
	</div>
	<div class="card card-pad" style="align-self:flex-start;">
		<h3 class="section-title">Tambah <?= $type === 'merk' ? 'Merk' : 'Kategori' ?> Baru</h3>
		<form method="post">
			<div class="field mb-14"><label>Nama</label><input class="input" name="name" required placeholder="Contoh: <?= $type === 'merk' ? 'Microsoft' : 'Gaming Laptop' ?>"></div>
			<?php if ($type !== 'merk'): ?>
			<div class="field mb-14"><label>Deskripsi</label><textarea class="input" name="description" rows="2"></textarea></div>
			<?php endif; ?>
			<button type="submit" class="btn btn-primary"><?= ic('plus',15) ?> Tambah</button>
		</form>
	</div>
</div>
