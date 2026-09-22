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

$role = trim($_POST['role'] ?? 'siswa');
$nama = trim($_POST['nama'] ?? '');
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';
$jenis_kelamin = strtoupper(trim($_POST['jenis_kelamin'] ?? ''));

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

if ($role === 'siswa') {
    $nis = trim($_POST['nis'] ?? '');
    $kelas = trim($_POST['kelas'] ?? '');

    if ($nis === '') die('NIS tidak boleh kosong!');
    if ($kelas === '') die('Kelas tidak boleh kosong!');
} elseif ($role === 'guru') {
    $nip = trim($_POST['nip'] ?? '');
    if ($nip === '') die('NIP tidak boleh kosong!');
} elseif ($role === 'admin') {
    $nip = '';
    $nis = '';
    $kelas = '';
} else {
    die('Role tidak valid!');
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

if ($role === 'siswa') {
    $delete_old = mysqli_prepare($koneksi, 'DELETE FROM guru WHERE user_id = ?');
    if (!$delete_old) {
        mysqli_rollback($koneksi);
        die('Error: ' . mysqli_error($koneksi));
    }
    mysqli_stmt_bind_param($delete_old, 'i', $id);
    mysqli_stmt_execute($delete_old);
    mysqli_stmt_close($delete_old);

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
        $student_stmt = mysqli_prepare($koneksi, 'UPDATE siswa SET nis = ?, nama = ?, kelas = ?, jenis_kelamin = ? WHERE user_id = ?');
        if (!$student_stmt) {
            mysqli_rollback($koneksi);
            die('Error: ' . mysqli_error($koneksi));
        }
        mysqli_stmt_bind_param($student_stmt, 'ssssi', $nis, $nama, $kelas, $jenis_kelamin, $id);
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

} elseif ($role === 'guru') {
    $delete_old = mysqli_prepare($koneksi, 'DELETE FROM siswa WHERE user_id = ?');
    if (!$delete_old) {
        mysqli_rollback($koneksi);
        die('Error: ' . mysqli_error($koneksi));
    }
    mysqli_stmt_bind_param($delete_old, 'i', $id);
    mysqli_stmt_execute($delete_old);
    mysqli_stmt_close($delete_old);

    $teacher_check = mysqli_prepare($koneksi, 'SELECT id FROM guru WHERE user_id = ?');
    if (!$teacher_check) {
        mysqli_rollback($koneksi);
        die('Error: ' . mysqli_error($koneksi));
    }
    mysqli_stmt_bind_param($teacher_check, 'i', $id);
    mysqli_stmt_execute($teacher_check);
    $teacher_result = mysqli_stmt_get_result($teacher_check);
    $teacher = mysqli_fetch_assoc($teacher_result);
    mysqli_stmt_close($teacher_check);

    if ($teacher) {
        $teacher_stmt = mysqli_prepare($koneksi, 'UPDATE guru SET nip = ?, nama = ?, jenis_kelamin = ? WHERE user_id = ?');
        if (!$teacher_stmt) {
            mysqli_rollback($koneksi);
            die('Error: ' . mysqli_error($koneksi));
        }
        mysqli_stmt_bind_param($teacher_stmt, 'sssi', $nip, $nama, $jenis_kelamin, $id);
        if (!mysqli_stmt_execute($teacher_stmt)) {
            $error = mysqli_stmt_error($teacher_stmt);
            mysqli_stmt_close($teacher_stmt);
            mysqli_rollback($koneksi);
            die('Gagal mengubah data guru: ' . $error);
        }
        mysqli_stmt_close($teacher_stmt);
    } else {
        $teacher_stmt = mysqli_prepare($koneksi, 'INSERT INTO guru (nip, nama, jenis_kelamin, user_id) VALUES (?, ?, ?, ?)');
        if (!$teacher_stmt) {
            mysqli_rollback($koneksi);
            die('Error: ' . mysqli_error($koneksi));
        }
        mysqli_stmt_bind_param($teacher_stmt, 'sssi', $nip, $nama, $jenis_kelamin, $id);
        if (!mysqli_stmt_execute($teacher_stmt)) {
            $error = mysqli_stmt_error($teacher_stmt);
            mysqli_stmt_close($teacher_stmt);
            mysqli_rollback($koneksi);
            die('Gagal menambah data guru: ' . $error);
        }
        mysqli_stmt_close($teacher_stmt);
    }
} else {
    $delete_siswa = mysqli_prepare($koneksi, 'DELETE FROM siswa WHERE user_id = ?');
    if ($delete_siswa) {
        mysqli_stmt_bind_param($delete_siswa, 'i', $id);
        mysqli_stmt_execute($delete_siswa);
        mysqli_stmt_close($delete_siswa);
    }

    $delete_guru = mysqli_prepare($koneksi, 'DELETE FROM guru WHERE user_id = ?');
    if ($delete_guru) {
        mysqli_stmt_bind_param($delete_guru, 'i', $id);
        mysqli_stmt_execute($delete_guru);
        mysqli_stmt_close($delete_guru);
    }
}

mysqli_commit($koneksi);

echo "<script>alert('Data user berhasil diubah!'); window.location.href='Daftar_user2.php';</script>";
exit;
?>