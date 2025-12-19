<?php
// Ganti settingan ini sesuai dengan konfigurasi server Anda (XAMPP/Laragon)
$host = "localhost";
$user = "root"; 
$password = ""; 
$database = "bukutamu_RS"; // Sesuaikan dengan nama database yang Anda buat

$koneksi = mysqli_connect($host, $user, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>