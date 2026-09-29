<div class="page-head">
	<div><h1 class="page-title">Pusat Notifikasi</h1><p class="page-sub">Semua pembaruan penting mengenai aset, BAST, dan maintenance.</p></div>
	<div class="btn-row"><a href="<?= site_url('notifikasi') ?>" class="btn btn-ghost"><?= ic('check',15) ?> Tandai Semua Dibaca</a></div>
</div>
<div class="card">
	<?php if (empty($items)): ?>
		<div class="empty-state"><div class="empty-ic"><?= ic('bell',22) ?></div><p>Belum ada notifikasi.</p></div>
	<?php else: $n = count($items); foreach ($items as $i => $notif):
		$colorMap = ['bast'=>'blue','warning'=>'amber','maintenance'=>'red','success'=>'green','info'=>'slate'];
		$iconMap  = ['bast'=>'filesig','warning'=>'alert','maintenance'=>'wrench','success'=>'box','info'=>'bell'];
		$color = $colorMap[$notif['type']] ?? 'slate';
		$colors=['blue'=>['var(--primary-soft)','var(--primary)'],'amber'=>['var(--amber-soft)','var(--amber)'],'red'=>['var(--red-soft)','var(--red)'],'green'=>['var(--green-soft)','var(--green)'],'slate'=>['var(--slate-soft)','var(--slate)']];
		$c = $colors[$color];
	?>
	<div style="display:flex;gap:14px;padding:16px 18px;<?= $i < $n-1 ? 'border-bottom:1px solid var(--border-soft);' : '' ?>">
		<div class="alert-ic" style="background:<?= $c[0] ?>;color:<?= $c[1] ?>;flex-shrink:0;"><?= ic($iconMap[$notif['type']] ?? 'bell',17) ?></div>
		<div style="flex:1;">
			<div class="alert-title"><?= $notif['title'] ?></div>
			<div class="alert-desc"><?= $notif['description'] ?></div>
		</div>
		<div class="cell-sub" style="white-space:nowrap;"><?= time_ago($notif['created_at']) ?></div>
	</div>
	<?php endforeach; endif; ?>
</div>
