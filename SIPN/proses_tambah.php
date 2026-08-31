<?php
require_once __DIR__ . '/Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Tambah_user.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if ($username === '' || $password === '' || $role === '') {
    exit('Semua data wajib diisi.');
}

$passwordHash = password_hash($password, PASSWORD_DEFAULT);
$sql = 'INSERT INTO users (username, password, role) VALUES (?, ?, ?)';
$stmt = mysqli_prepare($koneksi, $sql);
if (!$stmt) {
    exit('Gagal menyiapkan penyimpanan data: ' . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($stmt, 'sss', $username, $passwordHash, $role);

if (!mysqli_stmt_execute($stmt)) {
    exit('Gagal menyimpan data: ' . mysqli_stmt_error($stmt));
}

mysqli_stmt_close($stmt);
header('Location: Daftar_user.php');
exit;
