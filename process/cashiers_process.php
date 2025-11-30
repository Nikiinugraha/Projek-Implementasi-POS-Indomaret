<?php
// Menentukan lokasi folder utama proyek
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');

// Menyertakan file konfigurasi database
include ROOTPATH . "/config/config.php";

// Mengecek apakah data dikirim melalui metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Mengambil data dari form (id, action, dan name)
    $id = $_POST['id'];
    $action = $_POST['action'];
    $name = $_POST['name_cashier'];
    
    // Jika aksi = tambah kasir
    if ($action == 'add') {
        // Menyimpan data baru ke tabel kasir
        $query = "INSERT INTO cashier VALUES ('$id', '$name')";
        mysqli_query($conn, $query);

    // Jika aksi = edit cashier
    } elseif ($action == 'edit') {
        // Mengubah data cashier berdasarkan ID
        $query = "UPDATE cashier SET name='$name' WHERE id=$id";
        mysqli_query($conn, $query);

    // Jika aksi = hapus cashier
    } elseif ($action == 'delete') {
        // Menghapus data cashier berdasarkan ID
        $query = "DELETE FROM cashier WHERE id=$id";
        mysqli_query($conn, $query);

        // Debug (opsional, digunakan saat pengujian)
        // var_dump($query);
    }

    // Setelah proses selesai, arahkan kembali ke halaman daftar kasir
    header("Location: ../page/cashiers/list.php");
    exit;
}

?>
<!-- 
🧠 Penjelasan Singkat:

Kode ini berfungsi sebagai file proses (process file) untuk tabel kasir — menangani semua aksi dari form seperti:
	•	Tambah data (add)
	•	Edit data (edit)
	•	Hapus data (delete)

Setelah aksi dijalankan, pengguna akan otomatis diarahkan kembali ke halaman daftar kasir (list.php).

👉 File ini dipakai dari form add.php(insert), edit.php(update), dan list(delete).php 
-->
