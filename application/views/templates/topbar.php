<div id="main">
	<header id="topbar">
		<button class="icon-btn menu-toggle" id="menu-toggle">
			<?= ic('menu', 18) ?>
		</button>
		<div class="greeting">
			<?php
				$hour = (int) date('H');
				$greet = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 19 ? 'Selamat sore' : 'Selamat malam'));
				$firstName = explode(' ', $current_user['name'])[0];
			?>
			<div class="hi"><?= $greet ?>, <?= $firstName ?> 👋</div>
			<div class="div"><?= $current_user['division'] ?></div>
		</div>
		<form class="search-bar" method="get" action="<?= site_url('laptop') ?>">
			<?= ic('search', 15) ?>
			<input type="text" name="q" placeholder="Cari Asset ID, Serial Number, atau nama pengguna...">
		</form>
		<a href="<?= site_url('notifikasi') ?>" class="icon-btn">
			<?= ic('bell', 17) ?>
			<?php if (!empty($unread_notifications)): ?><span class="dot-badge"></span><?php endif; ?>
		</a>
		<div class="profile-chip" id="profile-chip">
			<div class="avatar"><?= initials($current_user['name']) ?></div>
			<div>
				<div class="pname"><?= $current_user['name'] ?></div>
				<div class="prole"><?= $current_user['role'] === 'super_admin' ? 'Super Admin IT' : 'Admin IT Asset' ?></div>
			</div>
			<?= ic('chev', 14) ?>
			<div class="profile-menu" id="profile-menu">
				<a href="<?= site_url('pengaturan') ?>"><?= ic('settings', 15) ?> Pengaturan</a>
				<a href="<?= site_url('logout') ?>"><?= ic('logout', 15) ?> Keluar</a>
			</div>
		</div>
	</header>
