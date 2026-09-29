document.addEventListener('DOMContentLoaded', function () {

	/* ---------- Sidebar submenu toggle ---------- */
	document.querySelectorAll('[data-toggle-submenu]').forEach(function (el) {
		el.addEventListener('click', function () {
			var key = el.getAttribute('data-toggle-submenu');
			var sub = document.getElementById('submenu-' + key);
			var isOpen = sub.classList.contains('open');
			document.querySelectorAll('.submenu.open').forEach(function (s) { s.classList.remove('open'); });
			document.querySelectorAll('.nav-item.parent-open').forEach(function (s) { s.classList.remove('parent-open'); });
			if (!isOpen) { sub.classList.add('open'); el.classList.add('parent-open'); }
		});
	});

	/* ---------- Mobile sidebar ---------- */
	var menuToggle = document.getElementById('menu-toggle');
	if (menuToggle) {
		menuToggle.addEventListener('click', function () {
			document.getElementById('sidebar').classList.toggle('mobile-open');
		});
	}

	/* ---------- Profile dropdown ---------- */
	var profileChip = document.getElementById('profile-chip');
	if (profileChip) {
		profileChip.addEventListener('click', function (e) {
			e.stopPropagation();
			document.getElementById('profile-menu').classList.toggle('open');
		});
		document.addEventListener('click', function () {
			document.getElementById('profile-menu').classList.remove('open');
		});
	}

	/* ---------- Tabs ---------- */
	document.querySelectorAll('[data-tab-group]').forEach(function (group) {
		var groupName = group.getAttribute('data-tab-group');
		group.querySelectorAll('.tab').forEach(function (tab) {
			tab.addEventListener('click', function () {
				group.querySelectorAll('.tab').forEach(function (t) { t.classList.remove('active'); });
				tab.classList.add('active');
				var key = tab.getAttribute('data-tab');
				document.querySelectorAll('[data-tab-panel-group="' + groupName + '"]').forEach(function (p) {
					p.classList.toggle('active', p.getAttribute('data-tab-panel') === key);
				});
			});
		});
	});

	/* ---------- Confirm modal (data-confirm) ---------- */
	document.querySelectorAll('[data-confirm]').forEach(function (el) {
		el.addEventListener('click', function (e) {
			e.preventDefault();
			var title = el.getAttribute('data-confirm-title') || 'Konfirmasi Tindakan';
			var desc = el.getAttribute('data-confirm') || 'Apakah Anda yakin?';
			var okLabel = el.getAttribute('data-confirm-ok') || 'Ya, Lanjutkan';
			var href = el.getAttribute('href') || (el.closest('form') ? null : null);

			var overlay = document.createElement('div');
			overlay.className = 'modal-overlay';
			overlay.innerHTML =
				'<div class="modal-box">' +
				'<div class="modal-ic">' + icon('alert', 20) + '</div>' +
				'<h3>' + title + '</h3><p>' + desc + '</p>' +
				'<div class="btn-row" style="justify-content:flex-end;">' +
				'<button type="button" class="btn btn-ghost" id="modal-cancel">Batal</button>' +
				'<button type="button" class="btn" style="background:var(--red);color:#fff;" id="modal-ok">' + okLabel + '</button>' +
				'</div></div>';
			document.body.appendChild(overlay);
			overlay.querySelector('#modal-cancel').onclick = function () { overlay.remove(); };
			overlay.querySelector('#modal-ok').onclick = function () {
				overlay.remove();
				if (el.tagName === 'A') { window.location.href = href; }
				else if (el.closest('form')) { el.closest('form').submit(); }
			};
		});
	});

	/* ---------- Toast from flashdata ---------- */
	var toastMsg = document.body.getAttribute('data-toast');
	if (toastMsg) { showToast(toastMsg); }

	/* ---------- Segmented control label active state (fallback for :has()) ---------- */
	document.querySelectorAll('.seg').forEach(function (seg) {
		seg.querySelectorAll('input').forEach(function (inp) {
			inp.addEventListener('change', function () {
				seg.querySelectorAll('label').forEach(function (l) { l.style.background = '#fff'; l.style.color = 'var(--ink-soft)'; });
				var lbl = inp.closest('label');
				var val = inp.value;
				var colors = {
					lengkap: ['var(--green-soft)', 'var(--green)'],
					baik: ['var(--green-soft)', 'var(--green)'],
					tidak_lengkap: ['var(--amber-soft)', 'var(--amber)'],
					ada_kerusakan: ['var(--amber-soft)', 'var(--amber)'],
					tidak_ada: ['var(--red-soft)', 'var(--red)'],
					perlu_maintenance: ['var(--red-soft)', 'var(--red)']
				};
				if (colors[val]) { lbl.style.background = colors[val][0]; lbl.style.color = colors[val][1]; }
			});
			if (inp.checked) inp.dispatchEvent(new Event('change'));
		});
	});

	/* ---------- Laptop picker cards (wizard step 1) ---------- */
	document.querySelectorAll('#laptop-pick-grid input[type=radio]').forEach(function (radio) {
		radio.addEventListener('change', function () {
			document.querySelectorAll('.pick-card').forEach(function (c) { c.classList.remove('selected'); });
			radio.closest('.pick-card').classList.add('selected');
			var submitBtn = document.getElementById('wizard-next-btn');
			if (submitBtn) submitBtn.removeAttribute('disabled');
		});
	});

	/* Employee source toggle (wizard step 2) is now handled inline in bast/create.php,
	   since the picker changed from a <select> to a searchable radio list. */
});

function icon(name, size) {
	size = size || 17;
	var I = {
		alert: '<path d="M12 3L2 20h20L12 3z"/><path d="M12 10v4"/><path d="M12 17h.01"/>',
		check: '<path d="M20 6L9 17l-5-5"/>'
	};
	return '<svg width="' + size + '" height="' + size + '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">' + (I[name] || '') + '</svg>';
}

function showToast(msg) {
	var wrap = document.getElementById('toast-wrap');
	if (!wrap) return;
	var el = document.createElement('div');
	el.className = 'toast';
	el.innerHTML = icon('check', 16) + '<span>' + msg + '</span>';
	wrap.appendChild(el);
	setTimeout(function () {
		el.style.opacity = '0'; el.style.transform = 'translateX(30px)'; el.style.transition = '.25s';
		setTimeout(function () { el.remove(); }, 250);
	}, 3200);
}

function copyLink(url, btn) {
	function done() {
		var original = btn.innerHTML;
		btn.innerHTML = '✓ Tersalin';
		setTimeout(function () { btn.innerHTML = original; }, 1800);
	}
	if (navigator.clipboard && navigator.clipboard.writeText) {
		navigator.clipboard.writeText(url).then(done).catch(function () { prompt('Salin link berikut:', url); });
	} else {
		prompt('Salin link berikut:', url);
	}
}
