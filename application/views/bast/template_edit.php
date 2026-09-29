<div class="crumb"><a href="<?= site_url('bast') ?>">BAST</a> / <a href="<?= site_url('bast/template') ?>">Template BAST</a> / <b>Edit</b></div>
<div class="page-head">
	<div><h1 class="page-title">Edit <?= $template['title'] ?></h1><p class="page-sub">Ubah judul dokumen dan pernyataan tanggung jawab yang tampil pada dokumen BAST.</p></div>
</div>

<div class="grid-2">
	<div class="card card-pad">
		<form method="post" action="<?= site_url('bast/template/edit/'.$template['handover_type']) ?>">
			<div class="field mb-14">
				<label>Nama Template</label>
				<input class="input" name="title" value="<?= htmlspecialchars($template['title']) ?>" required>
				<span class="hint">Nama internal, tampil di daftar Template BAST (tidak muncul di dokumen).</span>
			</div>
			<div class="field mb-14">
				<label>Judul Dokumen</label>
				<textarea class="input" name="document_title" rows="2" required><?= htmlspecialchars($template['document_title']) ?></textarea>
				<span class="hint">Judul besar yang tampil di kop dokumen BAST, contoh: "BERITA ACARA SERAH TERIMA PERANGKAT LAPTOP".</span>
			</div>
			<div class="field mb-14">
				<label>Pernyataan Tanggung Jawab</label>
				<textarea class="input" name="statement_text" rows="6" required><?= htmlspecialchars($template['statement_text']) ?></textarea>
				<span class="hint">Paragraf pernyataan yang tampil sebelum area tanda tangan pada dokumen.</span>
			</div>
			<hr class="hr">
			<h3 class="section-title">Nama Penandatangan</h3>
			<div class="form-grid mb-14">
				<div class="field">
					<label>Nama — Menyerahkan (Pihak Pertama)</label>
					<input class="input" name="signer_name" value="<?= htmlspecialchars($template['signer_name'] ?? '') ?>" placeholder="Kosongkan = pakai nama admin yang login">
				</div>
				<div class="field">
					<label>Jabatan — Menyerahkan</label>
					<input class="input" name="signer_role" value="<?= htmlspecialchars($template['signer_role'] ?? '') ?>" placeholder="Contoh: Admin IT Asset Management">
				</div>
				<div class="field">
					<label>Nama — Atasan (Mengetahui)</label>
					<input class="input" name="approver_name" value="<?= htmlspecialchars($template['approver_name'] ?? '') ?>" placeholder="Kosongkan = pakai default perusahaan">
				</div>
				<div class="field">
					<label>Jabatan — Atasan</label>
					<input class="input" name="approver_role" value="<?= htmlspecialchars($template['approver_role'] ?? '') ?>" placeholder="Contoh: Group Head">
				</div>
			</div>
			<p class="cell-sub mb-14">Nama "Menerima" selalu diambil dari data karyawan penerima laptop yang sebenarnya — tidak bisa diatur di sini.</p>
			<div class="btn-row">
				<button type="submit" class="btn btn-primary"><?= ic('check',15) ?> Simpan Perubahan</button>
				<a href="<?= site_url('bast/template') ?>" class="btn btn-ghost">Batal</a>
			</div>
		</form>
	</div>
	<div class="card card-pad" style="align-self:flex-start;">
		<h3 class="section-title">Kapan Template Ini Dipakai?</h3>
		<?php
		$desc = [
			'serah_terima_awal' => 'Dipakai otomatis saat admin membuat BAST baru tanpa mengisi estimasi tanggal pengembalian di wizard Buat BAST (artinya laptop diserahkan sebagai aset permanen).',
			'peminjaman'        => 'Dipakai otomatis saat admin mengisi estimasi tanggal pengembalian di wizard Buat BAST (artinya laptop dipinjamkan sementara, bukan aset permanen).',
			'pengembalian'      => 'Dibuat otomatis oleh sistem setiap kali admin memproses pengembalian laptop di menu Penggunaan Laptop → Pengembalian Laptop. Tidak perlu dibuat manual.',
		];
		?>
		<p class="muted" style="font-size:12.5px;line-height:1.6;"><?= $desc[$template['handover_type']] ?? '' ?></p>
		<hr class="hr">
		<a href="<?= site_url('bast/template/lihat/'.$template['handover_type']) ?>" target="_blank" class="btn btn-soft btn-sm"><?= ic('eye',13) ?> Lihat Pratinjau Dokumen</a>
	</div>
</div>
