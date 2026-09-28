<?php
mysqli_report(MYSQLI_REPORT_OFF);
require_once dirname(__DIR__) . '/Koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Mapel.php');
    exit;
}

$id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    header('Location: Mapel.php?error=not_found');
    exit;
}

$stmt = mysqli_prepare($koneksi, 'DELETE FROM mapel WHERE id = ?');
if (!$stmt) {
    header('Location: Mapel.php?error=failed');
    exit;
}
mysqli_stmt_bind_param($stmt, 'i', $id);
$deleted = mysqli_stmt_execute($stmt);
$deletedRows = mysqli_stmt_affected_rows($stmt);
mysqli_stmt_close($stmt);

if (!$deleted) {
    header('Location: Mapel.php?error=failed');
    exit;
}
if ($deletedRows !== 1) {
    header('Location: Mapel.php?error=not_found');
    exit;
}

header('Location: Mapel.php?status=deleted');
exit;
