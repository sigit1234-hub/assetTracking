/**
 * SignaturePad — signature capture sederhana berbasis HTML5 canvas.
 * Mendukung mouse (desktop) dan touch (mobile/tablet).
 *
 * Pemakaian:
 *   var pad = new SignaturePad(document.getElementById('sig-canvas'));
 *   pad.clear();
 *   var isEmpty = pad.isEmpty();
 *   var dataUrl = pad.toDataURL(); // 'data:image/png;base64,...'
 */
function SignaturePad(canvas) {
	var ctx = canvas.getContext('2d');
	var drawing = false;
	var hasContent = false;
	var lastX = 0, lastY = 0;

	function resize() {
		var ratio = Math.max(window.devicePixelRatio || 1, 1);
		var rect = canvas.getBoundingClientRect();
		canvas.width = rect.width * ratio;
		canvas.height = rect.height * ratio;
		ctx.scale(ratio, ratio);
		ctx.lineWidth = 2.4;
		ctx.lineCap = 'round';
		ctx.lineJoin = 'round';
		ctx.strokeStyle = '#0F2138';
	}
	resize();
	window.addEventListener('resize', resize);

	function getPos(e) {
		var rect = canvas.getBoundingClientRect();
		var clientX = e.touches ? e.touches[0].clientX : e.clientX;
		var clientY = e.touches ? e.touches[0].clientY : e.clientY;
		return { x: clientX - rect.left, y: clientY - rect.top };
	}

	function start(e) {
		e.preventDefault();
		drawing = true;
		hasContent = true;
		var p = getPos(e);
		lastX = p.x; lastY = p.y;
	}
	function move(e) {
		if (!drawing) return;
		e.preventDefault();
		var p = getPos(e);
		ctx.beginPath();
		ctx.moveTo(lastX, lastY);
		ctx.lineTo(p.x, p.y);
		ctx.stroke();
		lastX = p.x; lastY = p.y;
	}
	function end() { drawing = false; }

	canvas.addEventListener('mousedown', start);
	canvas.addEventListener('mousemove', move);
	window.addEventListener('mouseup', end);
	canvas.addEventListener('touchstart', start, { passive: false });
	canvas.addEventListener('touchmove', move, { passive: false });
	canvas.addEventListener('touchend', end);

	this.clear = function () {
		ctx.clearRect(0, 0, canvas.width, canvas.height);
		hasContent = false;
	};
	this.isEmpty = function () { return !hasContent; };
	this.toDataURL = function () { return canvas.toDataURL('image/png'); };
}
