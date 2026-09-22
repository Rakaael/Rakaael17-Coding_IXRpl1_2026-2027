<?php
// File ini adalah halaman daftar user utama.
// Tujuannya adalah menampilkan data user yang sudah tersimpan di database dan menyediakan tombol Edit/Hapus.
require_once __DIR__ . '/Koneksi.php';
require_once __DIR__ . '/Navbar.php';
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <style>
        body { background-color: white; }
        .container-fluid { padding: 30px 65px; }
        .judul { text-align: center; font-size: 42px; font-weight: 600; margin-top: 20px; margin-bottom: 90px; }
        table.dataTable thead th { font-weight: 600; font-size: 18px; }
        table.dataTable tbody td { font-size: 16px; }
    </style>
</head>

<body>
<div class="container-fluid">
    <h1 class="judul">Daftar User</h1>

    <table id="tabelUser" class="table table-striped table-bordered w-100">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>Nama</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Menghitung nomor urut row agar tampilan daftar lebih rapi.
        $no = 1;

        // Query untuk mengambil data user dan data profil yang terkait.
        // LEFT JOIN dipakai agar data user tetap tampil walau profil siswa/guru belum ada.
        $query = mysqli_query($koneksi, "SELECT u.id, u.username, u.role,
                COALESCE(s.nama, g.nama) AS nama
            FROM users u
            LEFT JOIN siswa s ON s.user_id = u.id
            LEFT JOIN guru g ON g.user_id = u.id
            ORDER BY u.id DESC");

        if (!$query) {
            die('Query gagal: ' . mysqli_error($koneksi));
        }

        // Looping data satu per satu lalu ditampilkan ke dalam baris tabel.
        while ($data = mysqli_fetch_assoc($query)) {
            $id_user = $data['id'] ?? null;
            $username = $data['username'] ?? '';
            $role = $data['role'] ?? '';
            $nama = $data['nama'] ?? '-';
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($username); ?></td>
                <td><?= htmlspecialchars($role); ?></td>
                <td><?= htmlspecialchars($nama); ?></td>
                <td>
                    <?php if ($id_user !== null && $id_user !== '') { ?>
                        <!-- Tombol Edit mengirim id user ke halaman edit_user.php -->
                        <a href="edit_user.php?id=<?= urlencode((string) $id_user); ?>" class="btn btn-warning btn-sm">Edit</a>
                        <!-- Tombol Hapus mengirim id user ke file hapus_user.php untuk proses penghapusan -->
                        <a href="hapus_user.php?id=<?= urlencode((string) $id_user); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#tabelUser').DataTable({
        pageLength: 10,
        language: {
            lengthMenu: 'Tampilkan _MENU_ data per halaman',
            search: '',
            searchPlaceholder: 'Search',
            zeroRecords: 'Data tidak ditemukan',
            info: 'Menampilkan halaman _PAGE_ dari _PAGES_',
            infoEmpty: 'Menampilkan halaman 0 dari 0',
            paginate: {
                previous: 'Sebelumnya',
                next: 'Selanjutnya'
            }
        },
        columnDefs: [{ orderable: false, targets: 4 }]
    });
});
</script>
</body>
</html>