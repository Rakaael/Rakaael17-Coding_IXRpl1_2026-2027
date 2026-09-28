<?php
// File ini menampilkan daftar user versi kedua.
// Versi ini menampilkan data profil user dan waktu pembuatan.
require_once __DIR__ . '/Koneksi.php';
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
        .table-container { padding: 30px 65px; }
        .judul { text-align: center; font-size: 42px; font-weight: 600; margin-top: 20px; margin-bottom: 90px; }
        table.dataTable thead th { font-weight: 600; font-size: 18px; }
        table.dataTable tbody td { font-size: 16px; }
        @media (max-width: 768px) {
            .table-container { padding: 24px 16px; }
            .judul { font-size: 32px; margin-bottom: 40px; }
        }
    </style>
</head>

<body>
<?php require_once __DIR__ . '/navbar.php'; ?>
<div class="container-fluid table-container">
    <h1 class="judul">Daftar User 2</h1>

    <table id="tabelUser" class="table table-striped table-bordered w-100">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th>
                <th>NIS / NIP</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jenis Kelamin</th>
                <th>Created At</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Nomor urut untuk daftar.
        $no = 1;

        // Query menampilkan data user dan profil yang sesuai untuk siswa maupun guru.
        $query = mysqli_query($koneksi, "SELECT u.id, u.username, u.role, u.created_at,
                COALESCE(s.nis, g.nip) AS nomor_identitas,
                COALESCE(s.nama, g.nama) AS nama,
                COALESCE(s.kelas, '-') AS kelas,
                COALESCE(s.jenis_kelamin, g.jenis_kelamin) AS jenis_kelamin
            FROM users u
            LEFT JOIN siswa s ON s.user_id = u.id
            LEFT JOIN guru g ON g.user_id = u.id
            ORDER BY u.id DESC");

        if (!$query) {
            die('Query gagal: ' . mysqli_error($koneksi));
        }

        while ($data = mysqli_fetch_assoc($query)) {
            $id_user = $data['id'] ?? null;
            $username = $data['username'] ?? '';
            $role = $data['role'] ?? '';
            $created_at = $data['created_at'] ?? '';
            $nomor_identitas = $data['nomor_identitas'] ?? '-';
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
                <td><?= htmlspecialchars($role); ?></td>
                <td><?= htmlspecialchars($nomor_identitas); ?></td>
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
        columnDefs: [{ orderable: false, targets: 8 }]
    });
});
</script>
</body>
</html>