

<?php
// Menentukan path utama proyek, yaitu folder 'niki mart' di dalam direktori utama web server
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');
?>
<link rel="stylesheet" href="/niki mart/asset/css/add-cashiers.css">
<?php
// Menyertakan file header.php agar tampilan header muncul di halaman ini
include ROOTPATH . "/includes/header.php";
?>

<!-- Menengahkan seluruh isi halaman -->
<center>
    <!-- Judul halaman form -->
    <h2>Add Cashier</h2>

    <!-- Formulir untuk menambah data kasir baru -->
    <!-- action: file tujuan pengolahan data -->
    <!-- method="POST": mengirim data secara tersembunyi -->
    <form action="/niki mart/process/cashiers_process.php" method="POST">

        <!-- Tabel digunakan untuk merapikan posisi input -->
        <table cellpadding="10">

            <!-- Input tersembunyi yang memberi tahu proses adalah 'add' (tambah data) -->
            <input type="hidden" name="action" value="add" />

            <!-- Baris pertama: input untuk ID kasir -->
            <tr>
                <td><label>Id Kasir:</label></td>
                <td><input type="number" name="id" required /></td>
            </tr>

            <!-- Baris kedua: input untuk nama kasir -->
            <tr>
                <td><label>Nama Kasir</label></td>
                <td><input type="text" name="name_cashier" required /></td>
            </tr>

            <!-- Baris ketiga: tombol untuk menyimpan data -->
            <tr>
                <td></td>
                <td>
                    <!-- Tombol kirim data ke file proses -->
                    <button type="submit" style="float:right">Simpan</button>
                </td>
            </tr>
        </table>
    </form>

</center>

<?php
// Menyertakan file footer.php agar tampilan footer muncul di bagian bawah halaman
include ROOTPATH . "/includes/footer.php";
?>


<!-- 
💡 Ringkasan Fungsi Kode:
	1.	Bagian PHP atas
        🔹 Mengatur lokasi folder utama proyek dan menampilkan header (navigasi, judul, dll).
	2.	Bagian HTML tengah
        🔹 Membuat form untuk menambah data kasir baru (input ID dan nama).
	3.	Bagian PHP bawah
        🔹 Menampilkan footer agar halaman terlihat lengkap dan seragam.

Dengan struktur ini, halaman menjadi modular — bagian header dan footer bisa digunakan ulang di banyak halaman lain (seperti edit.php, list.php, dll). 
-->
