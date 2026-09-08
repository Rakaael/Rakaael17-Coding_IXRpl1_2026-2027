<?php
require_once __DIR__ . '/Koneksi.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    exit('ID user tidak valid.');
}

mysqli_begin_transaction($koneksi);

$hapus = function (string $tabel, string $kolom, string $nama) use ($koneksi, $id): void {
    $stmt = mysqli_prepare($koneksi, "DELETE FROM $tabel WHERE $kolom = ?");
    if (!$stmt) {
        mysqli_rollback($koneksi);
        exit("Gagal menyiapkan data $nama: " . mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param($stmt, 'i', $id);
    if (!mysqli_stmt_execute($stmt)) {
        $error = mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
        mysqli_rollback($koneksi);
        exit("Gagal menghapus data $nama: $error");
    }
    mysqli_stmt_close($stmt);
};

$hapus('siswa', 'user_id', 'siswa');
$hapus('users', 'id', 'user');

mysqli_commit($koneksi);
header('Location: Daftar_user.php');
exit;
