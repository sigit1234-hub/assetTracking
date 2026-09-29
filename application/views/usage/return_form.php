<div class="page-head">
    <div>
        <h1 class="page-title">Pengembalian Laptop</h1>
        <p class="page-sub">Proses pengembalian aset laptop dan pembaruan kondisi perangkat.</p>
    </div>
</div>

<form method="post" action="<?= site_url('penggunaan/proses-pengembalian') ?>" enctype="multipart/form-data">
    <div class="grid-2">
        <div class="card card-pad">
            <h3 class="section-title">1. Data Laptop yang Dikembalikan</h3>
            <div class="form-grid mb-14">
                <div class="field">
                    <label>Pilih Laptop</label>
                    <select class="select" name="laptop_id" style="width:100%;" required>
                        <option value="">— Pilih Laptop —</option>
                        <?php foreach ($candidates as $l): ?>
                        <option value="<?= $l['id'] ?>" <?= $selected_id == $l['id'] ? 'selected' : '' ?>>
                            <?= $l['asset_id'] ?> — <?= $l['brand_name'] ?> <?= $l['model'] ?>
                            (<?= $l['employee_name'] ?: 'tanpa pengguna' ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
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
                        <label class="o-baik"><input type="radio" name="<?= $name ?>" value="baik"
                                checked><span>Baik</span></label>
                        <label class="o-ada_kerusakan"><input type="radio" name="<?= $name ?>"
                                value="ada_kerusakan"><span>Ada Kerusakan</span></label>
                        <label class="o-perlu_maintenance"><input type="radio" name="<?= $name ?>"
                                value="perlu_maintenance"><span>Perlu Maintenance</span></label>
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
                <div
                    style="border:1.5px dashed var(--border);border-radius:10px;padding:20px;text-align:center;color:var(--ink-soft);">
                    <?= ic('camera', 22) ?><p style="font-size:12px;margin:8px 0 0;">Klik atau seret foto ke sini (maks.
                        4 foto)</p>
                    <input type="file" name="photos[]" accept="image/*" multiple>
                </div>
            </div>
            <div class="field"><label>Catatan Pengembalian</label><textarea class="input" name="notes" rows="3"
                    placeholder="Contoh: Laptop dalam kondisi baik, hanya baterai agak boros."></textarea></div>
            <div class="btn-row" style="margin-top:20px;">
                <button type="submit" class="btn btn-primary"><?= ic('check', 15) ?> Proses Pengembalian</button>
                <a href="<?= site_url('penggunaan') ?>" class="btn btn-ghost">Batal</a>
            </div>
        </div>
        <div class="card card-pad" style="align-self:flex-start;">
            <h3 class="section-title">Setelah Pengembalian, Sistem Otomatis</h3>
            <div class="timeline">
                <div class="t-item">
                    <div class="t-dot"><?= ic('refresh', 10) ?></div>
                    <div class="t-title">Mengubah status laptop</div>
                    <div class="t-desc">Menjadi Tersedia atau Dalam Perbaikan</div>
                </div>
                <div class="t-item">
                    <div class="t-dot"><?= ic('clock', 10) ?></div>
                    <div class="t-title">Menutup sesi penggunaan</div>
                    <div class="t-desc">Riwayat penggunaan sebelumnya ditutup &amp; dicatat</div>
                </div>
                <div class="t-item">
                    <div class="t-dot"><?= ic('filesig', 10) ?></div>
                    <div class="t-title">Mengubah status BAST</div>
                    <div class="t-desc">Menjadi Selesai secara otomatis</div>
                </div>
            </div>
        </div>
    </div>
</form>