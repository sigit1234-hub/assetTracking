<div class="page-head">
	<div><h1 class="page-title">Pengembalian Laptop</h1><p class="page-sub">Proses pengembalian aset laptop dan pembaruan kondisi perangkat.</p></div>
</div>

<form method="post" action="<?= site_url('penggunaan/proses-pengembalian') ?>" enctype="multipart/form-data">
<div class="grid-2">
	<div class="card card-pad">
		<h3 class="section-title">1. Data Laptop yang Dikembalikan</h3>
		<input type="hidden" name="laptop_id" id="ret-laptop-id" value="<?= (int) $selected_id ?>">

		<div class="filter-bar" style="flex-wrap:wrap;gap:10px;padding:0;margin-bottom:10px;">
			<div class="search-bar" style="flex:1;min-width:240px;background:var(--bg);"><?= ic('search',15) ?><input type="text" id="rf-q" placeholder="Cari SN, Asset ID, nama laptop, nama karyawan, PN"></div>
			<select class="select" id="rf-group"><option value="">Semua Grup</option>
				<?php foreach ($groups as $g): ?><option value="<?= htmlspecialchars($g['name']) ?>"><?= htmlspecialchars($g['name']) ?></option><?php endforeach; ?></select>
			<select class="select" id="rf-brand"><option value="">Semua Merek</option>
				<?php foreach ($brands as $b): ?><option value="<?= htmlspecialchars($b['name']) ?>"><?= htmlspecialchars($b['name']) ?></option><?php endforeach; ?></select>
			<select class="select" id="rf-jenis"><option value="">Semua Jenis</option><option value="tetap">Aset Tetap</option><option value="sementara">Sementara (Dipinjam)</option></select>
			<select class="select" id="rf-kondisi"><option value="">Semua Kondisi</option><option value="segera">Akan Dikembalikan (7 hari)</option><option value="overdue">Overdue</option></select>
			<button type="button" class="btn btn-ghost" id="rf-reset">Reset</button>
		</div>
		<p class="cell-sub" style="margin:0 0 8px;">Menampilkan <b id="rf-count"><?= count($candidates) ?></b> dari <?= count($candidates) ?> laptop yang sedang digunakan. Klik baris untuk memilih.</p>

		<div class="table-wrap" style="max-height:320px;overflow:auto;">
		<table>
			<thead><tr><th></th><th>Asset ID</th><th>Serial Number</th><th>Laptop</th><th>Pengguna</th><th>Grup</th><th>Estimasi Kembali</th></tr></thead>
			<tbody id="rf-body">
			<?php foreach ($candidates as $u):
				$today = date('Y-m-d');
				$exp = $u['expected_return_date'];
				$jenis = $exp ? 'sementara' : 'tetap';
				$kondisi = '';
				if ($exp && $exp < $today) $kondisi = 'overdue';
				elseif ($exp && $exp <= date('Y-m-d', strtotime('+7 days'))) $kondisi = 'segera';
				$search = strtolower(implode(' ', [$u['serial_number'],$u['asset_id'],$u['brand_name'],$u['model'],$u['employee_name'],$u['employee_nik']]));
			?>
				<tr class="rf-row" style="cursor:pointer;"
					data-search="<?= htmlspecialchars($search) ?>" data-group="<?= htmlspecialchars($u['group_name']) ?>"
					data-brand="<?= htmlspecialchars($u['brand_name']) ?>" data-jenis="<?= $jenis ?>" data-kondisi="<?= $kondisi ?>">
					<td><input type="radio" name="laptop_pick" value="<?= $u['laptop_id'] ?>" <?= $selected_id==$u['laptop_id']?'checked':'' ?>></td>
					<td><span class="asset-tag"><?= $u['asset_id'] ?></span></td>
					<td class="cell-sub"><?= htmlspecialchars($u['serial_number']) ?></td>
					<td><?= htmlspecialchars(trim($u['brand_name'].' '.$u['model'])) ?></td>
					<td class="cell-main"><?= htmlspecialchars($u['employee_name'] ?: 'tanpa pengguna') ?><div class="cell-sub"><?= htmlspecialchars($u['employee_nik']) ?></div></td>
					<td><?= htmlspecialchars($u['group_name']) ?></td>
					<td class="cell-sub"><?= $exp ? format_tanggal($exp) : 'Aset Tetap' ?><?= $kondisi==='overdue' ? ' '.status_badge('overdue') : '' ?></td>
				</tr>
			<?php endforeach; ?>
			<tr id="rf-empty" style="display:none;"><td colspan="7"><div class="empty-state"><p>Tidak ada laptop yang cocok dengan filter.</p></div></td></tr>
			</tbody>
		</table>
		</div>
		<div id="rf-selected" class="cell-sub" style="margin:8px 0 14px;"></div>
		<hr class="hr">
		<h3 class="section-title">2. Kondisi Laptop</h3>
		<div class="checklist mb-14">
			<?php
			$parts = ['Kondisi Fisik','Layar','Keyboard','Charger','Baterai','Port USB','Sistem Operasi'];
			foreach ($parts as $i => $p):
				$name = 'part_'.$i;
			?>
			<div class="check-row">
				<span style="font-size:13px;font-weight:500;"><?= $p ?></span>
				<div class="seg">
					<label class="o-baik"><input type="radio" name="<?= $name ?>" value="baik" checked><span>Baik</span></label>
					<label class="o-ada_kerusakan"><input type="radio" name="<?= $name ?>" value="ada_kerusakan"><span>Ada Kerusakan</span></label>
					<label class="o-perlu_maintenance"><input type="radio" name="<?= $name ?>" value="perlu_maintenance"><span>Perlu Maintenance</span></label>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
		<div class="field mb-14">
			<label>Kondisi Keseluruhan</label>
			<select class="select" name="overall_condition" style="width:100%;">
				<option value="baik">Baik — kembalikan status menjadi Tersedia</option>
				<option value="ada_kerusakan">Ada Kerusakan — masuk Maintenance</option>
				<option value="perlu_maintenance">Perlu Maintenance Rutin — masuk Maintenance</option>
			</select>
		</div>
		<div class="field mb-14">
			<label>Upload Foto Kondisi Laptop</label>
			<div style="border:1.5px dashed var(--border);border-radius:10px;padding:20px;text-align:center;color:var(--ink-soft);">
				<?= ic('camera',22) ?><p style="font-size:12px;margin:8px 0 0;">Klik atau seret foto ke sini (maks. 4 foto)</p>
				<input type="file" name="photos[]" accept="image/*" multiple>
			</div>
		</div>
		<div class="field"><label>Catatan Pengembalian</label><textarea class="input" name="notes" rows="3" placeholder="Contoh: Laptop dalam kondisi baik, hanya baterai agak boros."></textarea></div>
		<div class="btn-row" style="margin-top:20px;">
			<button type="submit" class="btn btn-primary"><?= ic('check',15) ?> Proses Pengembalian</button>
			<a href="<?= site_url('penggunaan') ?>" class="btn btn-ghost">Batal</a>
		</div>
	</div>
	<div class="card card-pad" style="align-self:flex-start;">
		<h3 class="section-title">Setelah Pengembalian, Sistem Otomatis</h3>
		<div class="timeline">
			<div class="t-item"><div class="t-dot"><?= ic('refresh',10) ?></div><div class="t-title">Mengubah status laptop</div><div class="t-desc">Menjadi Tersedia atau Dalam Perbaikan</div></div>
			<div class="t-item"><div class="t-dot"><?= ic('clock',10) ?></div><div class="t-title">Menutup sesi penggunaan</div><div class="t-desc">Riwayat penggunaan sebelumnya ditutup &amp; dicatat</div></div>
			<div class="t-item"><div class="t-dot"><?= ic('filesig',10) ?></div><div class="t-title">Mengubah status BAST</div><div class="t-desc">Menjadi Selesai secara otomatis</div></div>
		</div>
	</div>
</div>
</form>

<script>
(function(){
	var rows = [].slice.call(document.querySelectorAll('.rf-row'));
	var el = function(id){ return document.getElementById(id); };
	var hidden = el('ret-laptop-id');
	function apply(){
		var q = el('rf-q').value.trim().toLowerCase();
		var g = el('rf-group').value, b = el('rf-brand').value, j = el('rf-jenis').value, k = el('rf-kondisi').value;
		var n = 0;
		rows.forEach(function(r){
			var ok = (!q || r.dataset.search.indexOf(q) > -1) && (!g || r.dataset.group === g) &&
				(!b || r.dataset.brand === b) && (!j || r.dataset.jenis === j) && (!k || r.dataset.kondisi === k);
			r.style.display = ok ? '' : 'none';
			if (ok) n++;
		});
		el('rf-count').textContent = n;
		el('rf-empty').style.display = n ? 'none' : '';
	}
	function pick(r){
		var radio = r.querySelector('input[type=radio]');
		radio.checked = true; hidden.value = radio.value;
		rows.forEach(function(x){ x.style.background = ''; });
		r.style.background = 'var(--primary-soft)';
		el('rf-selected').innerHTML = 'Dipilih: <b>' + r.children[1].textContent.trim() + '</b> — ' + r.children[3].textContent.trim() + ' (' + r.children[4].childNodes[0].textContent.trim() + ')';
	}
	rows.forEach(function(r){ r.addEventListener('click', function(){ pick(r); }); });
	['rf-q','rf-group','rf-brand','rf-jenis','rf-kondisi'].forEach(function(id){
		el(id).addEventListener(id === 'rf-q' ? 'input' : 'change', apply);
	});
	el('rf-reset').addEventListener('click', function(){
		['rf-q','rf-group','rf-brand','rf-jenis','rf-kondisi'].forEach(function(id){ el(id).value = ''; });
		apply();
	});
	var pre = rows.filter(function(r){ return r.querySelector('input').checked; })[0];
	if (pre) pick(pre);
	document.querySelector('form[action*="proses-pengembalian"]').addEventListener('submit', function(e){
		if (!hidden.value || hidden.value === '0') { e.preventDefault(); alert('Pilih laptop yang dikembalikan terlebih dahulu.'); }
	});
})();
</script>
