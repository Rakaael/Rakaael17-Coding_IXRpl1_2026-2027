<?php
// File ini berisi form untuk menambahkan data siswa baru.
// Kolom yang diinput adalah NIS, nama, kelas, jenis kelamin, username, password, serta role otomatis = siswa.
$errorMessages = [
    'duplicate' => 'NIS atau username sudah digunakan. Silakan periksa kembali.',
    'invalid' => 'Data pendaftaran belum valid. Periksa semua kolom.',
];
$error = $errorMessages[$_GET['error'] ?? ''] ?? null;
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php require_once __DIR__ . '/navbar.php'; ?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border border-2 border-secondary-subtle rounded-4 shadow-sm" style="background: #f7f7f7;">
                <div class="card-body p-4 p-md-5">
                    <form action="Aksi_register.php" method="POST">
                        <?php if ($error) { ?>
                            <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error); ?></div>
                        <?php } ?>
                        <h1 class="fw-normal text-center mb-4" style="font-size: 3rem;">Daftar Siswa</h1>

                        <div class="mb-3">
                            <input type="text" name="nis" maxlength="10" class="form-control form-control-lg border-0 rounded-3" style="background: #e9eefb; height: 50px;" placeholder="NIS | Contoh: 1234567890" required>
                        </div>

                        <div class="mb-3">
                            <input type="text" name="nama" maxlength="100" class="form-control form-control-lg border-0 rounded-3" style="background: #e9eefb; height: 50px;" placeholder="Nama Lengkap | Contoh: Matthias Von Herdhart" required>
                        </div>

                        <div class="mb-3">
                            <input type="text" name="kelas" maxlength="10" class="form-control form-control-lg border-0 rounded-3" style="background: #e9eefb; height: 50px;" placeholder="Kelas | Contoh: XI RPL 1" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold mb-2">Jenis Kelamin</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="jenis_kelamin" id="laki" value="L" required>
                                    <label class="form-check-label" for="laki">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" name="jenis_kelamin" id="perempuan" value="P">
                                    <label class="form-check-label" for="perempuan">Perempuan</label>
                                </div>
                            </div>
                        </div>

                        <h3 class="fw-bold mb-3">Data Akun Kredensial Siswa</h3>

                        <div class="mb-3">
                            <input type="text" name="username" maxlength="50" class="form-control form-control-lg border-0 rounded-3" style="background: #e9eefb; height: 50px;" placeholder="Username Akun | Contoh: matthias231" autocomplete="username" required>
                        </div>

                        <div class="mb-3">
                            <input type="password" name="password" minlength="8" class="form-control form-control-lg border-0 rounded-3" style="background: #e9eefb; height: 50px;" placeholder="Password minimal 8 karakter" autocomplete="new-password" required>
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary btn-lg px-4">Daftar</button>
                            <a href="Login.php" class="btn btn-secondary btn-lg px-4">Sudah punya akun? Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>