<?php
require_once __DIR__ . '/Koneksi.php';
require_once __DIR__ . '/Navbar.php';
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar User 2</title>
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
    <h1 class="judul">Daftar User 2</h1>

    <table id="tabelUser" class="table table-striped table-bordered w-100">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Password</th>
                <th>Role</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>Created At</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT u.id, u.username, u.password, u.role, u.created_at, s.nis, s.nama, s.kelas, s.jenis_kelamin
            FROM users u
            LEFT JOIN siswa s ON s.user_id = u.id AND u.role = 'siswa'
            ORDER BY u.id DESC");

        if (!$query) {
            die('Query gagal: ' . mysqli_error($koneksi));
        }

        while ($data = mysqli_fetch_assoc($query)) {
            $id_user = $data['id'] ?? null;
            $username = $data['username'] ?? '';
            $password = $data['password'] ?? '';
            $role = $data['role'] ?? '';
            $created_at = $data['created_at'] ?? '';
            $nis = $data['nis'] ?? '-';
            $nama = $data['nama'] ?? '-';
            $kelas = $data['kelas'] ?? '-';
            $jenis_kelamin = $data['jenis_kelamin'] ?? '-';

            if ($jenis_kelamin === 'L') {
                $jenis_kelamin = 'Laki-laki';
            } elseif ($jenis_kelamin === 'P') {
                $jenis_kelamin = 'Perempuan';
            }
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($username); ?></td>
                <td><?= htmlspecialchars($password); ?></td>
                <td><?= htmlspecialchars($role); ?></td>
                <td><?= htmlspecialchars($nis); ?></td>
                <td><?= htmlspecialchars($nama); ?></td>
                <td><?= htmlspecialchars($kelas); ?></td>
                <td><?= htmlspecialchars($jenis_kelamin); ?></td>
                <td><?= htmlspecialchars($created_at); ?></td>
                <td>
                    <?php if ($id_user !== null && $id_user !== '') { ?>
                        <a href="edit_user.php?id=<?= urlencode((string) $id_user); ?>" class="btn btn-warning btn-sm">Edit</a>
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
        columnDefs: [{ orderable: false, targets: 9 }]
    });
});
</script>
</body>
</html>