<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * =====================================================================
 * KONFIGURASI SMTP — GMAIL
 * =====================================================================
 * Gmail TIDAK BISA dipakai dengan password akun biasa untuk SMTP.
 * Anda WAJIB membuat "App Password" (Kata Sandi Aplikasi) terlebih dahulu.
 *
 * LANGKAH MEMBUAT APP PASSWORD:
 * 1. Aktifkan verifikasi 2 langkah dulu di akun Google Anda:
 *    https://myaccount.google.com/security  →  "Verifikasi 2 Langkah"  →  Aktifkan
 *    (App Password TIDAK MUNCUL kalau verifikasi 2 langkah belum aktif)
 *
 * 2. Buka halaman App Password:
 *    https://myaccount.google.com/apppasswords
 *
 * 3. Pilih aplikasi "Mail", pilih perangkat "Other (Custom name)",
 *    ketik misalnya "AssetTrack", lalu klik Generate.
 *
 * 4. Google akan menampilkan 16 karakter kode (contoh: abcd efgh ijkl mnop).
 *    Salin kode ini (boleh dengan atau tanpa spasi) dan tempel ke
 *    $config['smtp_pass'] di bawah — BUKAN password Gmail biasa Anda.
 *
 * 5. Isi $config['smtp_user'] dan $config['email_from_address'] di
 *    application/config/company.php dengan alamat Gmail yang sama.
 *
 * CATATAN:
 * - Kalau pakai akun Google Workspace (email kantor via Google), caranya
 *   sama, dengan syarat Admin Google Workspace mengizinkan App Password
 *   untuk akun tersebut (Admin Console → Security → App access control).
 * - Gmail membatasi ±500 email/hari untuk akun biasa. Untuk kebutuhan
 *   volume tinggi/production sungguhan, pertimbangkan layanan khusus
 *   seperti SendGrid, Mailgun, Amazon SES, dsb (cukup ganti nilai di
 *   bawah, struktur konfigurasinya sama).
 * =====================================================================
 */

$config['protocol']    = 'smtp';
$config['smtp_host']   = 'smtp.gmail.com';
$config['smtp_user']   = 'alamat-gmail-anda@gmail.com';   // <-- ganti dengan email Gmail pengirim
$config['smtp_pass']   = 'xxxx xxxx xxxx xxxx';            // <-- ganti dengan App Password 16 digit (bukan password biasa)
$config['smtp_port']   = 465;
$config['smtp_crypto'] = 'ssl';
$config['smtp_timeout']= 30;
$config['mailtype']    = 'html';
$config['charset']     = 'utf-8';
$config['newline']     = "\r\n";
$config['wordwrap']    = TRUE;

/**
 * Alternatif: jika port 465 (SSL) diblokir oleh firewall/hosting Anda,
 * coba gunakan port 587 dengan TLS sebagai gantinya:
 *
 * $config['smtp_host']   = 'smtp.gmail.com';   // TANPA prefix tls:// atau ssl://
 * $config['smtp_port']   = 587;
 * $config['smtp_crypto'] = 'tls';
 *
 * PENTING: jangan tulis 'ssl://' atau 'tls://' di depan smtp_host —
 * CodeIgniter menambahkannya otomatis berdasarkan smtp_crypto. Kalau
 * ditulis manual di smtp_host, hasilnya jadi dobel (ssl://ssl://...)
 * dan koneksi akan GAGAL total.
 */
