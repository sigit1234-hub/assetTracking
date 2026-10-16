<aside id="sidebar">
	<div class="brand">
		<div class="brand-mark"><?= ic('laptop', 18) ?></div>
		<div>
			<div class="brand-name" style="color:#fff;">AssetTrack</div>
			<div class="brand-sub">IT ASSET SYSTEM</div>
		</div>
	</div>
	<nav class="nav-wrap">
		<?php
		$current = $this->uri->segment(1) ?: 'dashboard';
		$nav = [
			['key'=>'dashboard','label'=>'Dashboard','icon'=>'dashboard','url'=>'dashboard'],
			['key'=>'laptop','label'=>'Data Laptop','icon'=>'laptop','children'=>[
				['url'=>'laptop','label'=>'Semua Laptop'],
				['url'=>'laptop/tambah','label'=>'Tambah Laptop'],
				['url'=>'laptop/import','label'=>'Import Data'],
				['url'=>'laptop/kategori','label'=>'Kategori Laptop'],
				['url'=>'laptop/merk','label'=>'Merk dan Model'],
			]],
			['key'=>'pekerja','label'=>'Data Pekerja','icon'=>'user','children'=>[
				['url'=>'pekerja','label'=>'Semua Pekerja'],
				['url'=>'pekerja/tambah','label'=>'Tambah Pekerja'],
				['url'=>'pekerja/import','label'=>'Import Data'],
			]],
			['key'=>'penggunaan','label'=>'Penggunaan Laptop','icon'=>'users','children'=>[
				['url'=>'penggunaan','label'=>'Laptop Sedang Digunakan'],
				['url'=>'penggunaan/riwayat','label'=>'Riwayat Penggunaan'],
				['url'=>'penggunaan/pengembalian','label'=>'Pengembalian Laptop'],
			]],
			['key'=>'bast','label'=>'BAST','icon'=>'filesig','children'=>[
				['url'=>'bast','label'=>'Daftar BAST'],
				['url'=>'bast/pengembalian','label'=>'BAST Pengembalian'],
				['url'=>'bast/buat','label'=>'Buat BAST Baru'],
				['url'=>'bast/buat?mode=sementara','label'=>'Buat BAST Sementara'],
				['url'=>'penggunaan/pengembalian','label'=>'Proses Pengembalian'],
				['url'=>'bast/template','label'=>'Template BAST'],
			]],
			['key'=>'maintenance','label'=>'Maintenance','icon'=>'wrench','children'=>[
				['url'=>'maintenance','label'=>'Laptop Dalam Perbaikan'],
				['url'=>'maintenance/riwayat','label'=>'Riwayat Maintenance'],
			]],
			['key'=>'laporan','label'=>'Laporan','icon'=>'chart','url'=>'laporan'],
			['key'=>'pengaturan','label'=>'Pengaturan','icon'=>'settings','url'=>'pengaturan'],
		];
		foreach ($nav as $item):
			$isActive = $current === $item['key'];
		?>
			<div class="nav-group">
			<?php if (isset($item['children'])): ?>
				<div class="nav-item <?= $isActive ? 'active parent-open' : '' ?>" data-toggle-submenu="<?= $item['key'] ?>">
					<?= ic($item['icon']) ?><span><?= $item['label'] ?></span><?= ic('chev', 14) ?>
				</div>
				<div class="submenu <?= $isActive ? 'open' : '' ?>" id="submenu-<?= $item['key'] ?>">
					<?php foreach ($item['children'] as $child):
						$childActive = current_url_is($child['url']);
					?>
						<a href="<?= site_url($child['url']) ?>" class="<?= $childActive ? 'active' : '' ?>"><?= $child['label'] ?></a>
					<?php endforeach; ?>
				</div>
			<?php else: ?>
				<a href="<?= site_url($item['url']) ?>" class="nav-item <?= $isActive ? 'active' : '' ?>">
					<?= ic($item['icon']) ?><span><?= $item['label'] ?></span>
				</a>
			<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</nav>
	<div class="sidebar-footer">v1.0.0 · <?= $company['division'] ?><br><?= $company['name'] ?></div>
</aside>
