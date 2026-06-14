<?php
session_start();
// Hapus semua session
$_SESSION = [];
session_unset();
session_destroy();

// Alihkan ke halaman login
header("Location: login.php");
exit;
?>