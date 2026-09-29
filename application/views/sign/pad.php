<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Tanda Tangan BAST — <?= $bast['bast_number'] ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<style>
	body{background:var(--bg);min-height:100vh;}
	.sign-wrap{max-width:520px;margin:0 auto;padding:28px 18px 60px;}
	.sign-header{text-align:center;margin-bottom:22px;}
	.sign-header .brand-mark{margin:0 auto 12px;}
	#sig-canvas{width:100%;height:220px;background:#fff;border:1.5px dashed var(--border);border-radius:12px;touch-action:none;cursor:crosshair;}
	.sig-hint{text-align:center;font-size:11.5px;color:var(--ink-soft);margin-top:8px;}
</style>
</head>
<body>
<div id="toast-wrap"></div>
<div class="sign-wrap">
	<div class="sign-header">
		<div class="brand-mark" style="width:46px;height:46px;"><?= ic('filesig', 22) ?></div>
		<h2 style="margin:4px 0 2px;font-size:18px;"><?= $company['name'] ?></h2>
		<p class="muted" style="margin:0;font-size:12.5px;"><?= $company['division'] ?></p>
	</div>

	<div class="card card-pad mb-20">
		<div class="flex items-center gap-10 mb-14">
			<span class="asset-tag" style="font-size:13px;"><?= $bast['bast_number'] ?></span>
			<?= status_badge($bast['status']) ?>
		</div>
		<h3 style="margin:0 0 14px;font-size:15.5px;">Anda diminta menandatangani dokumen BAST sebagai <b><?= $role_label ?></b></h3>
		<div class="form-grid" style="grid-template-columns:1fr 1fr;font-size:12.5px;">
			<div><div class="muted" style="font-size:11px;">Laptop</div><b><?= $bast['brand_name'] ?> <?= $bast['model'] ?></b></div>
			<div><div class="muted" style="font-size:11px;">Asset ID</div><b><?= $bast['asset_id'] ?></b></div>
			<div><div class="muted" style="font-size:11px;">Penerima</div><b><?= $bast['employee_name'] ?></b></div>
			<div><div class="muted" style="font-size:11px;">Tanggal Serah Terima</div><b><?= format_tanggal($bast['handover_date']) ?></b></div>
		</div>
	</div>

	<?php if ($already_signed): ?>
		<div class="card card-pad" style="text-align:center;">
			<div class="alert-ic" style="background:var(--green-soft);color:var(--green);margin:0 auto 12px;"><?= ic('check',22) ?></div>
			<h3 style="margin:0 0 6px;font-size:15px;">Anda sudah menandatangani dokumen ini</h3>
			<p class="muted" style="font-size:12.5px;margin:0;">Tanda tangan atas nama <b><?= $signer_name ?></b> telah tercatat di sistem. Tidak perlu menandatangani ulang.</p>
		</div>
	<?php else: ?>
		<div class="card card-pad">
			<label style="font-size:12.5px;font-weight:600;margin-bottom:8px;display:block;">Gambar tanda tangan Anda di kotak ini (<?= $signer_name ?>):</label>
			<canvas id="sig-canvas"></canvas>
			<p class="sig-hint">Gunakan jari (di HP/tablet) atau mouse untuk menandatangani</p>
			<?php if ($this->session->flashdata('sign_error')): ?>
				<div class="login-error" style="margin-top:12px;"><?= $this->session->flashdata('sign_error') ?></div>
			<?php endif; ?>
			<div class="btn-row" style="margin-top:16px;justify-content:space-between;">
				<button type="button" class="btn btn-ghost" id="btn-clear"><?= ic('refresh',15) ?> Bersihkan</button>
				<button type="button" class="btn btn-primary" id="btn-save"><?= ic('check',15) ?> Simpan Tanda Tangan</button>
			</div>
		</div>
	<?php endif; ?>

	<p class="muted" style="text-align:center;font-size:11px;margin-top:20px;">Halaman ini aman &amp; khusus untuk Anda — jangan bagikan tautan ini kepada orang lain.</p>
</div>

<form id="sign-form" method="post" action="<?= site_url('ttd/simpan') ?>" style="display:none;">
	<input type="hidden" name="token" value="<?= $token ?>">
	<input type="hidden" name="role" value="<?= $role ?>">
	<input type="hidden" name="signature_data" id="signature_data">
</form>

<script src="<?= base_url('assets/js/signature-pad.js') ?>"></script>
<script>
<?php if (!$already_signed): ?>
var canvas = document.getElementById('sig-canvas');
var pad = new SignaturePad(canvas);

document.getElementById('btn-clear').addEventListener('click', function () { pad.clear(); });

document.getElementById('btn-save').addEventListener('click', function () {
	if (pad.isEmpty()) {
		alert('Mohon gambar tanda tangan Anda terlebih dahulu.');
		return;
	}
	document.getElementById('signature_data').value = pad.toDataURL();
	document.getElementById('sign-form').submit();
});
<?php endif; ?>
</script>
</body>
</html>
