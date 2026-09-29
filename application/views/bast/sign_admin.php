<div class="crumb"><a href="<?= site_url('bast/detail/'.$bast['id']) ?>">BAST <?= $bast['bast_number'] ?></a> / <b>Tanda Tangan Admin</b></div>
<div class="page-head">
	<div><h1 class="page-title">Tanda Tangan Admin (Menyerahkan)</h1><p class="page-sub">Bubuhkan tanda tangan sebagai pihak yang menyerahkan perangkat.</p></div>
</div>

<div class="card card-pad" style="max-width:520px;">
	<?php if ($bast['admin_signature']): ?>
		<div class="alert-item" style="margin-bottom:16px;">
			<div class="alert-ic" style="background:var(--green-soft);color:var(--green);"><?= ic('check',16) ?></div>
			<div><div class="alert-title">Sudah ditandatangani</div><div class="alert-desc">Ditandatangani pada <?= format_tanggal($bast['admin_signed_at'], true) ?></div></div>
		</div>
		<img src="<?= base_url($bast['admin_signature']) ?>" alt="Tanda tangan admin" style="max-width:100%;border:1px solid var(--border);border-radius:10px;background:#fff;">
		<div class="btn-row" style="margin-top:16px;">
			<button type="button" class="btn btn-ghost" onclick="document.getElementById('resign-box').style.display='block'; this.style.display='none';">Tandatangani Ulang</button>
		</div>
		<div id="resign-box" style="display:none;margin-top:16px;">
	<?php else: ?>
		<div>
	<?php endif; ?>

			<label style="font-size:12.5px;font-weight:600;margin-bottom:8px;display:block;">Gambar tanda tangan di kotak ini:</label>
			<canvas id="sig-canvas" style="width:100%;height:200px;background:#fff;border:1.5px dashed var(--border);border-radius:12px;touch-action:none;cursor:crosshair;"></canvas>
			<div class="btn-row" style="margin-top:16px;justify-content:space-between;">
				<button type="button" class="btn btn-ghost" id="btn-clear"><?= ic('refresh',15) ?> Bersihkan</button>
				<button type="button" class="btn btn-primary" id="btn-save"><?= ic('check',15) ?> Simpan Tanda Tangan</button>
			</div>
		</div>
</div>

<script src="<?= base_url('assets/js/signature-pad.js') ?>"></script>
<script>
var canvas = document.getElementById('sig-canvas');
var pad = new SignaturePad(canvas);
document.getElementById('btn-clear').addEventListener('click', function () { pad.clear(); });
document.getElementById('btn-save').addEventListener('click', function () {
	if (pad.isEmpty()) { alert('Mohon gambar tanda tangan terlebih dahulu.'); return; }
	var form = document.createElement('form');
	form.method = 'post';
	form.action = '<?= site_url('bast/ttd-admin/simpan/'.$bast['id']) ?>';
	var input = document.createElement('input');
	input.type = 'hidden'; input.name = 'signature_data'; input.value = pad.toDataURL();
	form.appendChild(input);
	document.body.appendChild(form);
	form.submit();
});
</script>
