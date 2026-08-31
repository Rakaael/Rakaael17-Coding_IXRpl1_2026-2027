<?php
require_once __DIR__ . '/Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Daftar_user.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role = $_POST['role'] ?? '';

if (!$id || $username === '' || $role === '') {
    exit('Data user belum lengkap.');
}

if ($password !== '') {
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($koneksi, 'UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'sssi', $username, $passwordHash, $role, $id);
    }
} else {
    $stmt = mysqli_prepare($koneksi, 'UPDATE users SET username = ?, role = ? WHERE id = ?');
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssi', $username, $role, $id);
    }
}

if (!$stmt || !mysqli_stmt_execute($stmt)) {
    exit('Gagal mengubah data: ' . mysqli_error($koneksi));
}

mysqli_stmt_close($stmt);
header('Location: Daftar_user.php');
exit;
