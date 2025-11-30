<link rel="stylesheet" href="/niki mart/asset/css/transactions-list.css">

<?php
// Mendefinisikan konstanta ROOTPATH yang menunjuk ke folder utama proyek
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');

// Mengimpor file konfigurasi database (berisi koneksi ke MySQL)
include ROOTPATH . "/config/config.php";

// Mengimpor file header (biasanya berisi HTML awal atau menu navigasi)
include ROOTPATH . "/includes/header.php";
?>
<br>

<!-- Bagian tampilan halaman utama -->
<center>

    <h2><span class="judul-transactions">Transactions</span> <span class="judul-history">History</span></h2>
    <!-- Tombol untuk menambah transaksi baru -->
    <a href="add.php">➕ Add Transaksi</a><br><br>

    <!-- Tabel utama untuk menampilkan daftar transaksi -->
    <table border="1" cellpadding="40" cellspacing="0">
        <tr>
            <th>No</th> <!-- Nomor urut -->
            <th>Date</th> <!-- Tanggal transaksi -->
            <th>Transaction Code</th> <!-- Kode unik transaksi -->
            <th>Id Cashier</th> <!-- Nama kasir yang menangani -->
            <th>Total</th> <!-- Total harga transaksi -->
            <th colspan="2" style="text-align: center;">Action</th> <!-- Kolom aksi (lihat, edit, hapus) -->
        </tr>

        <?php
        // Inisialisasi nomor urut
        $no = 1;

        // Menjalankan query untuk mengambil transaksi yang sudah selesai beserta data kasir terkait
        $query = mysqli_query($conn, "SELECT *, transactions.id AS id_transactions FROM transactions JOIN cashier ON transactions.id_cashier = cashier.id WHERE transactions.status = 'completed'");

        // Melakukan perulangan untuk menampilkan setiap baris data transaksi
        while($transactions = mysqli_fetch_assoc($query)){
        ?>
        <tr>
            <!-- Menampilkan nomor urut -->
            <td><?= $no++ ?></td>

            <!-- Menampilkan tanggal transaksi -->
            <td><?=$transactions['date']?></td>

            <!-- Menampilkan kode transaksi -->
            <td><?=$transactions['code']?></td>

            <!-- Menampilkan nama kasir -->
            <td><?=$transactions['name']?></td>

            <!-- Menampilkan total harga transaksi -->
            <td>Rp <?= number_format($transactions['total'], 0, ',', '.') ?></td>

            <!-- Tombol untuk melihat detail transaksi -->
            <td>
                <a href="transaction_details.php?id=<?= $transactions['id_transactions'] ?>">🔍 Details</a>
            </td>

            <!-- Tombol untuk menghapus transaksi -->
            <td>
                <?php
                // Mengecek apakah transaksi ini memiliki detail produk (relasi ke detail_transaksi)
                $id_product = $transactions['id'];
                $check = mysqli_query($conn, "SELECT id_transactions FROM transaction_details WHERE id_transactions = '$id_product'");

                // Jika transaksi sudah punya detail produk, maka tidak boleh dihapus
                if(mysqli_num_rows($check) > 0){
                ?>
                <!-- Tombol delete dinonaktifkan jika ada detail transaksi -->
                <input type="button" value="delete" disabled>
                <?php
                }else{
                ?>
                <!-- Jika tidak ada detail transaksi, maka bisa dihapus -->
                <form action="/niki mart/process/products_process.php" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                    <!-- Menentukan aksi delete untuk file process -->
                    <input type="hidden" name="action" value="delete">
                    <!-- Mengirim ID transaksi yang ingin dihapus -->
                    <input type="hidden" name="id" value="<?=$transactions['id']?>">
                    <!-- Tombol submit untuk menghapus -->
                    <input type="submit" value="delete">
                </form>
                <?php
                }
                ?>
            </td>
        </tr>
        <?php
        } // Akhir dari perulangan while
        ?>
    </table>
</center>

<?php
// Mengimpor file footer (biasanya berisi penutup HTML)
include ROOTPATH . "/includes/footer.php";
?>


<!-- 
        Bagian Kode                                                             Fungsi
define('ROOTPATH', ...)                                         Menentukan lokasi folder utama proyek untuk memudahkan include.
include config.php                                              Menghubungkan file ke database MySQL.
include header.php                                              Menampilkan tampilan awal HTML dan navigasi.
<a href="add.php">Add transaksi</a>                             Tombol untuk menambah transaksi baru.
mysqli_query($conn, "SELECT * FROM transaksi JOIN kasir...")    Mengambil semua data transaksi dan nama kasir.
while($transactions = mysqli_fetch_assoc(...))                     Menampilkan setiap transaksi dalam tabel.
Lihat Detail                                                    Mengarah ke halaman detail transaksi berdasarkan id.
edit.php?id=...                                                 Mengarah ke halaman untuk mengedit transaksi.
Logika if(mysqli_num_rows($cek) > 0)                            Mengecek apakah transaksi punya detail produk (agar tidak bisa dihapus).
Form process/products_process.php                               Mengirim permintaan hapus data ke file pemrosesan.
include footer.php                                              Menutup halaman dengan tampilan footer. 
-->
