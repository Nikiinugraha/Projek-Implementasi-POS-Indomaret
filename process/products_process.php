<?php
// Menentukan lokasi folder utama proyek di server
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');

// Menyertakan file konfigurasi database
include ROOTPATH . "/config/config.php";

// Mengambil data dari form
$action     = $_POST['action'];       // Jenis aksi (add, edit, delete)
$name       = $_POST['name'];         // Nama produk
$unit_price = $_POST['unit_price'];   // Harga satuan produk
$stock      = $_POST['stock'];        // Jumlah stok produk

// Mengecek apakah kolom id_voucher diisi atau tidak
if (empty($_POST['id_voucher'])) {
    $id_voucher = "NULL";
} else {
    // Jika diisi, tambahkan tanda kutip agar bisa dimasukkan ke query SQL
    $id_voucher = "'" . $_POST['id_voucher'] . "'";
}

// Mengecek apakah form dikirim dengan metode POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Jika aksi adalah tambah produk baru
    if ($action == 'add') {
        // Menyimpan data baru ke tabel produk
        $query = "INSERT INTO product VALUES (NULL, $id_voucher, '$name', '$unit_price', '$stock')";
        mysqli_query($conn, $query);

    // Jika aksi adalah edit produk
    } elseif ($action == 'edit') {
        $id = $_POST['id']; // Ambil ID produk yang akan diedit
        // Update data produk sesuai ID
        $query = "UPDATE product 
                  SET name='$name', id_voucher=$id_voucher, 
                      unit_price='$unit_price', stock='$stock' 
                  WHERE id=$id";
        mysqli_query($conn, $query) or die(mysqli_error($conn));

    // Jika aksi adalah hapus produk
    } elseif ($action == 'delete') {
        $id = $_POST['id']; // Ambil ID produk yang akan dihapus
        // Cek apakah produk digunakan dalam transaksi
        $check_query = "SELECT COUNT(*) as count FROM transaction_details WHERE id_product = $id";
        $result = mysqli_query($conn, $check_query);
        $count = mysqli_fetch_assoc($result)['count'];
        
        if ($count > 0) {
            // Produk tidak bisa dihapus karena sudah digunakan dalam transaksi
            $_SESSION['error'] = "Produk tidak dapat dihapus karena sudah digunakan dalam $count transaksi!";
            header("Location: ../page/products/list.php");
            exit;
        }
        
        // Hapus data produk dari tabel
        $query = "DELETE FROM product WHERE id=$id";
        mysqli_query($conn, $query);
    }

    // Setelah proses selesai, arahkan kembali ke halaman daftar produk
    header("Location: ../page/products/list.php");
    exit;
}
?>

<!-- 
🧠 Penjelasan Singkat Fungsi File:

File ini berfungsi sebagai file proses produk untuk menangani:
	•	Tambah produk baru (add)
	•	Edit produk (edit)
	•	Hapus produk (delete)

Kode akan otomatis menentukan apakah produk memiliki voucher atau tidak, lalu menjalankan perintah SQL yang sesuai.
Setelah aksi dilakukan, halaman akan redirect ke daftar produk (list.php) agar perubahan langsung terlihat. 
👉 File ini dipakai dari form add.php(insert), edit.php(update), dan list(delete).php
-->
