<?php
require_once dirname(__DIR__) . '/Koneksi.php';
$statusMessages = [
    'added' => 'Mapel berhasil ditambahkan.',
    'updated' => 'Mapel berhasil diperbarui.',
    'deleted' => 'Mapel berhasil dihapus.',
];
$errorMessages = [
    'not_found' => 'Data mapel tidak ditemukan.',
    'failed' => 'Operasi mapel gagal. Silakan coba lagi.',
];
$status = $statusMessages[$_GET['status'] ?? ''] ?? null;
$error = $errorMessages[$_GET['error'] ?? ''] ?? null;
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="../">
    <title>Daftar Mapel</title>
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
<?php require_once dirname(__DIR__) . '/navbar.php'; ?>
<div class="container-fluid table-container">
    <h1 class="judul">Daftar Mapel</h1>
    <?php if ($status) { ?>
        <div class="alert alert-success" role="status"><?= htmlspecialchars($status); ?></div>
    <?php } ?>
    <?php if ($error) { ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error); ?></div>
    <?php } ?>
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-primary" href="MAPEL/Tambah_mapel.php">Tambah Mapel</a>
    </div>
    <table id="tabelMapel" class="table table-striped table-bordered w-100">
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Kode Mapel</th>
                <th>Nama Mapel</th>
                <th>Guru</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $query = mysqli_query($koneksi, "SELECT m.id, m.kode_mapel, m.nama_mapel, m.guru_id,
                COALESCE(g.nama, '-') AS nama_guru
            FROM mapel m
            LEFT JOIN guru g ON g.id = m.guru_id
            ORDER BY m.id ASC");
        if (!$query) {
            die('Query gagal: ' . mysqli_error($koneksi));
        }
        while ($data = mysqli_fetch_assoc($query)) {
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars((string) $data['id']); ?></td>
                <td><?= htmlspecialchars((string) $data['kode_mapel']); ?></td>
                <td><?= htmlspecialchars((string) $data['nama_mapel']); ?></td>
                <td><?= htmlspecialchars((string) $data['nama_guru']); ?></td>
                <td class="text-nowrap">
                    <a class="btn btn-warning btn-sm" href="MAPEL/Edit_mapel.php?id=<?= urlencode((string) $data['id']); ?>">Edit</a>
                    <form class="d-inline" action="MAPEL/Aksi_hapus_mapel.php" method="post" onsubmit="return confirm('Yakin ingin menghapus mapel ini?')">
                        <input type="hidden" name="id" value="<?= htmlspecialchars((string) $data['id']); ?>">
                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#tabelMapel').DataTable({
        pageLength: 10,
        columnDefs: [{ orderable: false, targets: 5 }],
        language: {
            lengthMenu: 'Tampilkan _MENU_ data per halaman',
            search: '',
            searchPlaceholder: 'Search',
            zeroRecords: 'Data tidak ditemukan',
            info: 'Menampilkan halaman _PAGE_ dari _PAGES_',
            infoEmpty: 'Menampilkan halaman 0 dari 0',
            paginate: { previous: 'Sebelumnya', next: 'Selanjutnya' }
        }
    });
});
</script>
<?php require_once dirname(__DIR__) . '/footer.php'; ?>