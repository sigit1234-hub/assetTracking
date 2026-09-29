@echo off
title AssetTrack - Cloudflare Tunnel
color 0B

echo ================================================================
echo   AssetTrack - Cloudflare Quick Tunnel
echo ================================================================
echo.

REM --- Cek apakah cloudflared sudah terinstall ---
where cloudflared >nul 2>nul
if %ERRORLEVEL% NEQ 0 (
	echo cloudflared belum terinstall di komputer ini.
	echo.
	echo Silakan download dulu dari:
	echo https://github.com/cloudflare/cloudflared/releases/latest
	echo ^(pilih file: cloudflared-windows-amd64.exe^)
	echo.
	echo Lalu rename jadi "cloudflared.exe" dan taruh di folder ini:
	echo %~dp0
	echo.
	pause
	exit /b
)

echo Pastikan Laragon sudah menyala dan situs AssetTrack bisa dibuka
echo lewat browser di alamat lokal Anda ^(cek dulu sebelum lanjut^).
echo.
set /p LOCAL_URL="Masukkan URL lokal AssetTrack Anda [default: http://assettrack.test]: "
if "%LOCAL_URL%"=="" set LOCAL_URL=http://assettrack.test

echo.
echo Membuka tunnel ke: %LOCAL_URL%
echo Tunggu beberapa detik, URL publik akan muncul di bawah ini...
echo Biarkan jendela ini TETAP TERBUKA selama tunnel dipakai.
echo Tekan CTRL+C untuk menghentikan tunnel.
echo ================================================================
echo.

cloudflared tunnel --url %LOCAL_URL%
pause
