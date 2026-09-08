<?php
require_once __DIR__ . '/Koneksi.php';
require_once __DIR__ . '/Navbar.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die('ERROR: ID user tidak valid.');
}

$stmt = mysqli_prepare($koneksi, 'SELECT u.id, u.username, u.role, s.nis, s.nama, s.kelas, s.jenis_kelamin FROM users u LEFT JOIN siswa s ON s.user_id = u.id WHERE u.id = ?');
if (!$stmt) {
    die('Error query: ' . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) {
    die('ERROR: Data user tidak ditemukan.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            min-height: 100vh;
        }

        .wrapper {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.08);
            padding: 30px;
        }

        h2 {
            margin-bottom: 25px;
            font-weight: 600;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            margin-bottom: 16px;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="wrapper">
            <h2>Edit User</h2>

            <form action="proses_edit.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars((string) $user['id']); ?>">

                <div class="row">
                    <div class="col-md-6">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" value="<?= htmlspecialchars($user['nis'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($user['nama'] ?? ''); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" class="form-control" id="kelas" name="kelas" value="<?= htmlspecialchars($user['kelas'] ?? ''); ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki" value="L" <?= ($user['jenis_kelamin'] ?? '') === 'L' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="laki_laki">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="P" <?= ($user['jenis_kelamin'] ?? '') === 'P' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>

                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>

                <label for="password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">

                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="siswa" <?= ($user['role'] ?? '') === 'siswa' ? 'selected' : ''; ?>>Siswa</option>
                    <option value="guru" <?= ($user['role'] ?? '') === 'guru' ? 'selected' : ''; ?>>Guru</option>
                    <option value="admin" <?= ($user['role'] ?? '') === 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="Daftar_user2.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
