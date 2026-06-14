<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}
include 'koneksi.php';

$error_msg = "";

// --- PROSES TAMBAH BARANG (CREATE) ---
if (isset($_POST['tambah'])) {
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "INSERT INTO barang VALUES('', '$nama', '$kategori', '$stok', '$harga')");
    header("Location: dashboard.php");
}

// --- PROSES EDIT BARANG (UPDATE) ---
if (isset($_POST['ubah'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga'];

    mysqli_query($conn, "UPDATE barang SET nama_barang='$nama', kategori='$kategori', stok='$stok', harga='$harga' WHERE id='$id'");
    header("Location: dashboard.php");
}

// --- PROSES HAPUS BARANG (DELETE) dengan Validasi Role Admin ---
if (isset($_GET['hapus'])) {
    if ($_SESSION['role'] === 'admin') {
        $id = $_GET['hapus'];
        mysqli_query($conn, "DELETE FROM barang WHERE id='$id'");
        header("Location: dashboard.php");
        exit;
    } else {
        $error_msg = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        <strong>Gagal!</strong> Anda tidak memiliki akses (Akses Admin Diperlukan) untuk menghapus data.
                        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
                      </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard Stok Barang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Aplikasi Stok Barang</a>
        <div class="d-flex align-items-center">
            <span class="navbar-text me-3 text-white">Halo, <?= $_SESSION['username']; ?>! <span class="badge bg-info text-dark"><?= strtoupper($_SESSION['role']); ?></span></span>
            <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    
    <?= $error_msg; ?>

    <div class="d-flex justify-content-between mb-3">
        <h4>Daftar Stok Barang</h4>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Barang</button>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $query = mysqli_query($conn, "SELECT * FROM barang");
            while ($row = mysqli_fetch_assoc($query)) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $row['nama_barang']; ?></td>
                <td><?= $row['kategori']; ?></td>
                <td><?= $row['stok']; ?></td>
                <td>Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modalUbah<?= $row['id']; ?>">Edit</button>
                    
                    <?php if ($_SESSION['role'] === 'admin') : ?>
                        <a href="dashboard.php?hapus=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
                    <?php endif; ?>
                </td>
            </tr>

            <div class="modal fade" id="modalUbah<?= $row['id']; ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST">
                            <div class="modal-header">
                                <h5 class="modal-title">Ubah Barang</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <div class="mb-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input type="text" name="nama_barang" class="form-control" value="<?= $row['nama_barang']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Kategori</label>
                                    <input type="text" name="kategori" class="form-control" value="<?= $row['kategori']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stok" class="form-control" value="<?= $row['stok']; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Harga</label>
                                    <input type="number" name="harga" class="form-control" value="<?= $row['harga']; ?>" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" name="ubah" class="btn btn-warning">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Barang Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" name="nama_barang" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <input type="text" name="kategori" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <input type="number" name="harga" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>