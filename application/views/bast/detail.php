<div class="crumb"><a href="<?= site_url('bast') ?>">Daftar BAST</a> / <b><?= $bast['bast_number'] ?></b></div>

<div class="card card-pad mb-20">
	<div class="flex justify-between items-center" style="flex-wrap:wrap;gap:14px;">
		<div>
			<div class="flex items-center gap-10 mb-6"><span class="asset-tag" style="font-size:13px;"><?= $bast['bast_number'] ?></span><?= status_badge($bast['status']) ?></div>
			<h2 style="margin:0;font-size:18px;">Serah Terima — <?= $bast['asset_id'] ?> (<?= $bast['brand_name'] ?> <?= $bast['model'] ?>)</h2>
		</div>
		<div class="btn-row">
			<a href="<?= site_url('bast/pdf/'.$bast['id']) ?>" class="btn btn-ghost"><?= ic('download',15) ?> Download PDF</a>
			<a href="<?= site_url('bast/pdf/'.$bast['id']).'?mode=view' ?>" target="_blank" class="btn btn-ghost"><?= ic('printer',15) ?> Print</a>
			<a href="<?= site_url('bast/kirim-email/'.$bast['id']) ?>" class="btn btn-soft" data-confirm="Email notifikasi BAST akan dikirim ke <?= $bast['employee_email'] ?: 'karyawan ini (belum ada email terdaftar)' ?>." data-confirm-title="Kirim Email BAST?" data-confirm-ok="Ya, Kirim"><?= ic('mail',15) ?> Kirim Email</a>
			<?php if ($bast['status'] !== 'dibatalkan' && $bast['status'] !== 'selesai'): ?>
			<a href="<?= site_url('bast/batalkan/'.$bast['id']) ?>" class="btn btn-danger-ghost" data-confirm="Dokumen akan ditandai dibatalkan dan tidak berlaku secara hukum. Tindakan ini tidak dapat dibatalkan." data-confirm-title="Batalkan BAST ini?" data-confirm-ok="Ya, Batalkan"><?= ic('x',15) ?> Batalkan</a>
			<?php endif; ?>
		</div>
	</div>
	<hr class="hr">
	<div class="form-grid">
		<?php
		function birow($l,$v){ echo '<div><div style="font-size:11.5px;color:var(--ink-soft);margin-bottom:3px;">'.$l.'</div><div style="font-size:13.5px;font-weight:600;">'.($v ?: '-').'</div></div>'; }
		birow('Laptop', $bast['brand_name'].' '.$bast['model']);
		birow('Asset ID', $bast['asset_id']);
		birow('Penerima', $bast['employee_name']);
		birow('Grup', $bast['group_name']);
		birow('Tanggal Serah Terima', format_tanggal($bast['handover_date']));
		birow('Estimasi Pengembalian', $bast['expected_return_date'] ? format_tanggal($bast['expected_return_date']) : 'Aset Tetap');
		?>
	</div>
	<hr class="hr">
	<h3 class="section-title">Progress Dokumen</h3>
	<div class="stepper">
		<?php
		$stages = ['Draft', 'Dikirim', 'Ditandatangani', 'Aktif', 'Selesai'];
		$statusOrder = ['draft'=>1,'menunggu'=>2,'aktif'=>4,'selesai'=>5,'dibatalkan'=>1];
		$currentStage = $statusOrder[$bast['status']] ?? 1;
		foreach ($stages as $i => $s):
			$n = $i+1;
			$cls = $n < $currentStage ? 'done' : ($n == $currentStage ? 'current' : '');
			echo '<div class="step '.$cls.'"><div class="step-circle">'.($n < $currentStage ? ic('check',14) : '').'</div><div class="step-label">'.$s.'</div></div>';
			if ($n < 5) echo '<div class="step-line '.($n < $currentStage ? 'done' : '').'"></div>';
		endforeach;
		?>
	</div>
</div>

<div class="grid-2">
	<?php
	$checklistLabels = [
		'unit_laptop'=>'Unit Laptop','charger'=>'Charger','tas'=>'Tas Laptop','mouse'=>'Mouse','adapter'=>'Adapter','aksesoris_lain'=>'Aksesoris Lain',
		'kondisi_fisik'=>'Kondisi Fisik','layar'=>'Layar','keyboard'=>'Keyboard','baterai'=>'Baterai','port_usb'=>'Port USB','sistem_operasi'=>'Sistem Operasi',
	];
	$isReturn = $bast['handover_type'] === 'pengembalian';
	$complete_items = [];
	foreach ($checklist as $k=>$v) if ($v === 'lengkap' && isset($checklistLabels[$k])) $complete_items[] = $checklistLabels[$k];
	$party1_label = $isReturn ? 'Pihak Pertama (Menerima Kembali)' : 'Pihak Pertama (Menyerahkan)';
	$party2_label = $isReturn ? 'Pihak Kedua (Mengembalikan)' : 'Pihak Kedua (Menerima)';
	?>
	<div class="doc-sheet">
		<div class="doc-head">
			<div class="doc-logo">
				<img src="<?= base_url('assets/img/logo-ciso.png') ?>" alt="Logo" style="width:36px;height:36px;object-fit:contain;">
				<div><div style="font-weight:700;font-size:13.5px;"><?= $company['name'] ?></div><div style="font-size:11px;color:var(--ink-soft);"><?= $company['division'] ?></div></div>
			</div>
			<div style="text-align:right;font-size:11px;color:var(--ink-soft);">Jakarta, <?= format_tanggal($bast['handover_date']) ?></div>
		</div>
		<div class="doc-title"><?= nl2br(wordwrap($template['document_title'] ?? 'BERITA ACARA SERAH TERIMA PERANGKAT LAPTOP', 30, "
", true)) ?></div>
		<div class="doc-no">Nomor: <?= $bast['bast_number'] ?></div>
		<div class="party-grid">
			<div class="party-box"><div class="party-label"><?= $party1_label ?></div><b><?= $bast['signer_name'] ?: ($template['signer_name'] ?: ($bast['created_by_name'] ?: 'Admin IT')) ?></b><br><span class="muted" style="font-size:12px;"><?= $bast['signer_role'] ?: ($template['signer_role'] ?: 'Admin IT Asset Management') ?></span></div>
			<div class="party-box"><div class="party-label"><?= $party2_label ?></div><b><?= $bast['employee_name'] ?></b><br><span class="muted" style="font-size:12px;"><?= $bast['position'] ?> — <?= $bast['group_name'] ?></span></div>
		</div>
		<table class="doc-table">
			<thead><tr><th>No</th><th>Asset ID</th><th>Nama Barang</th><th>Merk/Model</th><th>Serial Number</th><th>Kondisi</th></tr></thead>
			<tbody><tr><td>1</td><td><?= $bast['asset_id'] ?></td><td>Laptop</td><td><?= $bast['brand_name'] ?> <?= $bast['model'] ?></td><td><?= $bast['serial_number'] ?></td><td><?= $bast['condition_on_handover'] ?></td></tr></tbody>
		</table>
		<?php if ($isReturn): ?>
			<p style="font-size:12px;margin:0 0 8px;font-weight:600;">Kondisi Barang Saat Dikembalikan:</p>
			<div class="form-grid" style="margin-bottom:18px;">
				<?php foreach ($checklist as $k => $v): if ( ! isset($checklistLabels[$k])) continue; ?>
					<div class="flex justify-between items-center" style="font-size:12px;"><span><?= $checklistLabels[$k] ?></span><?= status_badge($v) ?></div>
				<?php endforeach; ?>
			</div>
		<?php else: ?>
			<p style="font-size:12px;margin:0 0 6px;font-weight:600;">Kelengkapan yang diserahkan:</p>
			<p style="font-size:12px;color:var(--ink-soft);margin:0 0 18px;"><?= $complete_items ? implode(', ', $complete_items) : '—' ?></p>
		<?php endif; ?>
		<p style="font-size:12px;line-height:1.7;color:var(--ink-soft);"><?= $template['statement_text'] ?? 'Pihak Kedua menyatakan telah menerima perangkat dalam kondisi baik dan bertanggung jawab penuh atas pemeliharaan serta keamanan perangkat tersebut, dan wajib mengembalikannya sesuai dengan ketentuan perusahaan yang berlaku.' ?></p>
		<div class="sig-grid">
			<div class="sig-box">
				<div class="sig-slot"><?php if ($bast['admin_signature']): ?><img src="<?= base_url($bast['admin_signature']) ?>" alt="TTD Admin" style="max-height:56px;max-width:100%;"><?php else: ?>Menunggu TTD<?php endif; ?></div>
				<?= $bast['signer_name'] ?: ($template['signer_name'] ?: ($bast['created_by_name'] ?: 'Admin IT')) ?><br><span class="muted" style="font-size:11px;"><?= $isReturn ? 'Menerima Kembali' : 'Menyerahkan' ?></span>
			</div>
			<div class="sig-box">
				<div class="sig-slot"><?php if ($bast['receiver_signature']): ?><img src="<?= base_url($bast['receiver_signature']) ?>" alt="TTD Penerima" style="max-height:56px;max-width:100%;"><?php else: ?>Menunggu TTD<?php endif; ?></div>
				<?= $bast['employee_name'] ?><br><span class="muted" style="font-size:11px;"><?= $isReturn ? 'Mengembalikan' : 'Menerima' ?></span>
			</div>
			<div class="sig-box">
				<div class="sig-slot"><?php if ($bast['approver_signature']): ?><img src="<?= base_url($bast['approver_signature']) ?>" alt="TTD Atasan" style="max-height:56px;max-width:100%;"><?php else: ?>Menunggu TTD<?php endif; ?></div>
				<?= $bast['approver_name'] ?: $company['approver_name'] ?><br><span class="muted" style="font-size:11px;">Mengetahui — <?= $bast['approver_role'] ?: ($template['approver_role'] ?: $company['approver_role']) ?></span>
			</div>
		</div>

		<?php if ($bast['status'] !== 'dibatalkan'): ?>
		<div class="btn-row" style="margin-top:18px;justify-content:center;flex-wrap:wrap;">
			<?php if ( ! $bast['admin_signature']): ?>
				<a href="<?= site_url('bast/ttd-admin/'.$bast['id']) ?>" class="btn btn-soft btn-sm"><?= ic('edit',13) ?> TTD Sebagai Admin</a>
			<?php endif; ?>
			<?php if ($bast['signature_token']): ?>
				<button type="button" class="btn btn-ghost btn-sm" onclick="copyLink('<?= site_url('ttd/'.$bast['signature_token'].'/penerima') ?>', this)"><?= ic('mail',13) ?> Salin Link TTD Penerima</button>
				<button type="button" class="btn btn-ghost btn-sm" onclick="copyLink('<?= site_url('ttd/'.$bast['signature_token'].'/atasan') ?>', this)"><?= ic('mail',13) ?> Salin Link TTD Atasan</button>
			<?php endif; ?>
		</div>
		<?php endif; ?>
		<div class="flex justify-between items-center" style="margin-top:24px;padding-top:14px;border-top:1px solid var(--border);">
			<span class="flex items-center gap-8" style="font-size:11.5px;color:var(--ink-soft);"><?= ic('qr',26) ?> Pindai untuk verifikasi keaslian dokumen</span>
			<?= status_badge($bast['status']) ?>
		</div>
	</div>
	<div class="card card-pad" style="align-self:flex-start;">
		<h3 class="section-title">Riwayat Aktivitas</h3>
		<div class="timeline">
			<div class="t-item"><div class="t-dot"><?= ic('edit',10) ?></div><div class="t-date"><?= format_tanggal($bast['created_at'], true) ?></div><div class="t-title">Draft dibuat</div><div class="t-desc">Dibuat oleh <?= $bast['created_by_name'] ?: 'Admin IT' ?></div></div>
			<?php if ($bast['status'] !== 'draft'): ?>
			<div class="t-item"><div class="t-dot"><?= ic('mail',10) ?></div><div class="t-date"><?= format_tanggal($bast['updated_at'], true) ?></div><div class="t-title">BAST dikirim untuk TTD</div><div class="t-desc">Dikirim ke email penerima &amp; atasan</div></div>
			<?php endif; ?>
			<?php if ($bast['signed_by_receiver']): ?>
			<div class="t-item"><div class="t-dot"><?= ic('filesig',10) ?></div><div class="t-title">Ditandatangani penerima</div><div class="t-desc"><?= $bast['employee_name'] ?> menandatangani secara digital</div></div>
			<?php endif; ?>
			<?php if ($bast['signed_by_approver']): ?>
			<div class="t-item"><div class="t-dot"><?= ic('filesig',10) ?></div><div class="t-title">Ditandatangani atasan</div><div class="t-desc"><?= $bast['approver_name'] ?> menyetujui</div></div>
			<?php endif; ?>
			<?php if ($bast['status'] === 'aktif' || $bast['status'] === 'selesai'): ?>
			<div class="t-item"><div class="t-dot"><?= ic('check',10) ?></div><div class="t-title">BAST berstatus <?= status_label($bast['status']) ?></div><div class="t-desc">Seluruh pihak telah menandatangani dokumen</div></div>
			<?php endif; ?>
			<?php if ($bast['status'] === 'dibatalkan'): ?>
			<div class="t-item"><div class="t-dot" style="background:var(--red-soft);border-color:var(--red);"><?= ic('x',10) ?></div><div class="t-title">BAST dibatalkan</div><div class="t-desc">Dokumen tidak lagi berlaku</div></div>
			<?php endif; ?>
		</div>
	</div>
</div>
