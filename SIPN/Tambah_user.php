<?php
include 'Koneksi.php';

// proses simpan data
if (isset($_POST['simpan'])) {

    $nama            = $_POST['nama'];
    $tanggal_lahir   = $_POST['tanggal_lahir'];
    $jenis_kelamin   = $_POST['jenis_kelamin'];
    $alamat          = $_POST['alamat'];
    $email           = $_POST['email'];
    $password        = $_POST['password'];

    // query insert data
    $query = "INSERT INTO user 
    (
        nama,
        tanggal_lahir,
        jenis_kelamin,
        alamat,
        email,
        password
    )

    VALUES
    (
        '$nama',
        '$tanggal_lahir',
        '$jenis_kelamin',
        '$alamat',
        '$email',
        '$password'
    )";

    $simpan = mysqli_query($koneksi, $query);

    // cek berhasil atau tidak
    if ($simpan) {

        echo "
        <script>
            alert('Data berhasil disimpan');
            window.location='Daftar_user_while.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Data gagal disimpan');
        </script>
        ";
    }
}
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Tambah User</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<?php 
include 'Navbar.php'; 
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-lg border-0">

                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0 text-center">Form Tambah User</h4>
                </div>

                <div class="card-body">

                    <form method="POST">

                        <!-- Nama -->
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                Nama Lengkap
                            </label>

                            <input 
                                type="text" 
                                name="nama"
                                id="nama"
                                class="form-control"
                                placeholder="Masukkan nama lengkap"
                                required>
                        </div>

                        <!-- Tanggal Lahir & Jenis Kelamin -->
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="tanggal_lahir" class="form-label">
                                    Tanggal Lahir
                                </label>

                                <input 
                                    type="date" 
                                    name="tanggal_lahir" 
                                    id="tanggal_lahir"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jenis_kelamin" class="form-label">
                                    Jenis Kelamin
                                </label>

                                <select 
                                    name="jenis_kelamin" 
                                    id="jenis_kelamin"
                                    class="form-select"
                                    required>

                                    <option value="">-- Pilih --</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>

                                </select>
                            </div>

                        </div>

                        <!-- Alamat -->
                        <div class="mb-3">
                            <label for="alamat" class="form-label">
                                Alamat
                            </label>

                            <textarea 
                                name="alamat" 
                                id="alamat"
                                class="form-control"
                                rows="3"
                                placeholder="Masukkan alamat lengkap"
                                required></textarea>
                        </div>

                        <!-- Email & Password -->
                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    Email
                                </label>

                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    class="form-control"
                                    placeholder="Masukkan email"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    Password
                                </label>

                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password"
                                    class="form-control"
                                    placeholder="Masukkan password"
                                    required>
                            </div>

                        </div>

                        <!-- Tombol -->
                        <div class="mt-4 d-flex gap-2">

                            <button 
                                type="submit" 
                                name="simpan"
                                class="btn btn-success">
                                Simpan Data
                            </button>

                            <button 
                                type="reset" 
                                class="btn btn-secondary">
                                Reset
                            </button>

                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>