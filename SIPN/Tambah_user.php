<!DOCTYPE html>
<html>
<head>
    <title>Form Tambah User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 20px;
        }
        form {
            max-width: 500px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            margin-top: 15px;
            padding: 10px 18px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        .btn-save {
            background: #28a745;
            color: #fff;
        }
        .btn-reset {
            background: #6c757d;
            color: #fff;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Form Tambah User</h2>

<form action="proses_tambah.php" method="POST">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Role</label>
    <select name="role" required>
        <option value="siswa">Siswa</option>
        <option value="guru">Guru</option>
        <option value="admin">Admin</option>
    </select>

    <button type="submit" class="btn-save">Simpan Data</button>
    <button type="reset" class="btn-reset">Reset</button>
</form>

</body>
</html>
