<?php
// Menentukan path utama proyek, yaitu folder 'indomaret_RPL4' di dalam server web
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');
?>
<link rel="stylesheet" href="/niki mart/asset/css/products-edit.css">
<?php
// Menyertakan file konfigurasi untuk koneksi database MySQL
include ROOTPATH . "/config/config.php";

// Menyertakan file header agar bagian atas halaman (navigasi/judul) tampil
include ROOTPATH . "/includes/header.php";

// Mengambil data product berdasarkan ID dari URL (parameter GET)
$product = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM product WHERE id = '$_GET[id]'"));
?>

<!-- Menengahkan isi halaman -->
<center>

    <!-- Judul halaman -->
    <h2>Edit product</h2>

    <!-- Formulir untuk mengedit data product yang sudah ada -->
    <form action="/niki mart/process/products_process.php" method="POST">

        <!-- Tabel digunakan untuk menata posisi input -->
        <table cellpadding="10">

            <!-- Input tersembunyi untuk memberi tahu proses yang dilakukan adalah 'edit' -->
            <input type="hidden" name="action" value="edit" />

            <!-- Menyimpan ID product yang sedang diedit agar bisa dikenali saat update -->
            <input type="hidden" name="id" value="<?= $product['id'] ?>" />

            <!-- Baris input nama product -->
            <tr>
                <td><label>Nama product:</label></td>
                <!-- Menampilkan nama product yang diambil dari database -->
                <td><input type="text" name="name" value="<?= $product['name'] ?>" required /></td>
            </tr>

            <!-- Datalist: berisi daftar vouchers dari tabel 'vouchers' di database -->
            <datalist id="voucher_list">
                <?php
                // Mengambil semua data vouchers dari tabel 'vouchers'
                $query = mysqli_query($conn, "SELECT * FROM vouchers");

                // Menampilkan setiap voucher dalam daftar pilihan
                while ($vouchers = mysqli_fetch_assoc($query)) {
                ?>
                <!-- Menampilkan ID vouchers sebagai nilai dan nama+diskon sebagai teks -->
                <option value="<?= $vouchers['id'] ?>"><?= $vouchers['name'] ?> - <?= $vouchers['discount'] ?>%</option>
                <?php
                }
                ?>
            </datalist>

            <!-- Baris input untuk memilih vouchers yang digunakan oleh product -->
            <tr>
                <td><label>vouchers:</label></td>
                <td>
                    <!-- Nilai default diambil dari kolom 'id_vouchers' product -->
                    <input type="text" list="voucher_list" name="id_voucher" value="<?= $product['id_voucher'] ?>" />
                </td>
            </tr>

            <!-- Baris input harga satuan -->
            <tr>
                <td><label>Harga:</label></td>
                <!-- Nilai diisi otomatis dari kolom 'unit_price' product -->
                <td><input type="number" name="unit_price" value="<?= $product['unit_price'] ?>" required /></td>
            </tr>

            <!-- Baris input stok product -->
            <tr>
                <td><label>Stok:</label></td>
                <!-- Nilai diisi otomatis dari kolom 'stock' product -->
                <td><input type="number" name="stock" value="<?= $product['stock'] ?>" required /></td>
            </tr>

            <!-- Tombol simpan perubahan -->
            <tr>
                <td>
                    <button type="submit" style="float:right">Simpan</button>
                </td>
            </tr>

        </table>
    </form>
</center>

<?php
// Menyertakan file footer agar bagian bawah halaman tampil (penutup halaman)
include ROOTPATH . "/includes/footer.php";
?>

<!-- 
💡 Ringkasan Fungsi Kode
	1.	Bagian awal (PHP):
        🔹 Menghubungkan ke database dan memuat data product berdasarkan ID dari URL.
	2.	Bagian form (HTML):
        🔹 Menampilkan data product dalam form untuk diedit.
        🔹 Dapat mengganti nama product, vouchers, harga, dan stok.
        🔹 vouchers ditampilkan dari tabel vouchers dalam bentuk pilihan otomatis.
	3.	Bagian akhir:
        🔹 Menyertakan footer agar tampilan halaman seragam dengan halaman lain.

➡️ Kesimpulan:
Kode ini digunakan untuk mengedit data product yang sudah ada di database dengan menampilkan informasi lama di form, lalu menyimpan perubahan melalui file products_process.php. 
-->
