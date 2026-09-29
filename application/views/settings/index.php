<div class="page-head"><div><h1 class="page-title">Pengaturan</h1><p class="page-sub">Kelola profil admin, preferensi sistem, dan konfigurasi BAST.</p></div></div>
<div class="grid-2">
	<div class="card card-pad">
		<h3 class="section-title">Profil Admin</h3>
		<div class="flex items-center gap-14 mb-20">
			<div class="avatar" style="width:56px;height:56px;font-size:18px;"><?= initials($user['name']) ?></div>
			<div><button type="button" class="btn btn-soft btn-sm">Ganti Foto</button></div>
		</div>
		<form method="post">
			<div class="form-grid">
				<div class="field"><label>Nama Lengkap</label><input class="input" name="name" value="<?= $user['name'] ?>"></div>
				<div class="field"><label>Email</label><input class="input" value="<?= $user['email'] ?>" disabled></div>
				<div class="field"><label>Grup</label><input class="input" value="<?= $user['division'] ?>" disabled></div>
				<div class="field"><label>Nomor HP</label><input class="input" name="phone" value="<?= $user['phone'] ?>"></div>
			</div>
			<button type="submit" class="btn btn-primary" style="margin-top:18px;">Simpan Perubahan</button>
		</form>
	</div>
	<div class="card card-pad">
		<h3 class="section-title">Preferensi Sistem</h3>
		<?php
		function prefRow($title,$desc,$on){
			echo '<div class="flex justify-between items-center" style="padding:12px 0;border-bottom:1px solid var(--border-soft);">
				<div><div style="font-size:13.5px;font-weight:600;">'.$title.'</div><div class="cell-sub">'.$desc.'</div></div>
				<div style="width:40px;height:22px;border-radius:20px;background:'.($on?'var(--primary)':'var(--border)').';position:relative;flex-shrink:0;">
				<div style="width:16px;height:16px;border-radius:50%;background:#fff;position:absolute;top:3px;left:'.($on?'21px':'3px').';"></div></div></div>';
		}
		prefRow('Notifikasi Email','Kirim ringkasan aktivitas harian via email', true);
		prefRow('Notifikasi Overdue','Peringatan otomatis untuk pengembalian terlambat', true);
		prefRow('Approval Atasan Wajib','BAST memerlukan tanda tangan atasan sebelum aktif', true);
		prefRow('Mode Gelap','Gunakan tampilan gelap pada dashboard', false);
		?>
		<hr class="hr">
		<h3 class="section-title">Format Penomoran BAST</h3>
		<div class="field"><label>Pola Nomor</label><input class="input" value="BAST/IT/{tahun}/{urutan}" disabled></div>
	</div>
</div>
