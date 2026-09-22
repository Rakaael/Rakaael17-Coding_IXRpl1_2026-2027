<?php
// File ini adalah form khusus untuk membuat akun baru dengan role admin.
// Data yang masuk hanya username, password, dan role admin, tanpa profil tambahan.
require_once __DIR__ . '/Navbar.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border border-2 border-secondary-subtle rounded-4 shadow-sm" style="background: #f7f7f7;">
                <div class="card-body p-4 p-md-5">
                    <form action="proses_tambah.php" method="POST">
                        <h3 class="mb-3">Data Kredensial Siswa (Tabel Users)</h3>
                        <input type="text" name="username" class="form-control mb-3" placeholder="Username Akun | Contoh: matthias231" required>
                        <input type="password" name="password" class="form-control mb-3" placeholder="Password | Contoh: 123456" required>
                        <input type="hidden" name="role" value="admin">
                        <input type="hidden" name="only_user" value="1">

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="Daftar_user.php" class="btn btn-secondary">Kembali</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/Footer.php'; ?>