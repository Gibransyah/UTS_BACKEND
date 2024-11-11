<?php
include 'db.php'; // Memasukkan koneksi database

// Buat pengguna jika belum ada
$username = 'admin'; // Contoh username
$password = password_hash('admin', PASSWORD_DEFAULT); // Contoh password yang dienkripsi
$role = 'admin'; // Role pengguna

// Cek apakah pengguna sudah ada
$result = $conn->query("SELECT * FROM users WHERE username = '$username'");
if ($result->num_rows === 0) {
    // Jika belum ada, masukkan pengguna baru
    $conn->query("INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");
    echo "Pengguna admin berhasil ditambahkan.<br>";
} else {
    echo "Pengguna admin sudah ada.<br>";
}

// Tambahkan pengguna dosen
$username = 'dosen'; // Contoh username dosen
$password = password_hash('dosen', PASSWORD_DEFAULT); // Contoh password yang dienkripsi
$role = 'dosen'; // Role pengguna

// Cek apakah pengguna sudah ada
$result = $conn->query("SELECT * FROM users WHERE username = '$username'");
if ($result->num_rows === 0) {
    // Jika belum ada, masukkan pengguna baru
    $conn->query("INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");
    echo "Pengguna dosen berhasil ditambahkan.<br>";
} else {
    echo "Pengguna dosen sudah ada.<br>";
}

// Tambahkan pengguna mahasiswa
$username = 'mahasiswa'; // Contoh username mahasiswa
$password = password_hash('mahasiswa', PASSWORD_DEFAULT); // Contoh password yang dienkripsi
$role = 'mahasiswa'; // Role pengguna

// Cek apakah pengguna sudah ada
$result = $conn->query("SELECT * FROM users WHERE username = '$username'");
if ($result->num_rows === 0) {
    // Jika belum ada, masukkan pengguna baru
    $conn->query("INSERT INTO users (username, password, role) VALUES ('$username', '$password', '$role')");
    echo "Pengguna mahasiswa berhasil ditambahkan.<br>";
} else {
    echo "Pengguna mahasiswa sudah ada.<br>";
}

// Tutup koneksi
$conn->close();
?>
