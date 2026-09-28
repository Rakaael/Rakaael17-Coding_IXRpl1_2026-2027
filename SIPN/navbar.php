<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$isLoggedIn = isset($_SESSION['user_id']);
$navUsername = htmlspecialchars((string) ($_SESSION['username'] ?? ''), ENT_QUOTES, 'UTF-8');
?>
<!-- File Navbar.php berfungsi sebagai template navigasi utama website. -->
<!-- Navbar ini dipanggil dari halaman lain agar menu tetap sama di semua halaman. -->

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        User
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="Daftar_user.php">Daftar User 1</a></li>
                        <li><a class="dropdown-item" href="Daftar_user2.php">Daftar User 2</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="Tambah_user2.php">Tambah user1</a></li>
                        <li><a class="dropdown-item" href="Tambah_user.php">Tambah user2</a></li>
                        <li><a class="dropdown-item" href="Tambah_user3.php">Tambah user3</a></li>
                    </ul>
                </li>
             <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="Mapel.php">Mapel</a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-3">
                <?php if ($isLoggedIn) { ?>
                    <span class="navbar-text"><?= $navUsername; ?></span>
                    <a class="btn btn-outline-secondary" href="Logout.php">Keluar</a>
                <?php } else { ?>
                    <a class="btn btn-outline-primary" href="Login.php">Masuk</a>
                    <a class="btn btn-primary" href="Tambah_user.php">Daftar</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>