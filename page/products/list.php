<link rel="stylesheet" href="/niki mart/asset/css/products-list.css">
<?php
// Menentukan lokasi folder utama proyek di server
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');

// Menghubungkan file konfigurasi database
include ROOTPATH . "/config/config.php";

// Menyertakan file header (bagian atas halaman web)
include ROOTPATH . "/includes/header.php";
?>

<br>
<!-- Menampilkan isi halaman di tengah -->
<center>

    <h2><span class="judul-product">Product</span><span  class="judul-available"> Available</span></h2>
    <!-- Tombol untuk menuju halaman tambah produk -->
    <a href="add.php">➕ Add Product</a><br>

    <!-- Membuat tabel daftar produk -->
    <table border="1" cellpadding="20" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Id Voucher</th>
            <th>Product Name</th>
            <th>Unit Price</th>
            <th>Stock</th>
            <th colspan="2" style="text-align: center;">Action</th>
        </tr>

        <?php
        // Inisialisasi nomor urut produk
        $no = 1;

        // Mengambil semua data produk dari tabel 'produk'
        $query = mysqli_query($conn, "SELECT * FROM product");

        // Melakukan perulangan untuk menampilkan setiap produk
        while ($product = mysqli_fetch_assoc($query)) {
        ?>
        <tr>
            <!-- Menampilkan nomor urut -->
            <td><?= $no++ ?></td>

            <!-- Menampilkan ID voucher yang terhubung -->
            <td><?= $product['id_voucher'] ?></td>

            <!-- Menampilkan nama produk -->
            <td><?= $product['name'] ?></td>
            <?php
            // Mengecek apakah produk ini memiliki voucher diskon
            $query_voucher = mysqli_query($conn, "SELECT discount, max_discount FROM vouchers WHERE id = '$product[id_voucher]'");
            $voucher = mysqli_fetch_assoc($query_voucher);

            // Jika produk memiliki voucher, hitung harga setelah diskon
            if (mysqli_num_rows($query_voucher) > 0) {

                // Hitung potongan harga berdasarkan persentase
                $discount_price = $product['unit_price'] - ($product['unit_price'] * $voucher['discount'] / 100);

                // Jika hasil diskon melebihi batas maksimal diskon, batasi dengan max_discount
                if ($discount_price > $voucher['max_discount']) {
                    $discount_price = $product['unit_price'] - $voucher['max_discount'];
                }
            ?>
            <!-- Menampilkan harga asli (dicoret) dan harga setelah diskon -->
            <td>
                <del style="color:red"><?= number_format($product['unit_price'], 0, ',', '.') ?></del>
                <b style="color:green"><?= number_format($discount_price, 0, ',', '.') ?></b>
            </td>

            <?php
            // Jika produk tidak memiliki voucher, tampilkan harga normal
            } else {
            ?>
            <td><?= number_format($product['unit_price'], 0, ',', '.') ?></td>
            <?php
            }
            ?>

            <!-- Menampilkan stok produk -->
            <td><?= $product['stock'] ?></td>

            <!-- Tombol untuk mengedit produk -->
            <td><a href="edit.php?id=<?= $product['id'] ?>">✏️ Edit</a></td>

            <!-- Kolom tombol hapus -->
            <td>

                <?php
                // Mengecek apakah produk sudah digunakan dalam transaksi
                $id_product = $product['id'];
                $cek = mysqli_query($conn, "SELECT id_product FROM transaction_details WHERE id_product = '$id_product'");

                // Jika produk sudah pernah digunakan, tombol hapus dinonaktifkan
                if (mysqli_num_rows($cek) > 0) {
                ?>
                <input type="button" value="Delete" disabled>
                <?php
                // Jika belum pernah digunakan, tampilkan form hapus
                } else {
                ?>
                <form action="/niki mart/process/products_process.php" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= $product['id'] ?>">
                    <input type="submit" value="🗑️ Delete">
                </form>
                <?php
                }
                ?>
            </td>
        </tr>
        <?php
        // Tutup perulangan while
        };
        ?>
    </table>
</center>

<?php
// Menyertakan file footer untuk menutup halaman web
include ROOTPATH . "/includes/footer.php";
?>


<!-- 
🧠 Ringkasan Fungsi Kode:
	1.	Bagian awal:
        🔹 Menyambungkan file konfigurasi dan header.
	2.	Bagian tabel:
        🔹 Menampilkan seluruh data produk dari database.
	3.	Diskon:
        🔹 Jika produk memiliki voucher, harga akan dihitung ulang berdasarkan discount dan max_discount.
        🔹 Harga asli dicoret dan harga diskon berwarna hijau.
	4.	Aksi edit/hapus:
        🔹 Tombol Edit untuk mengubah data produk.
        🔹 Tombol Delete akan dinonaktifkan jika produk sudah digunakan di tabel detail_transaksi.
	5.	Bagian akhir:
        🔹 Menambahkan footer agar tampilan konsisten dengan halaman lain. 
-->
