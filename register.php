<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Stok Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .card-auth { max-width: 400px; margin-top: 100px; }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center">
    <div class="card card-auth shadow-sm p-4 w-100">
        <h3 class="text-center mb-4">Register Akun</h3>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" placeholder="Masukkan username">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" placeholder="Masukkan password">
            </div>
            <div class="mb-3">
                <label class="form-label">Daftar Sebagai</label>
                <select class="form-select">
                    <option value="" disabled selected>Pilih status</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            
            <div class="row gx-2">
                <div class="col-6">
                    <button type="button" class="btn btn-primary w-100">Daftar</button>
                </div>
                <div class="col-6">
                    <button type="reset" class="btn btn-outline-secondary w-100">Reset</button>
                </div>
            </div>
            <p class="text-center mt-3 small">Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </form>
    </div>
</div>
</body>
</html>