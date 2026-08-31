<nav class="navbar navbar-expand-lg bg-white border-bottom">
    <div class="container-fluid px-4">

        <a class="navbar-brand fw-normal" href="index.php">
            Navbar
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMenu">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="index.php">
                        Home
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                       href="#"
                       role="button"
                       data-bs-toggle="dropdown">
                        User
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="Daftar_user.php">
                                Daftar User
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="Daftar_user.php">
                                Daftar User 2
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="Tambah_user.php">
                                Tambah User
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

            <form class="d-flex" role="search">
                <input class="form-control me-2"
                       type="search"
                       placeholder="Search">

                <button class="btn btn-outline-success"
                        type="submit">
                    Search
                </button>
            </form>

        </div>
    </div>
</nav>