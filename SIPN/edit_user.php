<?php
require_once __DIR__ . '/Koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    exit('ID user tidak valid.');
}

$stmt = mysqli_prepare($koneksi, 'SELECT id, username, role FROM users WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$user) {
    exit('Data user tidak ditemukan.');
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f6f9; padding: 20px; }
        form { max-width: 500px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; }
        label { display: block; margin-top: 10px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; margin-top: 5px; box-sizing: border-box; }
        button, a { display: inline-block; margin-top: 15px; padding: 10px 18px; border: 0; text-decoration: none; cursor: pointer; }
        button { background: #28a745; color: #fff; }
        a { background: #6c757d; color: #fff; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Edit User</h2>
    <form action="proses_edit.php" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']); ?>">

        <label>Username</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']); ?>" required>

        <label>Password Baru</label>
        <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">

        <label>Role</label>
        <select name="role" required>
            <?php foreach (['siswa', 'guru', 'admin'] as $role) { ?>
                <option value="<?= $role; ?>" <?= $user['role'] === $role ? 'selected' : ''; ?>><?= ucfirst($role); ?></option>
            <?php } ?>
        </select>

        <button type="submit">Simpan Perubahan</button>
        <a href="Daftar_user.php">Batal</a>
    </form>
</body>
</html>
