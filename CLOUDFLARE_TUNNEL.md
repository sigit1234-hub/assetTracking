# Mengakses AssetTrack dari Luar Jaringan via Cloudflare Tunnel

Panduan ini menjelaskan cara membuat AssetTrack (yang berjalan di Laragon/XAMPP
lokal Anda) bisa diakses dari internet, tanpa perlu hosting atau membuka
port router.

Ada 2 cara: **Quick Tunnel** (cepat, URL acak, cocok untuk demo) dan
**Named Tunnel** (URL tetap pakai domain sendiri, cocok untuk pemakaian rutin).

---

## Persiapan (wajib untuk kedua cara)

### 1. Rapikan URL lokal dulu dengan Laragon Auto Virtual Host

Supaya URL tunnel tidak perlu subfolder `/assettrack`, buat AssetTrack
sebagai root domain lokal:

1. Buka Laragon → klik kanan tray icon → **Apache** → **www-root** →
   pastikan lokasi project ada di `C:\laragon\www\assettrack`
2. Laragon otomatis membuatkan virtual host `http://assettrack.test`
   (karena nama foldernya `assettrack`) — coba buka di browser, pastikan
   AssetTrack terbuka normal di alamat itu (bukan lewat `localhost/assettrack`)
3. Kalau belum otomatis, klik kanan tray Laragon → **www** → **Reload**

### 2. Download cloudflared

- Buka: https://github.com/cloudflare/cloudflared/releases/latest
- Download **`cloudflared-windows-amd64.exe`**
- Rename jadi `cloudflared.exe`
- Taruh di folder `tools/` project ini, atau di `C:\Windows\System32`
  (supaya bisa dipanggil dari mana saja lewat Command Prompt)

Cek berhasil dengan buka Command Prompt lalu ketik:
```
cloudflared --version
```

---

## Cara 1 — Quick Tunnel (paling cepat, tanpa akun)

Tidak perlu daftar apapun. URL akan berupa acak seperti
`https://kata-acak-acak.trycloudflare.com` dan **berubah setiap kali dijalankan ulang**.

**Cara pakai:**
1. Pastikan Laragon menyala dan `http://assettrack.test` bisa dibuka
2. Double-click file `tools/start-cloudflare-tunnel.bat` di project ini
3. Tunggu beberapa detik, URL publik akan muncul di jendela hitam tersebut
4. Bagikan URL itu ke siapapun yang perlu akses — biarkan jendela tetap terbuka

**Atau manual lewat Command Prompt:**
```cmd
cloudflared tunnel --url http://assettrack.test
```

⚠️ **Cocok untuk:** demo, testing sebentar.
❌ **Tidak cocok untuk:** pemakaian harian (URL berubah tiap restart, tidak ada uptime guarantee).

---

## Cara 2 — Named Tunnel (URL tetap, pakai domain sendiri)

Butuh: **1 domain** yang sudah/akan didaftarkan ke Cloudflare (gratis, tidak
perlu beli domain baru di Cloudflare — cukup pindahkan nameserver domain
yang sudah Anda punya, atau beli domain murah khusus untuk ini).

### Langkah 1 — Login & buat tunnel
```cmd
cloudflared tunnel login
```
Browser akan terbuka, pilih domain Anda yang sudah terdaftar di Cloudflare, lalu Authorize.

```cmd
cloudflared tunnel create assettrack
```
Catat **Tunnel ID** yang muncul (format UUID, misalnya `a1b2c3d4-...`).

### Langkah 2 — Buat file konfigurasi

Buat file `C:\Users\<nama-user>\.cloudflared\config.yml` isinya:

```yaml
tunnel: <TUNNEL-ID-ANDA>
credentials-file: C:\Users\<nama-user>\.cloudflared\<TUNNEL-ID-ANDA>.json

ingress:
  - hostname: assettrack.domain-anda.com
    service: http://localhost:80
  - service: http_status:404
```

Ganti `assettrack.domain-anda.com` dengan subdomain pilihan Anda, dan
`<TUNNEL-ID-ANDA>` dengan ID dari langkah 1.

### Langkah 3 — Arahkan DNS ke tunnel
```cmd
cloudflared tunnel route dns assettrack assettrack.domain-anda.com
```

### Langkah 4 — Jalankan tunnel
```cmd
cloudflared tunnel run assettrack
```

Sekarang AssetTrack bisa diakses permanen di `https://assettrack.domain-anda.com`
— SSL otomatis aktif dari Cloudflare, gratis.

### (Opsional) Jalankan otomatis sebagai Windows Service
Supaya tunnel tetap jalan walau Command Prompt ditutup / komputer restart:
```cmd
cloudflared service install
```

---

## Setelah Tunnel Aktif — Cek Konfigurasi Aplikasi

Secara default, `base_url` di `application/config/config.php` bersifat
**statis** (`http://localhost/assettrack/`) — ini paling stabil untuk
pemakaian lokal sehari-hari.

Kalau Anda mau base_url otomatis menyesuaikan URL Cloudflare Tunnel (supaya
tidak perlu edit manual tiap kali URL tunnel berubah), buka
`application/config/config.php`, cari baris:

```php
$config['base_url'] = 'http://localhost/assettrack/';
```

Ganti jadi:

```php
$config['base_url'] = detect_dynamic_base_url();
```

Fungsi `detect_dynamic_base_url()` sudah tersedia di file yang sama, tinggal
dipanggil. Kalau tidak diubah, base_url tetap statis seperti biasa — aman
untuk pemakaian lokal murni.

Yang tetap perlu dicek:

| Hal | Kenapa |
|---|---|
| Login pakai HTTPS (otomatis dari Cloudflare) | Supaya nanti kalau `cookie_secure` diaktifkan, sesi login tetap jalan |
| Ganti password default (`password123`) | Karena sekarang bisa diakses siapa saja dari internet |
| Laragon (Apache + MySQL) harus tetap menyala | Tunnel cuma menjembatani, bukan menggantikan server lokal Anda |
| Komputer tidak boleh sleep/mati | Kalau laptop tidur, situs otomatis ikut tidak bisa diakses |

---

## Troubleshooting

**"cloudflared: command not found"**
→ File `cloudflared.exe` belum ada di PATH. Taruh di `C:\Windows\System32` atau jalankan dengan path lengkap.

**Tunnel jalan tapi situs error 502**
→ Pastikan URL lokal di command (`http://assettrack.test` atau `http://localhost/assettrack`) benar-benar bisa dibuka duluan di browser lokal Anda.

**Login berhasil tapi langsung logout lagi**
→ Coba nonaktifkan dulu `cookie_secure` di `application/config/config.php` kalau tunnel masih pakai domain trycloudflare.com (kadang butuh penyesuaian header tambahan).
