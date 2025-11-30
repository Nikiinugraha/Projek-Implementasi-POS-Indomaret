<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "niki_mart";

// Membuat koneksi
$conn = mysqli_connect($host, $user, $password, $dbname);
// $conn = mysqli_connect('localhost', 'root', '', 'niki_mart');


// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
