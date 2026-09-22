<?php
// File ini berfungsi sebagai pusat koneksi ke database MySQL.
// Semua file lain memanggil file ini agar bisa terhubung ke database tanpa menulis konfigurasi berulang.

$host = "localhost";
$username = "root";
$password = "";
$database = "db_siacad_smk";

// Membuka koneksi ke database dengan data server yang sudah ditentukan.
$koneksi = mysqli_connect(
    $host,
    $username,
    $password,
    $database
);

// Jika koneksi gagal, program dihentikan dan tampilkan pesan error.
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

?>