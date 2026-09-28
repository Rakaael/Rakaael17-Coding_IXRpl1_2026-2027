<?php
mysqli_report(MYSQLI_REPORT_OFF);
require_once __DIR__ . '/Koneksi.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$isPublicRegistration = ($_SESSION['public_student_registration'] ?? false) === true;
unset($_SESSION['public_student_registration']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Daftar_user.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$role = $isPublicRegistration ? 'siswa' : trim($_POST['role'] ?? 'siswa');
$only_user = !$isPublicRegistration && isset($_POST['only_user']) && $_POST['only_user'] === '1';

if ($username === '') {
    echo "<script>alert('Username tidak boleh kosong!'); history.back();</script>";
    exit;
}

if ($password === '') {
    echo "<script>alert('Password tidak boleh kosong!'); history.back();</script>";
    exit;
}

if (!in_array($role, ['siswa', 'guru', 'admin'], true)) {
    echo "<script>alert('Role tidak valid!'); history.back();</script>";
    exit;
}

mysqli_begin_transaction($koneksi);

$password_hash = password_hash($password, PASSWORD_DEFAULT);
$user_stmt = mysqli_prepare($koneksi, 'INSERT INTO users (username, password, role, created_at) VALUES (?, ?, ?, NOW())');
if (!$user_stmt) {
    mysqli_rollback($koneksi);
    die('Gagal menyiapkan query users: ' . mysqli_error($koneksi));
}

mysqli_stmt_bind_param($user_stmt, 'sss', $username, $password_hash, $role);
if (!mysqli_stmt_execute($user_stmt)) {
    $error = mysqli_stmt_error($user_stmt);
    $errorCode = mysqli_stmt_errno($user_stmt);
    mysqli_stmt_close($user_stmt);
    mysqli_rollback($koneksi);
    if ($isPublicRegistration && $errorCode === 1062) {
        header('Location: Tambah_user.php?error=duplicate');
        exit;
    }
    die('Gagal menyimpan data user: ' . $error);
}
mysqli_stmt_close($user_stmt);

$id_terakhir = mysqli_insert_id($koneksi);

if ($role === 'siswa') {
    $nis = trim($_POST['nis'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');
    $jenis_kelamin = strtoupper(trim($_POST['jenis_kelamin'] ?? ''));

    if ($nis === '' || $nama === '' || $kelas === '' || !in_array($jenis_kelamin, ['L', 'P'], true)) {
        mysqli_rollback($koneksi);
        echo "<script>alert('Data siswa belum lengkap!'); history.back();</script>";
        exit;
    }

    $profil_stmt = mysqli_prepare($koneksi, 'INSERT INTO siswa (nis, nama, kelas, jenis_kelamin, user_id) VALUES (?, ?, ?, ?, ?)');
    if (!$profil_stmt) {
        mysqli_rollback($koneksi);
        die('Gagal menyiapkan query siswa: ' . mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param($profil_stmt, 'ssssi', $nis, $nama, $kelas, $jenis_kelamin, $id_terakhir);
    if (!mysqli_stmt_execute($profil_stmt)) {
        $error = mysqli_stmt_error($profil_stmt);
        $errorCode = mysqli_stmt_errno($profil_stmt);
        mysqli_stmt_close($profil_stmt);
        mysqli_rollback($koneksi);
        if ($isPublicRegistration && $errorCode === 1062) {
            header('Location: Tambah_user.php?error=duplicate');
            exit;
        }
        die('Gagal menyimpan profil siswa: ' . $error);
    }
    mysqli_stmt_close($profil_stmt);

} elseif ($role === 'guru') {
    $nip = trim($_POST['nip'] ?? '');
    $nama = trim($_POST['nama'] ?? '');
    $jenis_kelamin = strtoupper(trim($_POST['jenis_kelamin'] ?? ''));

    if ($nip === '' || $nama === '' || !in_array($jenis_kelamin, ['L', 'P'], true)) {
        mysqli_rollback($koneksi);
        echo "<script>alert('Data guru belum lengkap!'); history.back();</script>";
        exit;
    }

    $profil_stmt = mysqli_prepare($koneksi, 'INSERT INTO guru (nip, nama, jenis_kelamin, user_id) VALUES (?, ?, ?, ?)');
    if (!$profil_stmt) {
        mysqli_rollback($koneksi);
        die('Gagal menyiapkan query guru: ' . mysqli_error($koneksi));
    }

    mysqli_stmt_bind_param($profil_stmt, 'sssi', $nip, $nama, $jenis_kelamin, $id_terakhir);
    if (!mysqli_stmt_execute($profil_stmt)) {
        $error = mysqli_stmt_error($profil_stmt);
        mysqli_stmt_close($profil_stmt);
        mysqli_rollback($koneksi);
        die('Gagal menyimpan profil guru: ' . $error);
    }
    mysqli_stmt_close($profil_stmt);
}

mysqli_commit($koneksi);

if ($isPublicRegistration) {
    header('Location: Login.php?registered=1');
    exit;
}

if ($only_user) {
    echo "<script>alert('Berhasil! Data user tersimpan.'); window.location.href='Daftar_user.php';</script>";
    exit;
}

echo "<script>alert('Berhasil! Data $role tersimpan.'); window.location.href='Daftar_user.php';</script>";
exit;
?>