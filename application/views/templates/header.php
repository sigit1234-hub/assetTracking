<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($page_title) ? $page_title.' — AssetTrack' : 'AssetTrack'; ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.4/chart.umd.min.js"></script>
</head>
<body<?php if ($this->session->flashdata('toast')): ?> data-toast="<?php echo htmlspecialchars($this->session->flashdata('toast')); ?>"<?php endif; ?>>
<div id="toast-wrap"></div>
<div id="app">
