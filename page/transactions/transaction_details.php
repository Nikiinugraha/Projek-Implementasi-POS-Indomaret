<?php
session_start(); // Memulai sesi PHP agar dapat menyimpan data sementara (seperti id_transaksi)
// Mendefinisikan konstanta ROOTPATH yang menunjuk ke direktori utama project
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');

// Mengimpor file konfigurasi database
include ROOTPATH . "/config/config.php";

// Mengimpor file header (biasanya berisi tampilan awal HTML)
include ROOTPATH . "/includes/header.php";

?>
<link rel="stylesheet" href="/niki mart/asset/css/transaction_details.css">
<?php
// -----------------------------------------------------------
// QUERY 1: Mengambil data transaksi utama (header tabel)
// -----------------------------------------------------------

if(isset($_GET['id'])){
    $id = $_GET['id'];
} else {
    $id = $_SESSION['id_transactions'];
}

// Menjalankan query untuk mengambil data transaksi beserta nama kasir
$header_query = mysqli_query($conn, "SELECT transactions.*, cashier.name AS cashiername 
FROM transactions 
JOIN cashier ON cashier.id = transactions.id_cashier
WHERE transactions.id = " . $id);

// Mengambil satu baris hasil query dalam bentuk array asosiatif
$detail = mysqli_fetch_assoc($header_query);


// -----------------------------------------------------------
// QUERY 2: Mengambil data detail produk yang dibeli
// -----------------------------------------------------------

// Menjalankan query untuk mengambil detail produk dalam transaksi tertentu
$query = mysqli_query($conn, "SELECT product.unit_price AS product_price, transaction_details.*, product.name AS productname, id_voucher 
FROM transaction_details 
JOIN product ON product.id = transaction_details.id_product
JOIN transactions ON transactions.id = transaction_details.id_transactions
LEFT JOIN vouchers ON product.id_voucher = vouchers.id
WHERE transaction_details.id_transactions = " . $id);
?>  


<!-- Bagian tampilan utama halaman -->
<center>
    <h2><span class="judul-transactions-detail">Transactions</span> <span class="judul-detail">Detail</span></h2>
    
    <?php
    // Tampilkan pesan error jika ada
    if (isset($_GET['error']) && $_GET['error'] == 'product_not_found') {
        echo '<div class="error-message">';
        echo '⚠️ Product not found! Please check the product name and try again.';
        echo '</div>';
    }
    ?>

    <div class="transaction-card">

    <?php
    $status_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT status FROM transactions WHERE id = " . $id));
    $status = $status_data['status'] ?? 'pending'; // Default ke 'pending' jika NULL
    if(isset($_POST['pay'])){
    ?>
        <div class="form-container">
            <form action="/niki mart/process/transactions_process.php" method="POST">
                <input type="hidden" name="id_transactions" value="<?= $id ?>" />
                <input type="hidden" name="action" value="pay" />
                <input type="number" placeholder="Total payment" name="total_payment" />
                <input type="submit" class="btn btn-pay" value="Pay" name="payment_process" />
            </form>
        </div>
    <?php    
    }elseif($status == 'completed'){
    ?>
        <div class="success-message">✅ Transaction completed successfully!</div>
        <div class="back-button-container">
            <a href="list.php" class="btn btn-back" style="text-decoration: none;">← Back to Transaction List</a>
        </div>
    <?php        
    }else{
    ?>
        <div class="form-container">
            <form action="/niki mart/process/transactions_process.php" method="POST">
                <input type="hidden" name="id_transactions" value="<?= $id ?>" />
                <input type="hidden" name="action" value="add" />
                <datalist id="product_list">
                <?php
                $query_product = mysqli_query($conn, "SELECT * FROM product LEFT JOIN transaction_details ON product.id = transaction_details.id_product AND transaction_details.id_transactions= '$id' WHERE transaction_details.id_product IS NULL AND stock > 0");
                while($product = mysqli_fetch_assoc($query_product)){
                ?>
                    <option value="<?= $product['name'] ?>">
                <?php
                };
                ?>
                </datalist>

                <input type="text" name="product" list="product_list" placeholder="Search product..." />
                <input type="number" name="qty" placeholder="Quantity" />
                <input type="submit" class="btn btn-add" name="submit" value="Add Product" />
            </form>
        </div>

        <div class="form-container">
            <form action="" method="POST">
                <input type="submit" class="btn btn-pay" name="pay" value="Proceed to Payment" />
            </form>
        </div>
    <?php
    }
    ?>

    <br><br>

    <!-- Tabel untuk menampilkan informasi transaksi -->
    <table border="2" cellpadding="10" cellspacing="0" style="width: 50%; border: solid 2px #000;">

        <!-- Baris pertama: menampilkan tanggal dan informasi kode transaksi serta kasir -->
        <tr>
            <td>
                <?=$detail['date']?>
                <!-- Tanggal transaksi -->
            </td>
            <td colspan="3" style="text-align: right;">
                <?=$detail['code']?>/
                <!-- Kode transaksi -->
                <?=$detail['cashiername']?>/
                <!-- Nama kasir -->
                <?=$detail['id_cashier']?>
                <!-- ID kasir -->
            </td>
        </tr>

        <?php
        // Melakukan perulangan untuk setiap produk yang ada di transaksi
        while($detail_product = mysqli_fetch_assoc($query)){
        ?>
        <tr>
            <!-- Nama produk -->
            <td>
                <?=$detail_product['productname']?>
            </td>

            <!-- Jumlah produk yang dibeli -->
            <td align="center">
                <?=$detail_product['qty']?>
            </td>

            <?php
                // Mengambil ID voucher dari produk (jika ada)
                $voucher_id = $detail_product['id_voucher'];

                // Mengecek apakah produk ini memiliki voucher diskon
                $discount= mysqli_query($conn, "SELECT discount, max_discount FROM vouchers WHERE id = '$voucher_id'");

                // Jika ada voucher yang cocok
                if(mysqli_num_rows($discount) > 0){
                    $discount = mysqli_fetch_assoc($discount);

                    // Menghitung harga setelah diskon berdasarkan persentase
                    $product_price = $detail_product['unit_price'] - ($detail_product['unit_price'] * $discount['discount'] / 100);

                    // Mengecek apakah diskon melebihi batas maksimum (max_discount)
                    if($discount['max_discount'] > 0 && ($detail_product['unit_price'] * $discount['discount'] / 100) > $discount['max_discount']){
                        // Jika iya, maka diskon dibatasi sesuai nilai maksimum
                        $product_price = $detail_product['unit_price'] - $discount['max_discount'];
                    }             
                ?>
            <!-- Menampilkan harga asli (dicoret merah) dan harga setelah diskon -->
             <td align="right">
                <del style="color:red"><?= number_format($detail_product['product_price'], 0, ',', '.') ?></del><br>
                <?= number_format($detail_product['unit_price'], 0, ',', '.') ?>
            </td>
            <?php
                }else{
                ?>
            <!-- Jika tidak ada voucher, tampilkan harga normal -->
            <td align="right"><?= number_format($detail_product['unit_price'], 0, ',', '.') ?></td>
            <?php
                }
            ?>

            <!-- Menampilkan subtotal (harga x qty) -->
            <td align="right">
                <?=number_format($detail_product['sub_total'] ,0,',','.')?>
            </td>
        </tr>
        <?php
        } // Akhir dari perulangan produk
        ?>

        <!-- Baris total akhir transaksi -->
        <tr>
            <td colspan="3" align="right"><strong>Total</strong></td>
            <td align="right">
                <strong><?=number_format($detail['total'] ,0,',','.')?></strong> <!-- Total harga transaksi -->
            </td>
        </tr>
        <?php
        if($status == 'completed'){
        ?>
        <tr>
            <td colspan="3" align="right"><strong>Pay</strong></td>
            <td align="right">
                <strong><?=number_format($detail['pay'] ,0,',','.')?></strong>
            </td>
        </tr>

        <tr>
            <td colspan="3" align="right"><strong>Money Change</strong></td>
            <td align="right">
                <strong><?=number_format($detail['change_money'] ,0,',','.')?></strong>
            </td>
        </tr>
        <?php
        }
        ?>

    </table>
    </div>
    
</center>


<?php
// Menyertakan file footer (biasanya berisi penutup HTML)
include ROOTPATH . "/includes/footer.php";
?>

<!-- 
        Bagian Kode                                     Fungsi Utama
define('ROOTPATH', ...)                         Menentukan direktori utama proyek
include config.php                              Menghubungkan ke database
include header.php/footer.php                   Menyusun tampilan halaman
Query transaksi                                 Mengambil data utama transaksi
Query detail_transaksi                          Mengambil detail barang di transaksi
Perulangan while                                Menampilkan setiap produk dalam transaksi
Logika voucher                                  Menghitung harga diskon (dengan batas maksimum)
number_format()                                 Memformat angka agar mudah dibaca (misal: 10.000)
-->
