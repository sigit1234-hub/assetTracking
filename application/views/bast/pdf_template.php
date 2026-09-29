<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Template khusus untuk render PDF BAST via dompdf.
 * CSS ditulis inline & sederhana karena dompdf tidak mendukung
 * CSS custom properties (var()), flexbox, atau grid.
 *
 * Variabel yang tersedia: $bast, $checklist (array), $checklist_labels (array)
 */
$complete_items = [];
foreach ($checklist as $k => $v) {
    if ($v === 'lengkap' && isset($checklist_labels[$k])) {
        $complete_items[] = $checklist_labels[$k];
    }
}
$is_return = (($bast['handover_type'] ?? '') === 'pengembalian');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <style>
    @page {
        margin: 90px 60px 70px 60px;
    }

    body {
        font-family: DejaVu Sans, sans-serif;
        color: #0F2138;
        font-size: 12px;
        line-height: 1.5;
    }

    .doc-head {
        border-bottom: 2px solid #0F2138;
        padding-bottom: 12px;
        margin-bottom: 16px;
    }

    .doc-head table {
        width: 100%;
        border-collapse: collapse;
    }

    .doc-head td {
        vertical-align: top;
    }

    .company-name {
        font-weight: bold;
        font-size: 13px;
    }

    .company-sub {
        font-size: 10.5px;
        color: #4A5B72;
    }

    .doc-date {
        text-align: right;
        font-size: 10.5px;
        color: #4A5B72;
    }

    .doc-title {
        text-align: center;
        font-weight: bold;
        font-size: 15px;
        letter-spacing: 0.5px;
        margin: 14px 0 2px;
    }

    .doc-no {
        text-align: center;
        font-size: 11px;
        color: #4A5B72;
        margin-bottom: 18px;
        font-family: DejaVu Sans Mono, monospace;
    }

    .party-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 16px;
    }

    .party-table td {
        width: 50%;
        border: 1px solid #E4E9F1;
        padding: 10px 12px;
        vertical-align: top;
    }

    .party-label {
        font-size: 9.5px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #4A5B72;
        font-weight: bold;
        margin-bottom: 4px;
    }

    .party-name {
        font-weight: bold;
        font-size: 12.5px;
    }

    .party-sub {
        font-size: 10.5px;
        color: #4A5B72;
    }

    .asset-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 14px;
    }

    .asset-table th {
        background: #F4F6FA;
        font-size: 9.5px;
        padding: 7px 8px;
        border: 1px solid #E4E9F1;
        text-align: left;
    }

    .asset-table td {
        font-size: 10.5px;
        padding: 7px 8px;
        border: 1px solid #E4E9F1;
    }

    .section-label {
        font-size: 10.5px;
        font-weight: bold;
        margin: 4px 0 4px;
    }

    .section-text {
        font-size: 10.5px;
        color: #4A5B72;
        margin: 0 0 12px;
    }

    .statement {
        font-size: 10.5px;
        color: #4A5B72;
        line-height: 1.7;
        margin-bottom: 8px;
    }

    .sig-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 34px;
    }

    .sig-table td {
        width: 33.33%;
        text-align: center;
        font-size: 10.5px;
        padding-top: 6px;
    }

    .sig-line {
        border-top: 1px solid #0F2138;
        padding-top: 6px;
        margin-top: 50px;
    }

    .sig-name {
        font-weight: bold;
    }

    .sig-role {
        color: #4A5B72;
        font-size: 9.5px;
    }

    .footer-note {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        width: 100%;
        margin-top: 0;
        /* Hapus margin-top agar pas di bawah */
        padding-top: 10px;
        border-top: 1px solid #E4E9F1;
        font-size: 9px;
        background-color: #ffffff;
        color: #4A5B72;
    }

    .badge {
        display: inline-block;
        padding: 3px 9px;
        border-radius: 10px;
        font-size: 9px;
        font-weight: bold;
    }
    </style>
</head>

<body>

    <div class="doc-head">
        <table>
            <tr>
                <td style="width:70px;vertical-align:middle;">
                    <img src="<?=$logo?>" style="height:42px;">
                </td>
                <td style="vertical-align:middle;">
                    <div class="company-name"><?= $company['name'] ?></div>
                    <div class="company-sub"><?= $company['division'] ?></div>
                </td>
                <td class="doc-date">Jakarta, <?= format_tanggal($bast['handover_date']) ?></td>
            </tr>
        </table>
    </div>

    <div class="doc-title">
        <?= nl2br(wordwrap($template['document_title'] ?? 'BERITA ACARA SERAH TERIMA PERANGKAT LAPTOP', 30, "\n", true)) ?>
    </div>
    <div class="doc-no">Nomor: <?= $bast['bast_number'] ?></div>

    <table class="party-table">
        <tr>
            <td>
                <div class="party-label">Pihak Pertama (<?= $is_return ? 'Menerima Kembali' : 'Menyerahkan' ?>)</div>
                <div class="party-name">
                    <?= $bast['signer_name'] ?: ($template['signer_name'] ?: ($bast['created_by_name'] ?: 'Admin IT')) ?>
                </div>
                <div class="party-sub">Admin IT Asset Management</div>
            </td>
            <td>
                <div class="party-label">Pihak Kedua (<?= $is_return ? 'Mengembalikan' : 'Menerima' ?>)</div>
                <div class="party-name"><?= $bast['employee_name'] ?></div>
                <div class="party-sub"><?= $bast['position'] ?> — <?= $bast['group_name'] ?></div>
            </td>
        </tr>
    </table>

    <table class="asset-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Asset ID</th>
                <th>Nama Barang</th>
                <th>Merk / Model</th>
                <th>Serial Number</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><?= $bast['asset_id'] ?></td>
                <td>Laptop</td>
                <td><?= $bast['brand_name'] ?> <?= $bast['model'] ?></td>
                <td><?= $bast['serial_number'] ?></td>
                <td><?= $bast['condition_on_handover'] ?></td>
            </tr>
        </tbody>
    </table>

    <div class="section-label"><?= $is_return ? 'Kondisi Barang Saat Dikembalikan' : 'Kelengkapan yang diserahkan' ?>:
    </div>
    <?php if ($is_return): ?>
    <table class="doc-table" style="margin-bottom:14px;">
        <tbody>
            <?php foreach ($checklist as $k => $v): if (! isset($checklist_labels[$k])) {
                continue;
            } ?>
            <tr>
                <td style="width:50%;"><?= $checklist_labels[$k] ?></td>
                <td><?= status_label($v) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
    <div class="section-text"><?= $complete_items ? implode(', ', $complete_items) : '—' ?></div>
    <?php endif; ?>

    <div class="statement">
        <?= $template['statement_text'] ?? 'Pihak Kedua menyatakan telah menerima perangkat dalam kondisi baik dan bertanggung jawab penuh atas pemeliharaan serta keamanan perangkat tersebut, dan wajib mengembalikannya sesuai dengan ketentuan perusahaan yang berlaku.' ?>
    </div>

    <?php if (! empty($bast['notes'])): ?>
    <div class="section-label">Catatan:</div>
    <div class="section-text"><?= $bast['notes'] ?></div>
    <?php endif; ?>

    <table class="sig-table">
        <tr>
            <td>
                <?php if (! empty($bast['admin_signature'])): ?>
                <img src="<?= $ttdAdmin ?>" style="height:44px;">
                <?php endif; ?>
                <div class="sig-line">
                    <div class="sig-name">
                        <?= $bast['signer_name'] ?: ($template['signer_name'] ?: ($bast['created_by_name'] ?: 'Admin IT')) ?>
                    </div>
                    <div class="sig-role"><?= $is_return ? 'Menerima Kembali' : 'Menyerahkan' ?></div>
                </div>
            </td>
            <td>
                <?php if (! empty($bast['receiver_signature'])): ?>
                <img src="<?= $ttdPenerima ?>" style="height:44px;">
                <?php endif; ?>
                <div class="sig-line">
                    <div class="sig-name"><?= $bast['employee_name'] ?></div>
                    <div class="sig-role"><?= $is_return ? 'Mengembalikan' : 'Menerima' ?></div>
                </div>
            </td>
            <td>
                <?php if (! empty($bast['approver_signature'])): ?>
                <img src="<?= $ttdLead ?>" style="height:44px;">
                <?php endif; ?>
                <div class="sig-line">
                    <div class="sig-name"><?= $bast['approver_name'] ?: $company['approver_name'] ?></div>
                    <div class="sig-role">Mengetahui —
                        <?= $bast['approver_role'] ?: ($template['approver_role'] ?: $company['approver_role']) ?></div>
                </div>
            </td>
        </tr>
    </table>

    <div class="footer-note">
        Dokumen ini digenerate otomatis oleh sistem AssetTrack pada <?= format_tanggal(date('Y-m-d'), true) ?>.
        Status dokumen saat ini: <?= strtoupper(status_label($bast['status'])) ?>.
    </div>

</body>

</html>