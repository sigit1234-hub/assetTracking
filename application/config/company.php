<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Identitas perusahaan & default dokumen BAST.
 * Ubah nilai di bawah ini sesuai kebutuhan instansi Anda.
 */
$config['company_name']        = 'PT Bank Rakyat Indonesia';
$config['company_division']    = 'CISO Office Group';
$config['default_approver_name'] = 'Nanang Andri Hidayat';
$config['default_approver_role'] = 'Group Head';

/**
 * Alamat pengirim email notifikasi BAST.
 * Konfigurasi SMTP sesungguhnya ada di application/config/email.php
 *
 * PENTING: kalau memakai Gmail SMTP, isi 'email_from_address' dengan
 * alamat Gmail YANG SAMA dengan $config['smtp_user'] di email.php.
 * Gmail akan menolak atau menandai "via gmail.com" kalau alamat
 * pengirim berbeda dari akun yang dipakai login SMTP.
 */
$config['email_from_address'] = 'alamat-gmail-anda@gmail.com';
$config['email_from_name']    = 'AssetTrack — CISO Office Group';
