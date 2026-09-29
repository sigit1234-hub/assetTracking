<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Autoloader manual (tanpa Composer) untuk dompdf beserta dependensinya.
 * Dipakai oleh Bast::pdf() untuk menghasilkan file PDF BAST sungguhan.
 *
 * Sumber pustaka (diunduh langsung dari GitHub resmi masing-masing proyek):
 * - dompdf/dompdf            v2.0.4
 * - phenx/php-font-lib
 * - phenx/php-svg-lib
 * - sabberworm/php-css-parser
 * - masterminds/html5
 */

$__pdf_lib_base = __DIR__;

$__pdf_namespace_map = [
	'Dompdf\\'         => $__pdf_lib_base . '/dompdf/src/',
	'FontLib\\'        => $__pdf_lib_base . '/font-lib/src/FontLib/',
	'Svg\\'            => $__pdf_lib_base . '/svg-lib/src/Svg/',
	'Sabberworm\\CSS\\' => $__pdf_lib_base . '/css-parser/src/',
	'Masterminds\\'    => $__pdf_lib_base . '/html5-php/src/',
];

spl_autoload_register(function ($class) use ($__pdf_namespace_map) {
	foreach ($__pdf_namespace_map as $prefix => $dir) {
		if (strncmp($class, $prefix, strlen($prefix)) === 0) {
			$relative = substr($class, strlen($prefix));
			$file = $dir . str_replace('\\', '/', $relative) . '.php';
			if (is_file($file)) {
				require_once $file;
				return;
			}
		}
	}
});

// Cpdf.php adalah kelas global (bukan namespaced) yang di-classmap oleh dompdf
require_once $__pdf_lib_base . '/dompdf/lib/Cpdf.php';
