<div class="crumb"><a href="<?= site_url('bast') ?>">BAST</a> / <a href="<?= site_url('bast/template') ?>">Template
        BAST</a> / <b><?= $template['title'] ?></b></div>
<div class="page-head">
    <div>
        <h1 class="page-title"><?= $template['title'] ?></h1>
        <p class="page-sub">Pratinjau tampilan dokumen dengan data contoh (bukan data BAST sungguhan).</p>
    </div>
    <div class="btn-row">
        <a href="<?= site_url('bast/template/edit/'.$template['handover_type']) ?>"
            class="btn btn-primary"><?= ic('edit', 15) ?> Edit Template</a>
        <a href="<?= site_url('bast/template') ?>" class="btn btn-ghost">Kembali</a>
    </div>
</div>

<?php
// Data contoh (placeholder) hanya untuk pratinjau — bukan BAST sungguhan
$isReturn = $template['handover_type'] === 'pengembalian';
$sampleChecklistLabels = $isReturn
    ? ['Kondisi Fisik','Layar','Keyboard','Charger','Baterai','Port USB','Sistem Operasi']
    : ['Unit Laptop','Charger','Tas Laptop','Mouse','Adapter'];
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
            <?= format_tanggal(date('Y-m-d')) ?></div>
    </div>
    <div class="doc-title"><?= nl2br(htmlspecialchars($template['document_title'])) ?></div>
    <div class="doc-no">Nomor: BAST/IT/<?= date('Y') ?>/XXX <span class="muted">(contoh)</span></div>

    <div class="party-grid">
        <div class="party-box">
            <div class="party-label">Pihak Pertama (Menyerahkan)</div>
            <b><?= $template['signer_name'] ?: ($company['approver_name'] ?: 'Admin IT') ?></b><br><span class="muted"
                style="font-size:12px;"><?= $template['signer_role'] ?: 'Admin IT Asset Management' ?></span>
        </div>
        <div class="party-box">
            <div class="party-label">Pihak Kedua (<?= $isReturn ? 'Mengembalikan' : 'Menerima' ?>)</div><b>Contoh Nama
                Karyawan</b><br><span class="muted" style="font-size:12px;">Jabatan Contoh — Grup Contoh</span>
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
                <td>CIS-000/AST-L/<?= date('Y') ?></td>
                <td>Laptop</td>
                <td>Contoh Merk / Model</td>
                <td>SN-CONTOH-0001</td>
                <td>Baik / Layak Pakai</td>
            </tr>
        </tbody>
    </table>

    <p style="font-size:12px;margin:0 0 6px;font-weight:600;">
        <?= $isReturn ? 'Kondisi kelengkapan saat dikembalikan:' : 'Kelengkapan yang diserahkan:' ?></p>
    <p style="font-size:12px;color:var(--ink-soft);margin:0 0 18px;"><?= implode(', ', $sampleChecklistLabels) ?> —
        kondisi baik <span class="muted">(contoh)</span>.</p>

    <p style="font-size:12px;line-height:1.7;color:var(--ink-soft);">
        <?= nl2br(htmlspecialchars($template['statement_text'])) ?></p>

    <div class="sig-grid">
        <div class="sig-box">
            <div class="sig-slot">Menunggu TTD</div><?= $company['approver_name'] ?: 'Admin IT' ?><br><span
                class="muted" style="font-size:11px;">Menyerahkan</span>
        </div>
        <div class="sig-box">
            <div class="sig-slot">Menunggu TTD</div>Contoh Nama Karyawan<br><span class="muted"
                style="font-size:11px;"><?= $isReturn ? 'Mengembalikan' : 'Menerima' ?></span>
        </div>
        <div class="sig-box">
            <div class="sig-slot">Menunggu TTD</div><?= $company['approver_name'] ?><br><span class="muted"
                style="font-size:11px;">Mengetahui — <?= $company['approver_role'] ?></span>
        </div>
    </div>

    <div class="flex justify-between items-center"
        style="margin-top:24px;padding-top:14px;border-top:1px solid var(--border);">
        <span class="flex items-center gap-8" style="font-size:11.5px;color:var(--ink-soft);"><?= ic('qr', 26) ?> Pindai
            untuk verifikasi keaslian dokumen</span>
        <?= status_badge('draft') ?>
    </div>
</div>

<div class="card card-pad"
    style="max-width:760px;margin:20px auto 0;background:var(--primary-soft);border-color:#CBDBFC;">
    <p style="font-size:12px;margin:0;color:var(--primary-dark);"><?= ic('alert', 14) ?> Ini hanya pratinjau tampilan
        dengan data contoh. Dokumen BAST sungguhan akan otomatis memakai template ini dengan data laptop &amp; karyawan
        yang sebenarnya.</p>
</div>