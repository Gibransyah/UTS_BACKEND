<?php
$host = 'localhost';
$dbname = 'uts_backend';
$username = 'root';
$password = 'Gibran2507_'; 

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
?>
