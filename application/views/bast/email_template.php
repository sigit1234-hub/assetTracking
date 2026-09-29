<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Template email notifikasi BAST — dikirim ke karyawan penerima (dan/atau atasan)
 * saat dokumen BAST dikirim untuk tanda tangan.
 * Variabel: $bast, $company, $recipient_label, $detail_url
 */
?>
<div style="font-family:Arial,Helvetica,sans-serif;max-width:560px;margin:0 auto;color:#0F2138;">
	<div style="background:#0F2138;padding:20px 26px;border-radius:10px 10px 0 0;">
		<div style="color:#fff;font-weight:bold;font-size:15px;"><?= $company['name'] ?></div>
		<div style="color:#9DB0CC;font-size:11.5px;"><?= $company['division'] ?></div>
	</div>
	<div style="border:1px solid #E4E9F1;border-top:none;border-radius:0 0 10px 10px;padding:26px;">
		<p style="font-size:14px;margin:0 0 14px;">Yth. <?= $recipient_label ?>,</p>
		<p style="font-size:13.5px;line-height:1.7;color:#4A5B72;margin:0 0 18px;">
			Dokumen <b>Berita Acara Serah Terima (BAST)</b> perangkat laptop dengan nomor
			<b><?= $bast['bast_number'] ?></b> telah diterbitkan dan menunggu tanda tangan Anda.
			Mohon periksa detail dokumen berikut sebelum menandatangani.
		</p>
		<table style="width:100%;border-collapse:collapse;font-size:12.5px;margin-bottom:20px;">
			<tr><td style="padding:6px 0;color:#4A5B72;">Nomor BAST</td><td style="padding:6px 0;font-weight:bold;text-align:right;"><?= $bast['bast_number'] ?></td></tr>
			<tr><td style="padding:6px 0;color:#4A5B72;">Laptop</td><td style="padding:6px 0;font-weight:bold;text-align:right;"><?= $bast['brand_name'] ?> <?= $bast['model'] ?></td></tr>
			<tr><td style="padding:6px 0;color:#4A5B72;">Asset ID</td><td style="padding:6px 0;font-weight:bold;text-align:right;"><?= $bast['asset_id'] ?></td></tr>
			<tr><td style="padding:6px 0;color:#4A5B72;">Penerima</td><td style="padding:6px 0;font-weight:bold;text-align:right;"><?= $bast['employee_name'] ?></td></tr>
			<tr><td style="padding:6px 0;color:#4A5B72;">Tanggal Serah Terima</td><td style="padding:6px 0;font-weight:bold;text-align:right;"><?= format_tanggal($bast['handover_date']) ?></td></tr>
			<tr><td style="padding:6px 0;color:#4A5B72;">Mengetahui</td><td style="padding:6px 0;font-weight:bold;text-align:right;"><?= $bast['approver_name'] ?: $company['approver_name'] ?> (<?= $company['approver_role'] ?>)</td></tr>
		</table>
		<div style="text-align:center;margin-bottom:20px;">
			<a href="<?= $detail_url ?>" style="display:inline-block;background:#2A5FE0;color:#fff;text-decoration:none;padding:11px 26px;border-radius:8px;font-size:13px;font-weight:bold;">Lihat &amp; Tandatangani Dokumen</a>
		</div>
		<p style="font-size:11.5px;color:#8B9BB4;line-height:1.6;margin:0;">
			Email ini dikirim otomatis oleh sistem AssetTrack. Jika Anda merasa tidak seharusnya
			menerima email ini, silakan abaikan atau hubungi <?= $company['division'] ?>.
		</p>
	</div>
</div>
