<?php
// Konfigurasi Database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "money_heist";

// Melakukan Koneksi
$conn = mysqli_connect($host, $user, $pass, $db);

// Cek jika koneksi gagal
if (!$conn) {
    die("Koneksi Database Gagal: " . mysqli_connect_error());
}
?>