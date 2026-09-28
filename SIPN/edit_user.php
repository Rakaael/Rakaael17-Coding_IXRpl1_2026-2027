<?php
// File ini menampilkan form edit data user berdasarkan id yang dikirim melalui URL.
// Form ini di-load dulu dengan data lama agar user dapat memperbarui isi form.
require_once __DIR__ . '/Koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die('ERROR: ID user tidak valid.');
}

$query = mysqli_query($koneksi, "SELECT u.id, u.username, u.role,
        s.nis, s.nama AS siswa_nama, s.kelas, s.jenis_kelamin AS siswa_jk,
        g.nip, g.nama AS guru_nama, g.jenis_kelamin AS guru_jk
    FROM users u
    LEFT JOIN siswa s ON s.user_id = u.id
    LEFT JOIN guru g ON g.user_id = u.id
    WHERE u.id = $id");

if (!$query) {
    die('Error query: ' . mysqli_error($koneksi));
}

$user = mysqli_fetch_assoc($query);
mysqli_free_result($query);

if (!$user) {
    die('ERROR: Data user tidak ditemukan.');
}

$role = $user['role'] ?? 'siswa';
$nama = $role === 'guru' ? ($user['guru_nama'] ?? '') : ($user['siswa_nama'] ?? '');
$nis = $user['nis'] ?? '';
$nip = $user['nip'] ?? '';
$kelas = $user['kelas'] ?? '';
$jenis_kelamin = $role === 'guru' ? ($user['guru_jk'] ?? '') : ($user['siswa_jk'] ?? '');

$e = fn($value) => htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
$selected = fn($value, $option) => ($value ?? '') === $option ? 'selected' : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f6f9; min-height: 100vh; }
        .wrapper { max-width: 700px; margin: 50px auto; background: #fff; border-radius: 12px; box-shadow: 0 4px 18px rgba(0,0,0,0.08); padding: 30px; }
        h2 { margin-bottom: 25px; font-weight: 600; }
        .form-label { font-weight: 600; margin-bottom: 8px; }
        .form-control, .form-select { margin-bottom: 16px; }
        .btn-group { display: flex; gap: 10px; margin-top: 10px; }
    </style>
</head>
<body>
    <?php require_once __DIR__ . '/navbar.php'; ?>
    <div class="container">
        <div class="wrapper">
            <h2>Edit User</h2>

            <form action="proses_edit.php" method="POST">
                <input type="hidden" name="id" value="<?= $e($user['id']); ?>">

                <div id="profile-fields">
                    <div class="row" id="nis-row" style="display: <?= $role === 'siswa' ? 'flex' : 'none'; ?>;">
                        <div class="col-md-6">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="text" class="form-control" id="nis" name="nis" value="<?= $e($nis); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="kelas" class="form-label">Kelas</label>
                            <input type="text" class="form-control" id="kelas" name="kelas" value="<?= $e($kelas); ?>">
                        </div>
                    </div>

                    <div class="row" id="nip-row" style="display: <?= $role === 'guru' ? 'flex' : 'none'; ?>;">
                        <div class="col-md-12">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control" id="nip" name="nip" value="<?= $e($nip); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $e($nama); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="form-label">Jenis Kelamin</label>
                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="laki_laki" value="L" <?= ($jenis_kelamin ?? '') === 'L' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="laki_laki">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="perempuan" value="P" <?= ($jenis_kelamin ?? '') === 'P' ? 'checked' : ''; ?>>
                                <label class="form-check-label" for="perempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>
                </div>

                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?= $e($user['username']); ?>" required>

                <label for="password" class="form-label">Password Baru</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">

                <label for="role" class="form-label">Role</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="siswa" <?= $selected($user['role'], 'siswa'); ?>>Siswa</option>
                    <option value="guru" <?= $selected($user['role'], 'guru'); ?>>Guru</option>
                    <option value="admin" <?= $selected($user['role'], 'admin'); ?>>Admin</option>
                </select>

                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="Daftar_user2.php" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const nisRow = document.getElementById('nis-row');
            const nipRow = document.getElementById('nip-row');
            const nisInput = document.getElementById('nis');
            const nipInput = document.getElementById('nip');
            const kelasInput = document.getElementById('kelas');

            function toggleRoleFields() {
                const role = roleSelect.value;
                nisRow.style.display = role === 'siswa' ? 'flex' : 'none';
                nipRow.style.display = role === 'guru' ? 'flex' : 'none';

                if (nisInput) nisInput.required = role === 'siswa';
                if (nipInput) nipInput.required = role === 'guru';
                if (kelasInput) kelasInput.required = role === 'siswa';
            }

            roleSelect.addEventListener('change', toggleRoleFields);
            toggleRoleFields();
        });
    </script>
</body>
</html>
