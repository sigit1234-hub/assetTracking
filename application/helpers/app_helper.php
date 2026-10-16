<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('format_rupiah'))
{
	function format_rupiah($angka)
	{
		if ($angka === NULL || $angka === '') return '-';
		return 'Rp ' . number_format((float) $angka, 0, ',', '.');
	}
}

if ( ! function_exists('format_tanggal'))
{
	function format_tanggal($tanggal, $with_time = FALSE)
	{
		if (empty($tanggal) || $tanggal === '0000-00-00') return '-';
		$bulan = ['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun',
				  '07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'];
		$ts = strtotime($tanggal);
		$out = date('d', $ts) . ' ' . $bulan[date('m', $ts)] . ' ' . date('Y', $ts);
		if ($with_time) $out .= ', ' . date('H:i', $ts);
		return $out;
	}
}

if ( ! function_exists('time_ago'))
{
	function time_ago($datetime)
	{
		$diff = time() - strtotime($datetime);
		if ($diff < 60)    return 'baru saja';
		if ($diff < 3600)  return floor($diff / 60) . ' menit lalu';
		if ($diff < 86400) return floor($diff / 3600) . ' jam lalu';
		if ($diff < 172800) return 'kemarin';
		return floor($diff / 86400) . ' hari lalu';
	}
}

if ( ! function_exists('generate_bast_number'))
{
	/**
	 * Format nomor BAST: BAST/IT/{tahun}/{urutan 3 digit}
	 */
	function generate_bast_number($last_sequence = 0)
	{
		$year = date('Y');
		$seq  = str_pad($last_sequence + 1, 3, '0', STR_PAD_LEFT);
		return "BAST/IT/{$year}/{$seq}";
	}
}

if ( ! function_exists('generate_asset_id'))
{
	/**
	 * Format Asset ID: CIS-{nomor_urut}/AST-L/{tahun_pengadaan}
	 * Contoh: CIS-151/AST-L/2019
	 */
	function generate_asset_id($last_sequence = 0, $purchase_year = NULL)
	{
		$seq = $last_sequence + 1;
		$year = $purchase_year ?: date('Y');
		return "CIS-{$seq}/AST-L/{$year}";
	}
}

if ( ! function_exists('days_left'))
{
	function days_left($date)
	{
		if (empty($date)) return NULL;
		$diff = (strtotime($date) - strtotime(date('Y-m-d'))) / 86400;
		return (int) $diff;
	}
}

if ( ! function_exists('initials'))
{
	function initials($name)
	{
		$parts = explode(' ', trim($name));
		$out = '';
		foreach (array_slice($parts, 0, 2) as $p) $out .= strtoupper(substr($p, 0, 1));
		return $out ?: '??';
	}
}

if ( ! function_exists('current_url_is'))
{
	/**
	 * Cek apakah URI saat ini cocok dengan path tertentu (untuk highlight menu aktif).
	 */
	function current_url_is($path)
	{
		$ci =& get_instance();
		$uri = trim($ci->uri->uri_string(), '/');

		// Path yang mengandung query string (contoh: 'bast/buat?mode=sementara')
		// dicocokkan terhadap URI + $_GET saat ini, bukan cuma URI segmen.
		if (strpos($path, '?') !== FALSE)
		{
			list($pathOnly, $queryStr) = explode('?', $path, 2);
			parse_str($queryStr, $expectedGet);
			if ($uri !== trim($pathOnly, '/')) return FALSE;
			foreach ($expectedGet as $k => $v)
			{
				if ( ! isset($_GET[$k]) || $_GET[$k] !== $v) return FALSE;
			}
			return TRUE;
		}

		$path = trim($path, '/');
		return $uri === $path;
	}
}

if ( ! function_exists('pdf_local_file_uri'))
{
	/**
	 * Konversi path relatif (dari webroot) menjadi URI 'file://' yang valid
	 * untuk dompdf. WAJIB dipakai untuk menampilkan gambar lokal (tanda tangan,
	 * logo, dsb) di dalam PDF — dompdf tidak bisa membaca path absolut biasa
	 * di Windows (contoh: C:/laragon/...) tanpa prefix ini, khususnya karena
	 * drive letter Windows (C:) disalahartikan sebagai bagian URL biasa.
	 */
	function pdf_local_file_uri($relative_path)
	{
		if (empty($relative_path)) return '';
		$full = FCPATH . $relative_path;
		$full = str_replace('\\', '/', $full); // normalisasi backslash Windows
		return 'file://' . $full;
	}
}
{
	/**
	 * Icon helper — kumpulan ikon garis (stroke) sederhana, dipakai konsisten
	 * di seluruh tampilan tanpa bergantung pada CDN ikon eksternal.
	 */
	function ic($name, $size = 17)
	{
		$paths = [
			'dashboard'=>'<rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/>',
			'laptop'=>'<rect x="3" y="4" width="18" height="12" rx="2"/><path d="M2 20h20"/>',
			'users'=>'<circle cx="9" cy="8" r="3.2"/><path d="M2.5 20c0-4 3-6.5 6.5-6.5S15.5 16 15.5 20"/><circle cx="17.5" cy="9" r="2.6"/><path d="M22 20c0-3-1.7-5.3-4.2-5.9"/>',
			'filesig'=>'<path d="M6 3h9l5 5v13H6z"/><path d="M15 3v5h5"/><path d="M8.5 15.5s1-1.2 2-1.2 1.2 1.2 2.2 1.2 2-1.2 2-1.2"/>',
			'wrench'=>'<path d="M14.7 6.3a4 4 0 1 0-5.4 5.4L3 18l3 3 6.3-6.3a4 4 0 0 0 5.4-5.4l-3 3-2-2 3-3z"/>',
			'chart'=>'<path d="M4 19V10M11 19V5M18 19v-7"/><path d="M2 19h20"/>',
			'settings'=>'<circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.9l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.9-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 1 1-4 0v-.1a1.7 1.7 0 0 0-1-1.6 1.7 1.7 0 0 0-1.9.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.9 1.7 1.7 0 0 0-1.5-1H3a2 2 0 1 1 0-4h.1a1.7 1.7 0 0 0 1.6-1 1.7 1.7 0 0 0-.3-1.9l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.9.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 1 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.9-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.9V9c.2.7.7 1.2 1.5 1.3H21a2 2 0 1 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1z"/>',
			'search'=>'<circle cx="11" cy="11" r="7"/><path d="M21 21l-4-4"/>',
			'bell'=>'<path d="M18 8a6 6 0 0 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/>',
			'plus'=>'<path d="M12 5v14M5 12h14"/>',
			'filter'=>'<path d="M4 4h16l-6.5 8v6l-3 2v-8z"/>',
			'download'=>'<path d="M12 3v13m0 0l-4-4m4 4l4-4"/><path d="M4 20h16"/>',
			'upload'=>'<path d="M12 21V8m0 0l-4 4m4-4l4 4"/><path d="M4 20h16"/>',
			'eye'=>'<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>',
			'edit'=>'<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
			'check'=>'<path d="M20 6L9 17l-5-5"/>',
			'x'=>'<path d="M18 6L6 18M6 6l12 12"/>',
			'arrowRight'=>'<path d="M5 12h14M13 6l6 6-6 6"/>',
			'clock'=>'<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/>',
			'alert'=>'<path d="M12 3L2 20h20L12 3z"/><path d="M12 10v4"/><path d="M12 17h.01"/>',
			'file'=>'<path d="M6 3h9l5 5v13H6z"/><path d="M15 3v5h5"/>',
			'box'=>'<path d="M21 8l-9-5-9 5 9 5 9-5z"/><path d="M3 8v8l9 5 9-5V8"/><path d="M12 13v8"/>',
			'swap'=>'<path d="M7 3l4 4-4 4"/><path d="M20 7H11"/><path d="M17 21l-4-4 4-4"/><path d="M4 17h9"/>',
			'qr'=>'<rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><path d="M14 14h3v3h-3zM20 14h1v1h-1zM14 20h1v1h-1zM17 17h1v1h-1zM20 20h1v1h-1z"/>',
			'camera'=>'<path d="M4 8h3l2-3h6l2 3h3v12H4z"/><circle cx="12" cy="14" r="3.5"/>',
			'mail'=>'<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
			'printer'=>'<path d="M6 9V3h12v6"/><rect x="4" y="9" width="16" height="8" rx="1"/><path d="M6 17h12v4H6z"/>',
			'logout'=>'<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
			'chev'=>'<path d="M9 6l6 6-6 6"/>',
			'refresh'=>'<path d="M21 12a9 9 0 1 1-3-6.7"/><path d="M21 3v6h-6"/>',
			'user'=>'<circle cx="12" cy="8" r="4"/><path d="M4 21c0-4.4 3.6-7 8-7s8 2.6 8 7"/>',
			'menu'=>'<path d="M3 6h18M3 12h18M3 18h18"/>',
		];
		$body = isset($paths[$name]) ? $paths[$name] : '';
		return '<svg width="'.$size.'" height="'.$size.'" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round">'.$body.'</svg>';
	}
}
