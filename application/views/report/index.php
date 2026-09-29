<div class="page-head">
	<div><h1 class="page-title">Laporan &amp; Analytics</h1><p class="page-sub">Ringkasan performa aset, penggunaan, dan dokumen BAST.</p></div>
	<div class="btn-row">
		<a href="<?= site_url('laporan/export/excel') ?>" class="btn btn-ghost"><?= ic('download',15) ?> Export Excel</a>
		<a href="<?= site_url('laporan/export/pdf') ?>" class="btn btn-primary"><?= ic('download',15) ?> Export PDF</a>
	</div>
</div>

<div class="grid-2 mb-20">
	<div class="card card-pad">
		<h3 class="section-title">Tren Penggunaan Laptop per Bulan</h3>
		<canvas id="chartLine" height="140"></canvas>
	</div>
	<div class="card card-pad">
		<h3 class="section-title">Distribusi Status Aset</h3>
		<canvas id="chartDonut" height="160"></canvas>
	</div>
</div>

<div class="grid-3">
	<div class="card card-pad"><h3 class="section-title">Laptop per Grup</h3><canvas id="chartDivisi" height="150"></canvas></div>
	<div class="card card-pad"><h3 class="section-title">BAST per Status</h3><canvas id="chartBast" height="150"></canvas></div>
	<div class="card card-pad">
		<h3 class="section-title">Ringkasan Cepat</h3>
		<div style="display:flex;flex-direction:column;gap:12px;">
			<?php
			function qstat($l,$v){ echo '<div class="flex justify-between items-center" style="padding-bottom:10px;border-bottom:1px solid var(--border-soft);"><span class="muted" style="font-size:12.5px;">'.$l.'</span><b style="font-size:13.5px;">'.$v.'</b></div>'; }
			qstat('Total Aset Terdaftar', $total_laptop.' Unit');
			qstat('BAST Diterbitkan ('.date('Y').')', $bast_this_year.' Dokumen');
			qstat('Laptop Maintenance', $status['maintenance'].' Unit');
			qstat('Laptop Tersedia', $status['tersedia'].' Unit');
			?>
		</div>
	</div>
</div>

<script>
new Chart(document.getElementById('chartLine'), {
	type: 'line',
	data: { labels: <?= json_encode($usage_trend['labels']) ?>, datasets: [{ label:'Digunakan', data: <?= json_encode($usage_trend['data']) ?>, borderColor:'#2A5FE0', backgroundColor:'#2A5FE022', fill:true, tension:.4 }] },
	options: { scales:{ y:{grid:{color:'#EEF1F6'}}, x:{grid:{display:false}} } }
});
new Chart(document.getElementById('chartDonut'), {
	type:'doughnut',
	data: { labels:['Digunakan','Tersedia','Maintenance','Rusak','Tidak Aktif'],
		datasets:[{ data:[<?= $status['digunakan'] ?>,<?= $status['tersedia'] ?>,<?= $status['maintenance'] ?>,<?= $status['rusak'] ?>,<?= $status['nonaktif'] ?>], backgroundColor:['#2A5FE0','#0E8F5C','#B76B00','#C22A3C','#5B6B82'], borderWidth:0 }] },
	options: { cutout:'68%', plugins:{legend:{display:false}} }
});
new Chart(document.getElementById('chartDivisi'), {
	type:'bar',
	data: { labels: <?= json_encode(array_column($per_group,'group')) ?>, datasets:[{ data: <?= json_encode(array_map('intval', array_column($per_group,'total'))) ?>, backgroundColor:'#2A5FE0', borderRadius:6, maxBarThickness:28 }] },
	options: { plugins:{legend:{display:false}}, scales:{ y:{grid:{color:'#EEF1F6'}}, x:{grid:{display:false}} } }
});
new Chart(document.getElementById('chartBast'), {
	type:'doughnut',
	data: { labels:['Aktif','Menunggu','Selesai','Dibatalkan'], datasets:[{ data:[<?= $bast_summary['aktif'] ?>,<?= $bast_summary['menunggu'] ?>,<?= $bast_summary['selesai'] ?>,<?= $bast_summary['dibatalkan'] ?>], backgroundColor:['#0E8F5C','#B76B00','#5B6B82','#C22A3C'], borderWidth:0 }] },
	options: { cutout:'60%', plugins:{legend:{display:false}} }
});
</script>
