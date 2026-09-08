<?php
require_once __DIR__ . '/Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Daftar_user.php');
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die('ID user tidak valid!');
}

$nis = trim($_POST['nis'] ?? '');
$nama = trim($_POST['nama'] ?? '');
$kelas = trim($_POST['kelas'] ?? '');
$jenis_kelamin = strtoupper(trim($_POST['jenis_kelamin'] ?? ''));
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role = trim($_POST['role'] ?? 'siswa');

if ($nama === '') {
    die('Nama tidak boleh kosong!');
}

if ($username === '') {
    die('Username tidak boleh kosong!');
}

if ($password !== '' && strlen($password) < 6) {
    die('Password minimal 6 karakter!');
}

if ($jenis_kelamin !== '' && !in_array($jenis_kelamin, ['L', 'P'], true)) {
    die('Jenis kelamin tidak valid!');
}

$check = mysqli_prepare($koneksi, 'SELECT id FROM users WHERE username = ? AND id != ?');
if (!$check) {
    die('Error database: ' . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($check, 'si', $username, $id);
mysqli_stmt_execute($check);
$result_check = mysqli_stmt_get_result($check);

if (mysqli_num_rows($result_check) > 0) {
    mysqli_stmt_close($check);
    die('Username sudah digunakan oleh user lain!');
}
mysqli_stmt_close($check);

mysqli_begin_transaction($koneksi);

if ($password !== '') {
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $user_stmt = mysqli_prepare($koneksi, 'UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?');
    if (!$user_stmt) {
        mysqli_rollback($koneksi);
        die('Error: ' . mysqli_error($koneksi));
    }
    mysqli_stmt_bind_param($user_stmt, 'sssi', $username, $password_hash, $role, $id);
} else {
    $user_stmt = mysqli_prepare($koneksi, 'UPDATE users SET username = ?, role = ? WHERE id = ?');
    if (!$user_stmt) {
        mysqli_rollback($koneksi);
        die('Error: ' . mysqli_error($koneksi));
    }
    mysqli_stmt_bind_param($user_stmt, 'ssi', $username, $role, $id);
}

if (!mysqli_stmt_execute($user_stmt)) {
    $error = mysqli_stmt_error($user_stmt);
    mysqli_stmt_close($user_stmt);
    mysqli_rollback($koneksi);
    die('Gagal mengubah data user: ' . $error);
}
mysqli_stmt_close($user_stmt);

$student_check = mysqli_prepare($koneksi, 'SELECT id FROM siswa WHERE user_id = ?');
if (!$student_check) {
    mysqli_rollback($koneksi);
    die('Error: ' . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($student_check, 'i', $id);
mysqli_stmt_execute($student_check);
$student_result = mysqli_stmt_get_result($student_check);
$student = mysqli_fetch_assoc($student_result);
mysqli_stmt_close($student_check);

if ($student) {
    $student_stmt = mysqli_prepare($koneksi, 'UPDATE siswa SET nis = ?, nama = ?, kelas = ?, jenis_kelamin = ? WHERE id = ?');
    if (!$student_stmt) {
        mysqli_rollback($koneksi);
        die('Error: ' . mysqli_error($koneksi));
    }
    mysqli_stmt_bind_param($student_stmt, 'ssssi', $nis, $nama, $kelas, $jenis_kelamin, $student['id']);
    if (!mysqli_stmt_execute($student_stmt)) {
        $error = mysqli_stmt_error($student_stmt);
        mysqli_stmt_close($student_stmt);
        mysqli_rollback($koneksi);
        die('Gagal mengubah data siswa: ' . $error);
    }
    mysqli_stmt_close($student_stmt);
} else {
    $student_stmt = mysqli_prepare($koneksi, 'INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, user_id) VALUES (?, ?, ?, ?, ?)');
    if (!$student_stmt) {
        mysqli_rollback($koneksi);
        die('Error: ' . mysqli_error($koneksi));
    }
    mysqli_stmt_bind_param($student_stmt, 'ssssi', $nis, $nama, $kelas, $jenis_kelamin, $id);
    if (!mysqli_stmt_execute($student_stmt)) {
        $error = mysqli_stmt_error($student_stmt);
        mysqli_stmt_close($student_stmt);
        mysqli_rollback($koneksi);
        die('Gagal menambah data siswa: ' . $error);
    }
    mysqli_stmt_close($student_stmt);
}

mysqli_commit($koneksi);

echo "<script>alert('Data user berhasil diubah!'); window.location.href='Daftar_user2.php';</script>";
exit;
?>