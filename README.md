# AssetTrack — Sistem Tracking Laptop & Manajemen BAST

Aplikasi web untuk mendata aset laptop perusahaan, melacak penggunaannya, dan
mengelola dokumen **BAST (Berita Acara Serah Terima)** secara digital.

Dibangun dengan:
- **Framework:** CodeIgniter 3.1.13 (PHP, MVC)
- **Database:** MySQL / MariaDB
- **Frontend:** HTML + CSS custom (tanpa dependency build tools) + Chart.js (CDN) untuk grafik

---

## 1. Kebutuhan Server

- PHP **7.4 – 8.3** dengan ekstensi: `mysqli`, `mbstring`, `json`, `session`
- MySQL 5.7+ atau MariaDB 10.3+
- Web server: Apache (dengan `mod_rewrite`) / Nginx, atau cukup `php -S` untuk uji coba lokal

---

## 2. Instalasi

### a) Salin project
Ekstrak seluruh isi folder ini ke direktori web server Anda, misalnya:
```
htdocs/assettrack/        (XAMPP/Laragon)
/var/www/html/assettrack/ (Linux)
```

### b) Buat database
Import file `database/assettrack.sql` melalui phpMyAdmin, atau via terminal:
```bash
mysql -u root -p < database/assettrack.sql
```
Script ini akan otomatis:
- Membuat database `assettrack`
- Membuat seluruh tabel (laptops, bast, laptop_usage, maintenance, employees, dsb.)
- Mengisi data contoh (10 laptop, 7 dokumen BAST, 8 karyawan, dll.)

### c) Konfigurasi koneksi database
Edit `application/config/database.php` sesuai kredensial MySQL Anda:
```php
$db['default'] = array(
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'assettrack',
    'dbdriver' => 'mysqli',
    ...
);
```

### d) Atur base URL
Edit `application/config/config.php`:
```php
$config['base_url'] = 'http://localhost/assettrack/';
```
Sesuaikan dengan URL akses aplikasi Anda.

### e) (Opsional) Aktifkan pretty URL dengan .htaccess
File `.htaccess` di folder root sudah disediakan agar URL tidak perlu
`index.php` (contoh: `/assettrack/dashboard` bukan `/assettrack/index.php/dashboard`).
Pastikan `mod_rewrite` aktif di Apache.

### f) Jalankan
- **Apache/XAMPP/Laragon:** buka `http://localhost/assettrack/`
- **PHP built-in server (uji cepat):**
  ```bash
  cd assettrack
  php -S localhost:8080
  ```
  lalu buka `http://localhost:8080/`

---

## 3. Login Demo

| Email                                   | Password      | Role         |
|------------------------------------------|---------------|--------------|
| admin.it@nusantaradigital.co.id           | password123   | Super Admin  |
| nadia.putri@nusantaradigital.co.id        | password123   | Admin        |

---

## 3b. Konfigurasi Email (Gmail SMTP)

Fitur "Kirim Email" pada BAST bersifat **opsional** — sistem tetap berjalan
normal walau belum dikonfigurasi. Untuk mengaktifkannya dengan Gmail:

1. Aktifkan verifikasi 2 langkah di akun Google: https://myaccount.google.com/security
2. Buat App Password di: https://myaccount.google.com/apppasswords
   (pilih aplikasi "Mail", perangkat "Other", beri nama misalnya "AssetTrack")
3. Salin kode 16 digit yang muncul, lalu edit dua file berikut:

   **`application/config/email.php`**
   ```php
   $config['smtp_user'] = 'alamat-gmail-anda@gmail.com';
   $config['smtp_pass'] = 'xxxx xxxx xxxx xxxx'; // App Password, bukan password Gmail biasa
   ```

   **`application/config/company.php`**
   ```php
   $config['email_from_address'] = 'alamat-gmail-anda@gmail.com'; // harus sama dengan smtp_user
   ```

Kalau port 465 (SSL) diblokir oleh hosting Anda, ganti ke port 587 (TLS) —
detail alternatifnya sudah ada sebagai komentar di `email.php`.

---

## 4. Struktur Fitur

| Modul                  | URL                          | Keterangan                                             |
|-------------------------|-------------------------------|---------------------------------------------------------|
| Dashboard                | `/dashboard`                  | Ringkasan aset, grafik, alert "Perlu Perhatian"          |
| Data Laptop               | `/laptop`                     | CRUD aset, filter, import, kategori & merk               |
| Penggunaan Laptop          | `/penggunaan`                  | Monitoring laptop aktif/dipinjam, riwayat, pengembalian    |
| BAST                     | `/bast`                        | Daftar, wizard pembuatan 4 langkah, preview dokumen, detail |
| Maintenance                | `/maintenance`                  | Laptop dalam perbaikan & riwayat servis                  |
| Laporan                  | `/laporan`                      | Analytics & grafik ringkasan                             |
| Notifikasi                | `/notifikasi`                    | Pusat notifikasi sistem                                  |
| Pengaturan                | `/pengaturan`                    | Profil admin & preferensi sistem                          |

### Alur BAST (inti sistem)
1. **Pilih Laptop** — hanya laptop berstatus *Tersedia*/*Digunakan* yang tampil.
2. **Data Penerima** — pilih karyawan yang sudah ada, atau tambah baru langsung dari form.
3. **Detail Serah Terima** — tanggal, lokasi, keperluan, checklist kelengkapan (charger, mouse, tas, dsb).
4. **Preview & Finalisasi** — dokumen resmi ditampilkan lengkap dengan area tanda tangan.
   Admin bisa **Simpan Draft**, **Generate PDF**, atau **Kirim untuk Tanda Tangan**.
   Saat difinalisasi, sistem otomatis: membuat nomor BAST (`BAST/IT/{tahun}/{urutan}`),
   mengubah status laptop menjadi *Digunakan*/*Dipinjamkan*, dan mencatat sesi penggunaan baru.

### Alur Pengembalian
Saat laptop dikembalikan melalui `/penggunaan/pengembalian`, sistem otomatis:
- Menutup sesi penggunaan aktif di `laptop_usage`
- Mengubah status laptop menjadi *Tersedia* atau *Maintenance* (tergantung kondisi checklist)
- Mengubah status BAST terkait menjadi *Selesai*

---

## 5. Struktur Folder

```
assettrack/
├── application/
│   ├── config/          → database.php, routes.php, autoload.php, config.php
│   ├── controllers/     → Auth, Dashboard, Laptop, Usage, Bast, Maintenance, Report, Notification, Settings
│   ├── models/          → Laptop_model, Bast_model, Usage_model, Maintenance_model, dll.
│   ├── views/           → templates/ (header,sidebar,topbar,footer) + view per modul
│   ├── helpers/         → app_helper.php (format, ikon SVG, nomor BAST), badge_helper.php (status badge)
│   └── core/             → MY_Controller.php (auth guard + render template)
├── system/               → Core framework CodeIgniter 3.1.13 (jangan diubah)
├── assets/
│   ├── css/style.css     → Design system (warna, tipografi, komponen)
│   └── js/app.js          → Interaksi sidebar, tab, modal, toast
├── database/
│   └── assettrack.sql     → Schema + seed data lengkap
├── index.php
└── .htaccess
```

---

## 6. Catatan Pengembangan Lanjutan

Beberapa fitur di prototype ini disiapkan sebagai **placeholder** yang siap
dikembangkan lebih lanjut sesuai kebutuhan produksi:

- **Export PDF/Excel** (`bast/pdf`, `laporan/export`) — saat ini hanya menampilkan
  notifikasi sukses. Untuk implementasi nyata, integrasikan library seperti
  `dompdf`/`mpdf` (PDF) atau `PhpSpreadsheet` (Excel) melalui Composer.
- **Import Excel** (`laptop/import`) — perlu ditambahkan parsing file dengan
  `PhpSpreadsheet` dan validasi baris sebelum insert massal ke tabel `laptops`.
- **Tanda tangan digital & QR verification** — saat ini tampil sebagai placeholder
  visual di dokumen BAST. Bisa dikembangkan dengan library signature-pad (JS)
  disimpan sebagai base64 image, dan QR code generator (misalnya `endroid/qr-code`).
- **Upload foto** (laptop, kondisi pengembalian) — form sudah menyediakan input
  file; tambahkan logic `do_upload()` CI3 pada controller terkait untuk menyimpan
  file ke `assets/uploads/`.
- **Role-based access** — kolom `role` sudah ada di tabel `users`, namun
  pembatasan akses per-role (mis. viewer read-only) belum diterapkan di controller.

---

## 7. Keamanan Dasar yang Sudah Diterapkan

- Password di-hash dengan `password_hash()` / `password_verify()` (bcrypt)
- Query database seluruhnya memakai Query Builder CI3 (parameter ter-escape otomatis)
- CSRF protection dapat diaktifkan melalui `application/config/config.php`
  (`$config['csrf_protection'] = TRUE;`) — dinonaktifkan secara default agar
  form demo lebih mudah diuji, **disarankan diaktifkan sebelum produksi**.
- Semua controller inti mewarisi `MY_Controller` yang memastikan sesi login valid
  sebelum mengakses halaman manapun.

---

Selamat mengembangkan lebih lanjut! 🚀
