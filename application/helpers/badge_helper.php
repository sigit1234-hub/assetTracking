<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('status_badge'))
{
	/**
	 * Mengembalikan HTML badge status berwarna konsisten.
	 * Dipakai di tabel laptop, BAST, maintenance, dsb.
	 */
	function status_badge($status)
	{
		$map = [
			'tersedia'             => ['b-green', 'Tersedia'],
			'digunakan'            => ['b-blue',  'Sedang Digunakan'],
			'maintenance'          => ['b-amber', 'Dalam Perbaikan'],
			'dipinjamkan'          => ['b-purple','Dipinjamkan'],
			'dikembalikan'         => ['b-teal',  'Dikembalikan'],
			'rusak'                => ['b-red',   'Rusak'],
			'nonaktif'             => ['b-slate', 'Tidak Aktif'],
			'aktif'                => ['b-green', 'Aktif'],
			'menunggu'             => ['b-amber', 'Menunggu TTD'],
			'selesai'              => ['b-slate', 'Selesai'],
			'dibatalkan'           => ['b-red',   'Dibatalkan'],
			'draft'                => ['b-slate', 'Draft'],
			'proses'               => ['b-amber', 'Proses Perbaikan'],
			'menunggu-sparepart'   => ['b-red',   'Menunggu Sparepart'],
			'overdue'              => ['b-red',   'Overdue'],
			'lengkap'              => ['b-green', 'Lengkap'],
			'tidak_lengkap'        => ['b-amber', 'Tidak Lengkap'],
			'tidak_ada'            => ['b-red',   'Tidak Ada'],
			'baik'                 => ['b-green', 'Baik'],
			'ada_kerusakan'        => ['b-amber', 'Ada Kerusakan'],
			'perlu_maintenance'    => ['b-red',   'Perlu Maintenance'],
		];
		$item = isset($map[$status]) ? $map[$status] : ['b-slate', ucfirst($status)];
		return '<span class="badge ' . $item[0] . '"><span class="bdot"></span>' . $item[1] . '</span>';
	}

	function status_label($status)
	{
		$map = [
			'tersedia'=>'Tersedia','digunakan'=>'Sedang Digunakan','maintenance'=>'Dalam Perbaikan',
			'dipinjamkan'=>'Dipinjamkan','dikembalikan'=>'Dikembalikan','rusak'=>'Rusak','nonaktif'=>'Tidak Aktif',
			'aktif'=>'Aktif','menunggu'=>'Menunggu TTD','selesai'=>'Selesai','dibatalkan'=>'Dibatalkan','draft'=>'Draft',
		];
		return isset($map[$status]) ? $map[$status] : ucfirst($status);
	}
}
