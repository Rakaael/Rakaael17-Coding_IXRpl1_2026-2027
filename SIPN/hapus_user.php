<?php
require_once __DIR__ . '/Koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    exit('ID user tidak valid.');
}

mysqli_begin_transaction($koneksi);

$siswa_stmt = mysqli_prepare($koneksi, 'DELETE FROM siswa WHERE user_id = ?');
if (!$siswa_stmt) {
    mysqli_rollback($koneksi);
    exit('Gagal menyiapkan data siswa: ' . mysqli_error($koneksi));
}
mysqli_stmt_bind_param($siswa_stmt, 'i', $id);
if (!mysqli_stmt_execute($siswa_stmt)) {
    mysqli_stmt_close($siswa_stmt);
    mysqli_rollback($koneksi);
    exit('Gagal menghapus data siswa: ' . mysqli_stmt_error($siswa_stmt));
}
mysqli_stmt_close($siswa_stmt);

$user_stmt = mysqli_prepare($koneksi, 'DELETE FROM users WHERE id = ?');
if (!$user_stmt) {
    mysqli_rollback($koneksi);
    exit('Gagal menyiapkan data user: ' . mysqli_error($koneksi));
}
mysqli_stmt_bind_param($user_stmt, 'i', $id);
if (!mysqli_stmt_execute($user_stmt)) {
    mysqli_stmt_close($user_stmt);
    mysqli_rollback($koneksi);
    exit('Gagal menghapus data user: ' . mysqli_stmt_error($user_stmt));
}
mysqli_stmt_close($user_stmt);

mysqli_commit($koneksi);
header('Location: Daftar_user.php');
exit;
