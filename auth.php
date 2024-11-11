<?php
session_start(); // Memulai sesi

function checkLogin() {
    // Periksa apakah user_id ada di dalam sesi
    if (!isset($_SESSION['user_id'])) {
        // Jika tidak ada, arahkan ke halaman login
        header("Location: login.php");
        exit();
    }
}
?>
