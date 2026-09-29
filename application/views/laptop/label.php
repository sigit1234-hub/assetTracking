<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Cetak Label Aset — AssetTrack</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<style>
	body{background:var(--bg);}
	.toolbar{
		background:var(--card);border-bottom:1px solid var(--border);padding:14px 22px;
		display:flex;align-items:center;gap:16px;flex-wrap:wrap;position:sticky;top:0;z-index:20;
	}
	.toolbar .field{flex-direction:row;align-items:center;gap:8px;}
	.toolbar .field label{font-size:12px;white-space:nowrap;}
	.toolbar .field input{width:70px;padding:6px 8px;font-size:12.5px;}
	.toolbar select{padding:6px 10px;font-size:12.5px;}

	.label-sheet{padding:26px;display:flex;flex-wrap:wrap;gap:14px;}

	/* --- kartu label (preview di layar) --- */
	.label-card{
		background:#fff;border:1px solid var(--border);box-shadow:var(--shadow-sm);
		display:flex;align-items:stretch;gap:0;overflow:hidden;
		font-family:'Inter',sans-serif;
	}
	.label-qr{
		display:flex;align-items:center;justify-content:center;flex-shrink:0;
		padding:4px;border-right:1.5px solid #000;
	}
	.label-qr canvas, .label-qr img{display:block;}
	.label-info{flex:1;display:flex;flex-direction:column;justify-content:center;padding:3px 8px;min-width:0;}
	.label-row{display:flex;font-size:9.5px;line-height:1.55;white-space:nowrap;overflow:hidden;}
	.label-row .lbl{width:62px;flex-shrink:0;font-weight:600;color:#111;}
	.label-row .sep{width:10px;flex-shrink:0;}
	.label-row .val{overflow:hidden;text-overflow:ellipsis;font-family:'IBM Plex Mono',monospace;font-weight:600;color:#111;}

	/* --- print --- */
	@media print{
		body{background:#fff;}
		.toolbar, .no-print{display:none !important;}
		.label-sheet{padding:0;gap:0;display:block;}
		.label-card{box-shadow:none;border:1px solid #000;page-break-after:always;margin:0;}
		.label-card:last-child{page-break-after:auto;}
	}
</style>
</head>
<body>

<div class="toolbar no-print">
	<div class="flex items-center gap-8" style="margin-right:auto;">
		<?= ic('printer',18) ?>
		<b style="font-size:14px;">Cetak Label Aset</b>
		<span class="cell-sub">(<?= count($laptops) ?> label)</span>
	</div>

	<div class="field">
		<label>Preset Tape</label>
		<select id="preset-select">
			<option value="24x70">Brother 24mm × 70mm (disarankan)</option>
			<option value="18x62">Brother 18mm × 62mm</option>
			<option value="12x50">Brother 12mm × 50mm</option>
			<option value="custom">Custom...</option>
		</select>
	</div>
	<div class="field">
		<label>Tinggi (mm)</label>
		<input type="number" id="label-height" value="24" min="6" max="100" step="0.5">
	</div>
	<div class="field">
		<label>Lebar (mm)</label>
		<input type="number" id="label-width" value="70" min="20" max="200" step="0.5">
	</div>

	<button type="button" class="btn btn-ghost btn-sm" onclick="window.close()"><?= ic('x',14) ?> Tutup</button>
	<button type="button" class="btn btn-primary btn-sm" onclick="window.print()"><?= ic('printer',14) ?> Cetak ke Printer</button>
</div>

<div class="label-sheet" id="label-sheet">
	<?php foreach ($laptops as $i => $l): ?>
	<div class="label-card" data-idx="<?= $i ?>">
		<div class="label-qr" id="qr-<?= $i ?>"></div>
		<div class="label-info">
			<div class="label-row"><span class="lbl">Kode Aset</span><span class="sep">:</span><span class="val"><?= $l['asset_id'] ?></span></div>
			<div class="label-row"><span class="lbl">Jenis Asset</span><span class="sep">:</span><span class="val">Laptop/Notebook</span></div>
			<div class="label-row"><span class="lbl">Nama Asset</span><span class="sep">:</span><span class="val"><?= trim($l['brand_name'].' '.$l['model']) ?></span></div>
			<div class="label-row"><span class="lbl">SN</span><span class="sep">:</span><span class="val"><?= $l['serial_number'] ?></span></div>
		</div>
	</div>
	<?php endforeach; ?>
</div>

<script src="<?= base_url('assets/js/qrcode.js') ?>"></script>
<script>
var MM_TO_PX = 96 / 25.4; // konversi mm ke pixel CSS (96dpi) untuk preview di layar

var labelData = <?= json_encode(array_map(function($l){
	return [
		'asset_id' => $l['asset_id'],
		'qr_text'  => site_url('laptop/detail/' . $l['id']),
	];
}, $laptops)) ?>;

var presets = { '24x70': [24,70], '18x62': [18,62], '12x50': [12,50] };

function applyLabelSize(heightMm, widthMm) {
	// Update style tampilan di layar (preview)
	document.querySelectorAll('.label-card').forEach(function (card) {
		card.style.height = (heightMm * MM_TO_PX) + 'px';
		card.style.width  = (widthMm * MM_TO_PX) + 'px';
	});
	document.querySelectorAll('.label-qr').forEach(function (qr) {
		var size = Math.round((heightMm - 3) * MM_TO_PX);
		qr.style.width = size + 'px';
		qr.style.height = size + 'px';
	});

	// Update ukuran fisik halaman cetak (@page) sesuai ukuran label
	var styleTag = document.getElementById('dynamic-page-size');
	if (!styleTag) {
		styleTag = document.createElement('style');
		styleTag.id = 'dynamic-page-size';
		document.head.appendChild(styleTag);
	}
	styleTag.innerHTML = '@page { size: ' + widthMm + 'mm ' + heightMm + 'mm; margin: 0; }' +
		'@media print { .label-card { width: ' + widthMm + 'mm !important; height: ' + heightMm + 'mm !important; } ' +
		'.label-qr { width: ' + (heightMm - 3) + 'mm !important; height: ' + (heightMm - 3) + 'mm !important; } }';
}

function renderQRCodes() {
	document.querySelectorAll('.label-qr').forEach(function (el) { el.innerHTML = ''; });
	labelData.forEach(function (d, i) {
		var el = document.getElementById('qr-' + i);
		if (el) {
			new QRCode(el, {
				text: d.qr_text,
				width: 200,
				height: 200,
				correctLevel: QRCode.CorrectLevel.M
			});
			// QRCode.js membuat <img> atau <canvas> ukuran tetap 200px; kita skalakan pakai CSS agar responsif
			setTimeout(function () {
				var img = el.querySelector('img, canvas');
				if (img) { img.style.width = '100%'; img.style.height = '100%'; }
			}, 30);
		}
	});
}

document.getElementById('preset-select').addEventListener('change', function () {
	var val = this.value;
	if (presets[val]) {
		document.getElementById('label-height').value = presets[val][0];
		document.getElementById('label-width').value = presets[val][1];
		applyLabelSize(presets[val][0], presets[val][1]);
	}
});
document.getElementById('label-height').addEventListener('input', function () {
	applyLabelSize(parseFloat(this.value) || 24, parseFloat(document.getElementById('label-width').value) || 70);
});
document.getElementById('label-width').addEventListener('input', function () {
	applyLabelSize(parseFloat(document.getElementById('label-height').value) || 24, parseFloat(this.value) || 70);
});

renderQRCodes();
applyLabelSize(24, 70);
</script>
</body>
</html>
