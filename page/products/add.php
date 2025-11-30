<?php
// Menentukan path utama proyek (folder 'indomaret_RPL4' di dalam server web)
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');
?>
<link rel="stylesheet" href="/niki mart/asset/css/add-products.css">
<?php
// Menyertakan file konfigurasi database untuk koneksi MySQL
include ROOTPATH . "/config/config.php";

// Menyertakan file header agar bagian atas halaman (judul/menu) tampil
include ROOTPATH . "/includes/header.php";
?>

<!-- Menengahkan seluruh isi halaman -->
<center>

    <!-- Judul halaman -->
    <h2>Add produk</h2>

    <!-- Formulir untuk menambahkan produk baru -->
    <!-- action: file tujuan untuk memproses data -->
    <!-- method="POST": mengirim data secara tersembunyi -->
    <form action="/niki mart/process/products_process.php" method="POST">

        <!-- Tabel untuk menata posisi input -->
        <table cellpadding="10">

            <!-- Input tersembunyi, memberi tahu proses adalah 'add' (tambah data) -->
            <input type="hidden" name="action" value="add" />

            <!-- Baris pertama: input nama produk -->
            <tr>
                <td><label>Nama Produk:</label></td>
                <td><input type="text" name="name" required /></td>
            </tr>

            <!-- Daftar pilihan voucher yang diambil dari database -->
            <datalist id="voucher_list">
                <?php
                // Mengambil semua data dari tabel 'voucher'
                $query = mysqli_query($conn, "SELECT * FROM vouchers");

                // Menampilkan setiap voucher sebagai opsi dalam datalist
                while ($vouchers = mysqli_fetch_assoc($query)) {
                ?>
                <!-- Menampilkan id voucher sebagai nilai, dan nama + diskon sebagai teks -->
                <option value="<?= $vouchers['id'] ?>">
                    <?= $vouchers['name'] ?> - <?= $vouchers['discount'] ?>%
                </option>
                <?php
                }
                ?>
            </datalist>

            <!-- Baris kedua: input untuk memilih voucher -->
            <!-- Menggunakan atribut 'list' untuk terhubung ke datalist di atas -->
            <tr>
                <td><label>Voucher:</label></td>
                <td><input type="text" list="voucher_list" name="id_voucher" /></td>
            </tr>

            <!-- Baris ketiga: input harga produk -->
            <tr>
                <td><label>Harga:</label></td>
                <td><input type="number" name="unit_price" required /></td>
            </tr>

            <!-- Baris keempat: input stok produk -->
            <tr>
                <td><label>Stok:</label></td>
                <td><input type="number" name="stock" required /></td>
            </tr>

            <!-- Baris terakhir: tombol simpan data -->
            <tr>
                <td></td>
                <td>
                    <button type="submit" style="float:right">Simpan</button>
                </td>
            </tr>
        </table>
    </form>

</center>

<?php
// Menyertakan file footer agar bagian bawah halaman tampil
include ROOTPATH . "/includes/footer.php";
?>

<!-- 💡 Ringkasan Fungsi Kode
	1.	Bagian PHP atas
        🔹 Menentukan lokasi proyek, menyambungkan ke database, dan menampilkan header.
	2.	Bagian HTML (form tambah produk)
        🔹 Menampilkan form untuk menambahkan produk baru ke database.
        🔹 Memiliki kolom: Nama Produk, Voucher, Harga, dan Stok.
        🔹 Voucher diambil otomatis dari tabel voucher menggunakan elemen <datalist>.
	3.	Bagian PHP bawah
        🔹 Menampilkan footer agar halaman terlihat lengkap dan seragam dengan halaman lain. 

Dengan kata lain, halaman ini berfungsi untuk menambah produk baru dan secara otomatis menampilkan daftar voucher yang sudah ada di database agar bisa dikaitkan dengan produk tersebut.
-->
