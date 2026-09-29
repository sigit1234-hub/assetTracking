<div class="crumb"><a href="<?= site_url('bast') ?>">BAST</a> /
    <b><?= $is_loan ? 'Buat BAST Sementara' : 'Buat BAST Baru' ?></b>
</div>
<div class="page-head">
    <div>
        <h1 class="page-title"><?= $is_loan ? 'Buat BAST Serah Terima Sementara' : 'Buat BAST Baru' ?></h1>
        <p class="page-sub">
            <?= $is_loan ? 'Untuk peminjaman sementara — estimasi tanggal pengembalian wajib diisi.' : 'Ikuti langkah berikut untuk membuat dokumen serah terima laptop.' ?>
        </p>
    </div>
    <?php if ($is_loan): ?><span class="badge b-purple" style="align-self:flex-start;"><span class="bdot"></span>Mode
        Peminjaman Sementara</span><?php endif; ?>
</div>

<div class="stepper">
    <?php
    function wstep($n, $label, $current)
    {
        $cls = $n < $current ? 'done' : ($n == $current ? 'current' : '');
        $inner = $n < $current ? ic('check', 15) : $n;
        echo '<div class="step '.$cls.'"><div class="step-circle">'.$inner.'</div><div class="step-label">'.$label.'</div></div>';
        if ($n < 4) {
            echo '<div class="step-line '.($n < $current ? 'done' : '').'"></div>';
        }
    }
wstep(1, 'Pilih Laptop', $step);
wstep(2, 'Data Penerima', $step);
wstep(3, 'Detail Serah Terima', $step);
wstep(4, 'Preview BAST', $step);
?>
</div>

<div class="card card-pad">

    <?php if ($step == 1): ?>
    <form method="post" action="<?= site_url('bast/simpan-step1') ?>">
        <div class="search-bar mb-20" style="width:100%;background:var(--bg);">
            <?= ic('search', 15) ?><input type="text" id="laptop-search"
                placeholder="Cari laptop berdasarkan Asset ID, merk, atau serial number...">
        </div>
        <div class="pick-grid" id="laptop-pick-grid">
            <?php if (empty($laptops)): ?>
            <div class="empty-state" style="grid-column:1/-1;">
                <div class="empty-ic"><?= ic('laptop', 22) ?></div>
                <p>Tidak ada laptop berstatus tersedia/digunakan yang dapat diserahterimakan.</p>
            </div>
            <?php else: foreach ($laptops as $l): ?>
            <label
                class="pick-card <?= (!empty($wizard['laptop_id']) && $wizard['laptop_id'] == $l['id']) ? 'selected' : '' ?>"
                data-search="<?= strtolower($l['asset_id'].' '.$l['brand_name'].' '.$l['model'].' '.$l['serial_number']) ?>">
                <input type="radio" name="laptop_id" value="<?= $l['id'] ?>" style="display:none;"
                    <?= (!empty($wizard['laptop_id']) && $wizard['laptop_id'] == $l['id']) ? 'checked' : '' ?> required>
                <div class="pick-thumb"><?= ic('laptop', 26) ?></div>
                <div class="flex justify-between items-center mb-6"><span
                        class="asset-tag"><?= $l['asset_id'] ?></span><?= status_badge($l['status']) ?></div>
                <div class="cell-main" style="font-size:13.5px;"><?= $l['brand_name'] ?> <?= $l['model'] ?></div>
                <div class="cell-sub">SN: <?= $l['serial_number'] ?></div>
            </label>
            <?php endforeach; endif; ?>
        </div>
        <div class="btn-row" style="margin-top:22px;justify-content:flex-end;">
            <button type="submit" class="btn btn-primary" id="wizard-next-btn"
                <?= empty($wizard['laptop_id']) ? 'disabled' : '' ?>>Lanjut <?= ic('arrowRight', 14) ?></button>
        </div>
    </form>

    <?php elseif ($step == 2): ?>
    <form method="post" action="<?= site_url('bast/simpan-step2') ?>">
        <?php if ($selected_laptop): ?>
        <div class="card card-pad mb-20" style="background:var(--green-soft);border-color:var(--green-line);">
            <div class="flex items-center gap-14">
                <div class="thumb" style="width:52px;height:44px;flex-shrink:0;"><?= ic('laptop', 22) ?></div>
                <div style="flex:1;min-width:0;">
                    <div class="flex items-center gap-8 mb-6"><?= ic('check', 15) ?><span
                            style="font-size:12px;font-weight:700;color:var(--green);text-transform:uppercase;letter-spacing:.3px;">Laptop
                            Terpilih Otomatis</span></div>
                    <div class="flex items-center gap-10" style="flex-wrap:wrap;">
                        <span class="asset-tag"><?= $selected_laptop['asset_id'] ?></span>
                        <b style="font-size:13.5px;"><?= $selected_laptop['brand_name'] ?>
                            <?= $selected_laptop['model'] ?></b>
                        <span class="cell-sub">SN: <?= $selected_laptop['serial_number'] ?></span>
                    </div>
                </div>
                <a href="<?= site_url('bast/buat?step=1') ?>" class="btn btn-ghost btn-sm">Ganti Laptop</a>
            </div>
        </div>
        <?php endif; ?>
        <div class="field mb-14">
            <label>Cari Karyawan Penerima</label>
            <div class="search-bar" style="width:100%;background:var(--bg);">
                <?= ic('search', 15) ?><input type="text" id="employee-search"
                    placeholder="Cari nama, PN, atau grup karyawan...">
            </div>
        </div>
        <div class="emp-pick-list mb-14" id="employee-pick-list">
            <?php foreach ($employees as $e): ?>
            <label class="emp-pick-row" data-search="<?= strtolower($e['name'].' '.$e['nik'].' '.$e['group_name']) ?>">
                <input type="radio" name="employee_id" value="<?= $e['id'] ?>"
                    <?= (!empty($wizard['employee_id']) && $wizard['employee_id'] == $e['id']) ? 'checked' : '' ?>
                    required>
                <div class="avatar" style="width:34px;height:34px;font-size:12px;flex-shrink:0;">
                    <?= initials($e['name']) ?></div>
                <div style="flex:1;min-width:0;">
                    <div class="cell-main"><?= $e['name'] ?></div>
                    <div class="cell-sub"><?= $e['nik'] ?> — <?= $e['group_name'] ?: 'Tanpa Grup' ?></div>
                </div>
            </label>
            <?php endforeach; ?>
            <label class="emp-pick-row" data-search="tambah karyawan baru pekerja baru">
                <input type="radio" name="employee_id" value="new"
                    <?= (!empty($wizard['employee_id']) && $wizard['employee_id'] == 'new') ? 'checked' : '' ?>
                    required>
                <div class="avatar"
                    style="width:34px;height:34px;font-size:16px;flex-shrink:0;background:var(--primary-soft);color:var(--primary);">
                    <?= ic('plus', 16) ?></div>
                <div class="cell-main" style="color:var(--primary);">Tambah Karyawan Baru</div>
            </label>
            <div id="employee-search-empty" class="empty-state" style="display:none;padding:26px;">
                <div class="empty-ic"><?= ic('search', 20) ?></div>
                <p>Tidak ada karyawan yang cocok dengan pencarian.</p>
            </div>
        </div>
        <div id="new-employee-fields" class="form-grid" style="display:none;">
            <div class="field"><label>Nama Karyawan</label><input class="input" name="employee_name"
                    placeholder="Nama lengkap"></div>
            <div class="field"><label>PN</label><input class="input" name="nik" placeholder="EMP-2026-0001"></div>
            <div class="field"><label>Jabatan</label><input class="input" name="position"
                    placeholder="Contoh: Sales Executive"></div>
            <div class="field"><label>Grup</label>
                <select class="select" name="group_id" style="width:100%;">
                    <?php foreach ($groups as $d): ?><option value="<?= $d['id'] ?>"><?= $d['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="field"><label>Email</label><input class="input" type="email" name="email"
                    placeholder="nama@nusantaradigital.co.id"></div>
            <div class="field"><label>Nomor HP</label><input class="input" name="phone" placeholder="0812-xxxx-xxxx">
            </div>
        </div>
        <div class="btn-row" style="margin-top:22px;justify-content:space-between;">
            <a href="<?= site_url('bast/buat?step=1') ?>" class="btn btn-ghost">Kembali</a>
            <button type="submit" class="btn btn-primary">Lanjut <?= ic('arrowRight', 14) ?></button>
        </div>
    </form>

    <?php elseif ($step == 3): ?>
    <form method="post" action="<?= site_url('bast/simpan-step3') ?>">
        <div class="form-grid mb-20">
            <div class="field"><label>Nomor BAST</label><input class="input" value="<?= $next_bast_number ?> (otomatis)"
                    disabled></div>
            <div class="field"><label>Tanggal Serah Terima</label><input class="input" type="date" name="handover_date"
                    value="<?= $wizard['handover_date'] ?? date('Y-m-d') ?>" required></div>
            <div class="field"><label>Lokasi</label><input class="input" name="location"
                    value="<?= $wizard['location'] ?? 'BRI 2' ?>" required></div>
            <div class="field"><label>Estimasi Tanggal
                    Pengembalian<?= $is_loan ? ' <span style="color:var(--red);">*</span>' : '' ?></label><input
                    class="input" type="date" name="expected_return_date"
                    value="<?= $wizard['expected_return_date'] ?? '' ?>" <?= $is_loan ? 'required' : '' ?>><span
                    class="hint"><?= $is_loan ? 'Wajib diisi — ini BAST peminjaman sementara.' : 'Kosongkan jika aset tetap (bukan peminjaman sementara)' ?></span>
            </div>
            <div class="field" style="grid-column:1/-1;"><label>Keperluan Penggunaan</label><input class="input"
                    name="purpose" value="<?= $wizard['purpose'] ?? '' ?>"
                    placeholder="Contoh: Operasional harian tim Sales" required></div>
            <div class="field" style="grid-column:1/-1;"><label>Kondisi Laptop Saat Diserahkan</label>
                <select class="select" name="condition_on_handover" style="width:100%;">
                    <option>Baik / Layak Pakai</option>
                    <option>Ada Catatan Minor</option>
                </select>
            </div>
        </div>
        <h3 class="section-title">Checklist Kelengkapan</h3>
        <div class="checklist mb-14">
            <?php
        $items = ['unit_laptop' => 'Unit Laptop','charger' => 'Charger','tas' => 'Tas Laptop','mouse' => 'Mouse','adapter' => 'Adapter','aksesoris_lain' => 'Aksesoris Lain'];
        foreach ($items as $key => $label):
            ?>
            <div class="check-row">
                <span style="font-size:13px;font-weight:500;"><?= $label ?></span>
                <div class="seg">
                    <label class="o-lengkap"><input type="radio" name="checklist_<?= $key ?>" value="lengkap"
                            checked><span>Lengkap</span></label>
                    <label class="o-tidak_lengkap"><input type="radio" name="checklist_<?= $key ?>"
                            value="tidak_lengkap"><span>Tidak Lengkap</span></label>
                    <label class="o-tidak_ada"><input type="radio" name="checklist_<?= $key ?>"
                            value="tidak_ada"><span>Tidak Ada</span></label>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="field"><label>Catatan</label><textarea class="input" name="notes" rows="2"
                placeholder="Catatan tambahan mengenai kelengkapan atau kondisi..."></textarea></div>

        <hr class="hr">
        <h3 class="section-title" style="margin-bottom:4px;">Nama Penandatangan <span class="cell-sub"
                style="font-weight:400;">(opsional — khusus BAST ini)</span></h3>
        <p class="cell-sub mb-14">Kosongkan semua kalau ingin pakai nama default dari Template BAST. Isi hanya kalau
            BAST ini butuh penandatangan berbeda dari biasanya.</p>
        <div class="form-grid mb-14">
            <div class="field">
                <label>Nama — Menyerahkan (Pihak Pertama)</label>
                <input class="input" name="signer_name" value="<?= htmlspecialchars($wizard['signer_name'] ?? '') ?>"
                    placeholder="<?= $template['signer_name'] ?: $current_user['name'] ?>">
            </div>
            <div class="field">
                <label>Jabatan — Menyerahkan</label>
                <input class="input" name="signer_role" value="<?= htmlspecialchars($wizard['signer_role'] ?? '') ?>"
                    placeholder="<?= $template['signer_role'] ?: 'Admin IT Asset Management' ?>">
            </div>
            <div class="field">
                <label>Nama — Atasan (Mengetahui)</label>
                <input class="input" name="approver_name"
                    value="<?= htmlspecialchars($wizard['approver_name'] ?? '') ?>"
                    placeholder="<?= $template['approver_name'] ?: $company['approver_name'] ?>">
            </div>
            <div class="field">
                <label>Jabatan — Atasan</label>
                <input class="input" name="approver_role"
                    value="<?= htmlspecialchars($wizard['approver_role'] ?? '') ?>"
                    placeholder="<?= $template['approver_role'] ?: $company['approver_role'] ?>">
            </div>
        </div>

        <div class="btn-row" style="margin-top:22px;justify-content:space-between;">
            <a href="<?= site_url('bast/buat?step=2') ?>" class="btn btn-ghost">Kembali</a>
            <button type="submit" class="btn btn-primary">Lanjut ke Preview <?= ic('arrowRight', 14) ?></button>
        </div>
    </form>

    <?php elseif ($step == 4): ?>
    <?php
    $laptop = $selected_laptop;
        $employee = $selected_employee;
        $checklist = $wizard['checklist'] ?? [];
        $labels = ['unit_laptop' => 'Unit Laptop','charger' => 'Charger','tas' => 'Tas Laptop','mouse' => 'Mouse','adapter' => 'Adapter','aksesoris_lain' => 'Aksesoris Lain'];
        $complete_items = [];
        foreach ($checklist as $k => $v) {
            if ($v === 'lengkap' && isset($labels[$k])) {
                $complete_items[] = $labels[$k];
            }
        }
        ?>
    <div class="doc-sheet">
        <div class="doc-head">
            <div class="doc-logo">
                <img src="<?= base_url('assets/img/logo-ciso.png') ?>" alt="Logo"
                    style="width:36px;height:36px;object-fit:contain;">
                <div>
                    <div style="font-weight:700;font-size:13.5px;"><?= $company['name'] ?></div>
                    <div style="font-size:11px;color:var(--ink-soft);"><?= $company['division'] ?></div>
                </div>
            </div>
            <div style="text-align:right;font-size:11px;color:var(--ink-soft);">Jakarta,
                <?= format_tanggal($wizard['handover_date']) ?></div>
        </div>
        <div class="doc-title"><?= nl2br(wordwrap($template['document_title'] ?? 'BERITA ACARA SERAH TERIMA PERANGKAT LAPTOP', 30, "
", true)) ?></div>
        <div class="doc-no">Nomor: <?= $next_bast_number ?></div>
        <div class="party-grid">
            <div class="party-box">
                <div class="party-label">Pihak Pertama (Menyerahkan)</div>
                <b><?= $wizard['signer_name'] ?: ($template['signer_name'] ?: $current_user['name']) ?></b><br><span
                    class="muted"
                    style="font-size:12px;"><?= $wizard['signer_role'] ?: ($template['signer_role'] ?: 'Admin IT Asset Management') ?></span>
            </div>
            <div class="party-box">
                <div class="party-label">Pihak Kedua (Menerima)</div><b><?= $employee['name'] ?></b><br><span
                    class="muted" style="font-size:12px;"><?= $employee['position'] ?> —
                    <?= $employee['group_name'] ?></span>
            </div>
        </div>
        <table class="doc-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Asset ID</th>
                    <th>Nama Barang</th>
                    <th>Merk/Model</th>
                    <th>Serial Number</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><?= $laptop['asset_id'] ?></td>
                    <td>Laptop</td>
                    <td><?= $laptop['brand_name'] ?> <?= $laptop['model'] ?></td>
                    <td><?= $laptop['serial_number'] ?></td>
                    <td><?= $wizard['condition_on_handover'] ?></td>
                </tr>
            </tbody>
        </table>
        <p style="font-size:12px;margin:0 0 6px;font-weight:600;">Kelengkapan yang diserahkan:</p>
        <p style="font-size:12px;color:var(--ink-soft);margin:0 0 18px;">
            <?= $complete_items ? implode(', ', $complete_items) : '—' ?> — lengkap dan berfungsi baik.</p>
        <p style="font-size:12px;line-height:1.7;color:var(--ink-soft);">
            <?= $template['statement_text'] ?? 'Pihak Kedua menyatakan telah menerima perangkat dalam kondisi baik dan bertanggung jawab penuh atas pemeliharaan serta keamanan perangkat tersebut, dan wajib mengembalikannya sesuai dengan ketentuan perusahaan yang berlaku.' ?>
        </p>
        <div class="sig-grid">
            <div class="sig-box">
                <div class="sig-slot">Menunggu TTD</div>
                <?= $wizard['signer_name'] ?: ($template['signer_name'] ?: $current_user['name']) ?><br><span
                    class="muted" style="font-size:11px;">Menyerahkan</span>
            </div>
            <div class="sig-box">
                <div class="sig-slot">Menunggu TTD</div><?= $employee['name'] ?><br><span class="muted"
                    style="font-size:11px;">Menerima</span>
            </div>
            <div class="sig-box">
                <div class="sig-slot">Menunggu TTD</div>
                <?= $wizard['approver_name'] ?: ($template['approver_name'] ?: $company['approver_name']) ?><br><span
                    class="muted" style="font-size:11px;">Mengetahui —
                    <?= $wizard['approver_role'] ?: ($template['approver_role'] ?: $company['approver_role']) ?></span>
            </div>
        </div>
        <div class="flex justify-between items-center"
            style="margin-top:24px;padding-top:14px;border-top:1px solid var(--border);">
            <span class="flex items-center gap-8" style="font-size:11.5px;color:var(--ink-soft);"><?= ic('qr', 26) ?>
                Pindai untuk verifikasi keaslian dokumen</span>
            <?= status_badge('draft') ?>
        </div>
    </div>

    <form method="post" action="<?= site_url('bast/finalisasi') ?>">
        <div class="btn-row" style="margin-top:24px;justify-content:space-between;">
            <a href="<?= site_url('bast/buat?step=3') ?>" class="btn btn-ghost">Kembali</a>
            <div class="btn-row">
                <button type="submit" name="action" value="draft" class="btn btn-ghost">Simpan Draft</button>
                <button type="submit" name="action" value="pdf" class="btn btn-soft"><?= ic('file', 15) ?> Generate
                    PDF</button>
                <button type="submit" name="action" value="send" class="btn btn-primary"><?= ic('mail', 15) ?> Kirim
                    untuk Tanda Tangan</button>
            </div>
        </div>
    </form>
    <?php endif; ?>

</div>

<script>
var searchBox = document.getElementById('laptop-search');
if (searchBox) {
    searchBox.addEventListener('input', function() {
        var q = this.value.toLowerCase();
        document.querySelectorAll('#laptop-pick-grid .pick-card').forEach(function(c) {
            c.style.display = c.getAttribute('data-search').indexOf(q) > -1 ? '' : 'none';
        });
    });
}

var empSearchBox = document.getElementById('employee-search');
if (empSearchBox) {
    empSearchBox.addEventListener('input', function() {
        var q = this.value.toLowerCase().trim();
        var visibleCount = 0;
        document.querySelectorAll('#employee-pick-list .emp-pick-row').forEach(function(row) {
            var match = row.getAttribute('data-search').indexOf(q) > -1;
            row.style.display = match ? '' : 'none';
            if (match) visibleCount++;
        });
        var emptyState = document.getElementById('employee-search-empty');
        if (emptyState) emptyState.style.display = visibleCount === 0 ? 'flex' : 'none';
    });
}

document.querySelectorAll('#employee-pick-list input[name="employee_id"]').forEach(function(radio) {
    radio.addEventListener('change', function() {
        document.querySelectorAll('.emp-pick-row').forEach(function(r) {
            r.classList.remove('selected');
        });
        radio.closest('.emp-pick-row').classList.add('selected');
        var newBox = document.getElementById('new-employee-fields');
        if (newBox) newBox.style.display = (radio.value === 'new') ? 'grid' : 'none';
    });
});
</script>