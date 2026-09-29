<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — AssetTrack</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@500;600;700;800&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>

<body>
    <div class="login-wrap">
        <div class="login-left">
            <div>
                <div class="flex items-center gap-10">
                    <div class="brand-mark" style="width:40px;height:40px;"><?= ic('laptop', 20) ?></div>
                    <div>
                        <div class="brand-name" style="font-size:19px;color:#fff;">AssetTrack</div>
                        <div class="brand-sub">IT ASSET &amp; BAST SYSTEM</div>
                    </div>
                </div>
                <h1
                    style="font-size:32px;line-height:1.25;max-width:420px;margin:56px 0 14px;color:#fff;font-family:var(--font-display);">
                    Satu sistem untuk melacak setiap laptop &amp; setiap serah terima.</h1>
                <p style="color:#AFC1E0;font-size:14px;max-width:400px;line-height:1.7;">Kelola inventaris laptop
                    perusahaan, pantau status penggunaan, dan terbitkan dokumen BAST resmi dalam hitungan menit.</p>
                <div style="margin-top:26px;">
                    <span class="tag-float">CIS-151/AST-L/2019</span>
                    <span class="tag-float">BAST/IT/2026/001</span>
                    <span class="tag-float">status: aktif</span>
                </div>
            </div>
            <div style="position:relative;z-index:2;color:#8CA3C9;font-size:12px;">© <?= date('Y') ?>
                <?= $company['name'] ?> — <?= $company['division'] ?></div>
        </div>
        <div class="login-right">
            <div class="login-card">
                <h2 style="font-size:22px;margin:0 0 6px;">Masuk ke akun Admin</h2>
                <p class="muted" style="font-size:13.5px;margin:0 0 26px;">Gunakan akun divisi IT Anda untuk
                    melanjutkan.</p>

                <?php if (! empty($error)): ?>
                <div class="login-error"><?= $error ?></div>
                <?php endif; ?>

                <form method="post" action="<?= site_url('login') ?>">
                    <div class="field mb-14">
                        <label>Email Kerja</label>
                        <input class="input" type="text" name="email" placeholder="admin.it@nusantaradigital.co.id"
                            value="<?= set_value('email', 'admin.it@nusantaradigital.co.id') ?>" required>
                    </div>
                    <div class="field mb-14">
                        <label>Kata Sandi</label>
                        <input class="input" type="password" name="password" placeholder="Masukkan kata sandi" required>
                        <span class="hint">Akun demo: password123</span>
                    </div>
                    <div class="flex justify-between items-center mb-20" style="font-size:12.5px;">
                        <label class="flex items-center gap-8"><input type="checkbox" checked> Ingat saya</label>
                        <a style="color:var(--primary);font-weight:600;">Lupa sandi?</a>
                    </div>
                    <button type="submit" class="btn btn-primary"
                        style="width:100%;justify-content:center;padding:11px;">Masuk Dashboard</button>
                </form>
                <p class="muted" style="font-size:12px;text-align:center;margin-top:18px;">Butuh akses? Hubungi Super
                    Admin IT.</p>
            </div>
        </div>
    </div>
</body>

</html>