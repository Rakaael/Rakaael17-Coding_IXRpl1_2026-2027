<?php
mysqli_report(MYSQLI_REPORT_OFF);
require_once __DIR__ . '/Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Login.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
if ($username === '' || $password === '') {
    header('Location: Login.php?error=invalid');
    exit;
}

$stmt = mysqli_prepare($koneksi, 'SELECT id, username, password, role FROM users WHERE username = ? LIMIT 1');
if (!$stmt) {
    http_response_code(500);
    exit('Login sementara tidak dapat diproses.');
}
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
mysqli_stmt_close($stmt);

if (!$user || !password_verify($password, $user['password'])) {
    header('Location: Login.php?error=invalid');
    exit;
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
session_regenerate_id(true);
$_SESSION['user_id'] = (int) $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

if ($user['role'] === 'admin') {
    header('Location: Daftar_user.php');
} else {
    header('Location: MAPEL/Mapel.php');
}
exit;
