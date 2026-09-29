<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Link Tidak Valid</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
<style>body{background:var(--bg);min-height:100vh;display:flex;align-items:center;justify-content:center;}</style>
</head>
<body>
<div class="card card-pad" style="max-width:420px;text-align:center;">
	<div class="alert-ic" style="background:var(--red-soft);color:var(--red);margin:0 auto 16px;width:56px;height:56px;"><?= ic('alert',26) ?></div>
	<h2 style="margin:0 0 8px;font-size:19px;">Link Tidak Dapat Diakses</h2>
	<p class="muted" style="font-size:13.5px;line-height:1.6;"><?= $message ?></p>
</div>
</body>
</html>
