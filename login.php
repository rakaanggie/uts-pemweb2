<?php
session_start();
include 'koneksi.php';
$alert = "";

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $status   = isset($_POST['role']) ? $_POST['role'] : '';

    if (empty($username) || empty($password) || empty($status)) {
        $alert = "<div class='alert alert-danger'>Semua form wajib diisi!</div>";
    } else {
        // MENCOCOKKAN USERNAME DAN STATUS (ROLE) SEKALIGUS KE DATABASE
        $query = "SELECT * FROM users WHERE username = '$username' AND role = '$status'";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            
            // Verifikasi password (bisa teks biasa atau password_hash)
            if (password_verify($password, $row['password']) || $password === $row['password']) {
                $_SESSION['login'] = true;
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role']; 
                
                header("Location: dashboard.php");
                exit;
            }
        }
        // Jika salah satu dari tiga inputan tidak cocok
        $alert = "<div class='alert alert-danger'>Username, Password, atau Status salah!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Stok Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card-auth { max-width: 400px; margin-top: 100px; }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="card card-auth shadow-sm p-4 w-100">
        <h3 class="text-center mb-4">Login Pengguna</h3>
        
        <?= $alert; ?>
        
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="role" class="form-select" required>
                    <option value="" disabled selected>Pilih status</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            
            <div class="row gx-2">
                <div class="col-6">
                    <button type="submit" name="login" class="btn btn-primary w-100">Masuk</button>
                </div>
                <div class="col-6">
                    <button type="reset" class="btn btn-outline-secondary w-100">Reset</button>
                </div>
            </div>
            <p class="text-center mt-3 small">Belum punya akun? <a href="register.php">Daftar di sini</a></p>
        </form>
    </div>
</div>
</body>
</html>