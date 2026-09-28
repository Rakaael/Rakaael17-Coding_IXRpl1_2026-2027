<?php
$errorMessages = [
    'invalid' => 'Username atau password salah.',
    'required' => 'Silakan login terlebih dahulu.',
];
$error = $errorMessages[$_GET['error'] ?? ''] ?? null;
$registered = ($_GET['registered'] ?? '') === '1';
$loggedOut = ($_GET['logout'] ?? '') === '1';
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login SIPN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
    <section class="card shadow-sm border-0 w-100" style="max-width: 440px;">
        <div class="card-body p-4 p-md-5">
            <h1 class="h3 mb-1">Login SIPN</h1>
            <p class="text-secondary mb-4">Masuk dengan akun siswa, guru, atau admin.</p>
            <?php if ($registered) { ?>
                <div class="alert alert-success" role="status">Pendaftaran berhasil. Silakan login.</div>
            <?php } ?>
            <?php if ($loggedOut) { ?>
                <div class="alert alert-info" role="status">Anda berhasil keluar.</div>
            <?php } ?>
            <?php if ($error) { ?>
                <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error); ?></div>
            <?php } ?>
            <form action="Aksi_login.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" maxlength="50" autocomplete="username" required autofocus>
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" autocomplete="current-password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Masuk</button>
            </form>
            <p class="text-center mt-4 mb-0">Belum punya akun? <a href="Tambah_user3.php">Daftar sebagai siswa</a></p>
        </div>
    </section>
</main>
</body>
</html>
