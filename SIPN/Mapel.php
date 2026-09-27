<?php
// File ini adalah halaman daftar mapel.
require_once __DIR__ . '/Koneksi.php';
require_once __DIR__ . '/Navbar.php';
?>

<!doctype html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Mapel</title>
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
    <h1 class="judul">Daftar Mapel</h1>

    <table id="tabelMapel" class="table table-striped table-bordered w-100">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Mapel</th>
                <th>Nama Mapel</th>
                <th>Guru ID</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, 'SELECT id, kode_mapel, nama_mapel, guru_id FROM mapel ORDER BY id DESC');

        if (!$query) {
            die('Query gagal: ' . mysqli_error($koneksi));
        }

        while ($data = mysqli_fetch_assoc($query)) {
            $id = $data['id'] ?? null;
            $kode_mapel = $data['kode_mapel'] ?? '-';
            $nama_mapel = $data['nama_mapel'] ?? '-';
            $guru_id = $data['guru_id'] ?? '-';
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($kode_mapel); ?></td>
                <td><?= htmlspecialchars($nama_mapel); ?></td>
                <td><?= htmlspecialchars($guru_id); ?></td>
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
    $('#tabelMapel').DataTable({
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
        }
    });
});
</script>
</body>
</html>