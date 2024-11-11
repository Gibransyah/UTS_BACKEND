<?php
session_start();
include 'db.php'; // Memasukkan koneksi database

// Cek apakah pengguna adalah dosen
if ($_SESSION['role'] !== 'dosen') {
    header("Location: login.php");
    exit();
}

// Periksa apakah nilai di-post
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['grades'])) {
    foreach ($_POST['grades'] as $id => $grade) {
        $stmt = $conn->prepare("UPDATE grades SET grade = ? WHERE id = ?");
        $stmt->bind_param("di", $grade, $id);
        $stmt->execute();
    }
    header("Location: dosen_dashboard.php?status=success");
    exit();
} else {
    header("Location: dosen_dashboard.php?status=error");
    exit();
}
?>
