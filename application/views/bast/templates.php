<div class="crumb"><a href="<?= site_url('bast') ?>">BAST</a> / <b>Template BAST</b></div>
<div class="page-head">
    <div>
        <h1 class="page-title">Template BAST</h1>
        <p class="page-sub">Kelola template dokumen Berita Acara Serah Terima.</p>
    </div>
</div>
<div class="grid-3">
    <?php
    $icons = ['serah_terima_awal' => 'filesig','peminjaman' => 'swap','pengembalian' => 'box'];
$colors = ['serah_terima_awal' => 'primary','peminjaman' => 'purple','pengembalian' => 'teal'];
foreach ($templates as $t):
    $c = $colors[$t['handover_type']] ?? 'primary';
    ?>
    <div class="card card-pad">
        <div class="thumb"
            style="width:100%;height:110px;border-radius:9px;margin-bottom:12px;background:linear-gradient(135deg,var(--<?= $c ?>-soft),#fff);">
            <?= ic($icons[$t['handover_type']] ?? 'file', 30) ?>
        </div>
        <h3 style="font-size:14.5px;margin:0 0 4px;"><?= $t['title'] ?></h3>
        <p class="muted" style="font-size:12px;margin:0 0 4px;"><?= $t['document_title'] ?></p>
        <p class="muted" style="font-size:11.5px;margin:0 0 12px;">Terakhir diperbarui <?= time_ago($t['updated_at']) ?>
        </p>
        <div class="btn-row">
            <a href="<?= site_url('bast/template/lihat/'.$t['handover_type']) ?>" target="_blank"
                class="btn btn-ghost btn-sm"><?= ic('eye', 13) ?> Lihat</a>
            <a href="<?= site_url('bast/template/edit/'.$t['handover_type']) ?>"
                class="btn btn-soft btn-sm"><?= ic('edit', 13) ?> Edit</a>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="card card-pad mb-20" style="margin-top:20px;">
    <h3 class="section-title">Bagaimana Template Ini Dipakai?</h3>
    <div class="timeline">
        <div class="t-item">
            <div class="t-dot"><?= ic('filesig', 10) ?></div>
            <div class="t-title">Serah Terima Awal</div>
            <div class="t-desc">Otomatis dipakai saat admin membuat BAST baru tanpa mengisi estimasi tanggal
                pengembalian (aset permanen).</div>
        </div>
        <div class="t-item">
            <div class="t-dot"><?= ic('swap', 10) ?></div>
            <div class="t-title">Serah Terima Sementara</div>
            <div class="t-desc">Otomatis dipakai saat admin mengisi estimasi tanggal pengembalian di wizard Buat BAST
                (peminjaman).</div>
        </div>
        <div class="t-item">
            <div class="t-dot"><?= ic('box', 10) ?></div>
            <div class="t-title">Pengembalian Aset</div>
            <div class="t-desc">Dibuat <b>otomatis oleh sistem</b> setiap kali admin memproses pengembalian laptop di
                menu Penggunaan Laptop → Pengembalian Laptop. Status laptop, riwayat penggunaan, dan BAST asal ikut
                terupdate otomatis.</div>
        </div>
    </div>
</div>