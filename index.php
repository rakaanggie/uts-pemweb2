<?php
session_start();

// Memeriksa apakah pengguna sudah login atau belum
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    // Jika sudah login, bawa ke dashboard
    header("Location: dashboard.php");
    exit;
} else {
    // Jika belum login, paksa ke halaman login
    header("Location: login.php");
    exit;
}
?>