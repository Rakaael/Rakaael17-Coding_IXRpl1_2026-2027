<?php
// File ini berfungsi sebagai pusat koneksi ke database MySQL.
// Semua file lain memanggil file ini agar bisa terhubung ke database tanpa menulis konfigurasi berulang.

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_smk';

$koneksi = mysqli_connect($host, $username, $password, $database);

if (!$koneksi) {
    die('Koneksi database gagal: ' . mysqli_connect_error());
}

mysqli_set_charset($koneksi, 'utf8mb4');

?>