<?php
require_once __DIR__ . '/Koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    exit('ID user tidak valid.');
}

$stmt = mysqli_prepare($koneksi, 'DELETE FROM users WHERE id = ?');
mysqli_stmt_bind_param($stmt, 'i', $id);

if (!mysqli_stmt_execute($stmt)) {
    exit('Gagal menghapus data: ' . mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);
header('Location: Daftar_user.php');
exit;
