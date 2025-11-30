<?php
// Menentukan lokasi folder utama proyek agar mudah memanggil file lain
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');

// Menyertakan file konfigurasi database untuk koneksi ke MySQL
include ROOTPATH . "/config/config.php";

// Mengecek apakah data dikirim melalui metode POST (form submit)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Mengambil data dari form: ID transaksi, aksi, dan nama produk
    $action = $_POST['action'];
    $id_transactions = $_POST['id_transactions'];
    $total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(sub_total) AS total FROM transaction_details WHERE id_transactions = $id_transactions"))['total'];
    
    if ($action == 'add') {
        
        $product = $_POST['product'];
        $quantity = $_POST['qty'];
        
        // Mengambil data produk dari database (id, harga_satuan, dan diskon jika ada)
        $product_query = mysqli_query($conn, 
            "SELECT product.id, unit_price, discount 
            FROM product 
            LEFT JOIN vouchers ON product.id_voucher = vouchers.id 
            WHERE product.name = '$product'"
        );
        
        // Validasi apakah produk ditemukan
        if (!$product_query || mysqli_num_rows($product_query) == 0) {
            // Jika produk tidak ditemukan, kembali dengan pesan error
            header("Location: ../page/transactions/transaction_details.php?id=" . $id_transactions . "&error=product_not_found");
            exit;
        }
        
        $tabel_product = mysqli_fetch_assoc($product_query);

        // Menyimpan data hasil query ke variabel
        $id_product = $tabel_product['id'];
        $unit_price = $tabel_product['unit_price'];
        $discount = $tabel_product['discount'] ?? 0; // Default 0 jika NULL

        // Jika produk memiliki diskon
        if ($discount > 0) {
            // Hitung harga setelah diskon
            $unit_price = $unit_price - ($unit_price * $discount / 100);
            // Hitung subtotal berdasarkan kuantitas
            $subtotal = $unit_price * $quantity;
            // Hitung total transaksi saat ini + subtotal baru
            $total = $total + $subtotal;
        } else {
            // Jika tidak ada diskon
            $discount = 0;
            $subtotal = $unit_price * $quantity;
            $total = $total + $subtotal;
        }
    
    
        // Tambahkan data produk ke tabel detail_transaksi
        mysqli_query($conn, 
            "INSERT INTO transaction_details 
             VALUES ('$id_transactions', '$id_product', '$unit_price', '$discount', '$quantity', '$subtotal' )"
        );

        // Perbarui total transaksi di tabel transaksi
        mysqli_query($conn, 
            "UPDATE transactions SET total = $total WHERE id = $id_transactions"
        );
        
        // Perbarui stok produk di tabel produk
        mysqli_query($conn, 
            "UPDATE product SET stock =  stock - $quantity WHERE id = $id_product"
        );

    } elseif ($action == 'pay') {
        // Ambil jumlah bayar dari form
        $total_payment = $_POST['total_payment'];

        mysqli_query($conn, "UPDATE transactions SET pay = $total_payment, change_money = $total_payment - $total, status = 'completed' WHERE id = $id_transactions");
    } 

    // Setelah proses selesai, arahkan kembali ke halaman detail transaksi
    header("Location: ../page/transactions/transaction_details.php?id=" . $id_transactions);
    exit;
}
?>
