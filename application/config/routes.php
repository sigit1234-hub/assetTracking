<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'dashboard';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

/* Auth */
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';

/* TTD Digital (publik, tanpa login) */
$route['ttd/simpan'] = 'sign/submit';
$route['ttd/(:any)/(:any)'] = 'sign/pad/$1/$2';

/* Data Laptop */
$route['laptop'] = 'laptop/index';
$route['laptop/tambah'] = 'laptop/create';
$route['laptop/edit/(:num)'] = 'laptop/edit/$1';
$route['laptop/detail/(:num)'] = 'laptop/detail/$1';
$route['laptop/hapus/(:num)'] = 'laptop/delete/$1';
$route['laptop/import'] = 'laptop/import';
$route['laptop/template'] = 'laptop/download_template';
$route['laptop/kategori'] = 'laptop/categories';
$route['laptop/merk'] = 'laptop/brands';
$route['laptop/label/(:num)'] = 'laptop/label/$1';
$route['laptop/label-bulk'] = 'laptop/label_bulk';

/* Data Pekerja */
$route['pekerja'] = 'employee/index';
$route['pekerja/tambah'] = 'employee/create';
$route['pekerja/edit/(:num)'] = 'employee/edit/$1';
$route['pekerja/hapus/(:num)'] = 'employee/delete/$1';
$route['pekerja/import'] = 'employee/import';
$route['pekerja/template'] = 'employee/download_template';

/* Penggunaan */
$route['penggunaan'] = 'usage/index';
$route['penggunaan/riwayat'] = 'usage/history';
$route['penggunaan/pengembalian'] = 'usage/return_form';
$route['penggunaan/proses-pengembalian'] = 'usage/process_return';

/* BAST */
$route['bast'] = 'bast/index';
$route['bast/pengembalian'] = 'bast/returns';
$route['bast/buat'] = 'bast/create';
$route['bast/simpan-step1'] = 'bast/save_step1';
$route['bast/simpan-step2'] = 'bast/save_step2';
$route['bast/simpan-step3'] = 'bast/save_step3';
$route['bast/finalisasi'] = 'bast/finalize';
$route['bast/preview/(:num)'] = 'bast/preview/$1';
$route['bast/detail/(:num)'] = 'bast/detail/$1';
$route['bast/pdf/(:num)'] = 'bast/pdf/$1';
$route['bast/token-ulang/(:num)/(:any)'] = 'bast/regenerate_token/$1/$2';
$route['bast/kirim-ttd/(:num)'] = 'bast/send_for_signature/$1';
$route['bast/kirim-email/(:num)'] = 'bast/send_email/$1';
$route['bast/ttd-admin/(:num)'] = 'bast/sign_admin_page/$1';
$route['bast/ttd-admin/simpan/(:num)'] = 'bast/sign_admin_submit/$1';
$route['bast/batalkan/(:num)'] = 'bast/cancel/$1';
$route['bast/template'] = 'bast/templates';
$route['bast/template/lihat/(:any)'] = 'bast/template_preview/$1';
$route['bast/template/edit/(:any)'] = 'bast/template_edit/$1';

/* Maintenance */
$route['maintenance'] = 'maintenance/index';
$route['maintenance/riwayat'] = 'maintenance/history';
$route['maintenance/tambah'] = 'maintenance/create';
$route['maintenance/selesai/(:num)'] = 'maintenance/complete/$1';

/* Laporan */
$route['laporan'] = 'report/index';
$route['laporan/export/(:any)'] = 'report/export/$1';

/* Notifikasi & Pengaturan */
$route['notifikasi'] = 'notification/index';
$route['notifikasi/baca/(:num)'] = 'notification/mark_read/$1';
$route['pengaturan'] = 'settings/index';
