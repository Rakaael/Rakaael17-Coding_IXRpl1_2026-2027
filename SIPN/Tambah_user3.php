<?php
// File ini berisi form tambah user yang fleksibel untuk siswa, guru, maupun admin.
// Ketika role dipilih, field profil akan otomatis tampil sesuai kebutuhan.
require_once __DIR__ . '/Navbar.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border border-2 border-secondary-subtle rounded-4 shadow-sm" style="background: #f7f7f7;">
                <div class="card-body p-4 p-md-5">
                    <form action="proses_tambah.php" method="POST">
                        <h1 class="fw-normal text-center mb-4" style="font-size: 3rem;">Form Tambah User</h1>

                        <div class="mb-3">
                            <input type="text" name="username" class="form-control form-control-lg border-0 rounded-3" style="background: #e9eefb; height: 50px;" placeholder="Username Akun | Contoh: matthias231" required>
                        </div>

                        <div class="mb-3">
                            <input type="password" name="password" class="form-control form-control-lg border-0 rounded-3" style="background: #e9eefb; height: 50px;" placeholder="Password | Contoh: 123456" required>
                        </div>

                        <div class="mb-4">
                            <label for="role" class="form-label fw-semibold">Role</label>
                            <select class="form-select form-select-lg border-0 rounded-3" id="role" name="role" style="background: #e9eefb; height: 50px;" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="siswa">Siswa</option>
                                <option value="guru">Guru</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>

                        <div id="profile-fields" style="display: none;">
                            <div class="mb-3" id="nis-wrapper" style="display: none;">
                                <input type="text" name="nis" id="nis" class="form-control form-control-lg border-0 rounded-3" style="background: #e9eefb; height: 50px;" placeholder="NIS | Contoh: 1234567890">
                            </div>

                            <div class="mb-3" id="nip-wrapper" style="display: none;">
                                <input type="text" name="nip" id="nip" class="form-control form-control-lg border-0 rounded-3" style="background: #e9eefb; height: 50px;" placeholder="NIP | Contoh: 1987654321">
                            </div>

                            <div class="mb-3">
                                <input type="text" name="nama" id="nama" class="form-control form-control-lg border-0 rounded-3" style="background: #e9eefb; height: 50px;" placeholder="Nama Lengkap | Contoh: Matthias Von Herdhart">
                            </div>

                            <div class="mb-3" id="kelas-wrapper" style="display: none;">
                                <input type="text" name="kelas" id="kelas" class="form-control form-control-lg border-0 rounded-3" style="background: #e9eefb; height: 50px;" placeholder="Kelas | Contoh: XI RPL 1">
                            </div>

                            <div class="mb-4" id="jenis-kelamin-wrapper" style="display: none;">
                                <label class="form-label fw-semibold mb-2">Jenis Kelamin</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="jenis_kelamin" id="laki3" value="L">
                                        <label class="form-check-label" for="laki3">Laki-laki</label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" name="jenis_kelamin" id="perempuan3" value="P">
                                        <label class="form-check-label" for="perempuan3">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="submit" class="btn btn-primary btn-lg px-4">Submit</button>
                            <a href="Daftar_user.php" class="btn btn-secondary btn-lg px-4">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('role');
        const profileFields = document.getElementById('profile-fields');
        const nisWrapper = document.getElementById('nis-wrapper');
        const nipWrapper = document.getElementById('nip-wrapper');
        const kelasWrapper = document.getElementById('kelas-wrapper');
        const jenisKelaminWrapper = document.getElementById('jenis-kelamin-wrapper');
        const nisInput = document.getElementById('nis');
        const nipInput = document.getElementById('nip');
        const namaInput = document.getElementById('nama');
        const kelasInput = document.getElementById('kelas');
        const genderInputs = document.querySelectorAll('input[name="jenis_kelamin"]');

        function toggleProfileFields() {
            const role = roleSelect.value;
            const showProfile = role !== '';

            profileFields.style.display = showProfile ? 'block' : 'none';
            nisWrapper.style.display = role === 'siswa' ? 'block' : 'none';
            nipWrapper.style.display = role === 'guru' ? 'block' : 'none';
            kelasWrapper.style.display = role === 'siswa' ? 'block' : 'none';
            jenisKelaminWrapper.style.display = showProfile ? 'block' : 'none';

            if (nisInput) nisInput.required = role === 'siswa';
            if (nipInput) nipInput.required = role === 'guru';
            namaInput.required = showProfile;
            if (kelasInput) kelasInput.required = role === 'siswa';
            genderInputs.forEach(function (input) {
                input.required = showProfile;
            });
        }

        roleSelect.addEventListener('change', toggleProfileFields);
        toggleProfileFields();
    });
</script>

<?php require_once __DIR__ . '/Footer.php'; ?>