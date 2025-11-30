<?php
// Menentukan path utama proyek (lokasi folder 'indomaret_RPL4' di dalam web server)
define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');
?>
<link rel="stylesheet" href="/niki mart/asset/css/edit-cashiers.css">
<?php

// Memanggil file konfigurasi database (berisi koneksi ke MySQL)
include ROOTPATH . "/config/config.php";

// Memanggil file header agar tampilan atas halaman muncul (judul, menu, dll)
include ROOTPATH . "/includes/header.php";
// Mengecek apakah parameter 'id' dikirim lewat URL
if (isset($_GET['id'])) {
    // Jika ada, simpan nilainya ke variabel $id
    $id = $_GET['id'];
} else {
    // Jika tidak ada, beri nilai default 0
    $id = 0;
}

// Menyiapkan variabel $cashier untuk menampung data kasir
$cashier = null;

// Jika id lebih dari 0, lakukan pencarian data kasir di database
if ($id > 0) {
    // Jalankan query untuk mengambil data kasir berdasarkan id
    $result = mysqli_query($conn, "SELECT * FROM cashier WHERE id = $id");

    // Jika hasil ditemukan dan ada datanya, simpan ke variabel $cashier
    if ($result && mysqli_num_rows($result) > 0) {
        $cashier = mysqli_fetch_assoc($result);
    }
}

// Jika data kasir tidak ditemukan, tampilkan pesan dan hentikan proses
if (!$cashier) {
    echo "<p>Cashier not found.</p>";
    include ROOTPATH . "/includes/footer.php"; // tampilkan footer
    exit; // hentikan eksekusi kode
}
?>

<!-- Menengahkan seluruh isi halaman -->
<center>

    <!-- Judul halaman form -->
    <h2>Edit Cashier</h2>

    <!-- Formulir untuk mengedit data kasir -->
    <!-- action: file tujuan yang memproses data -->
    <!-- method="post": mengirim data secara tersembunyi -->
    <form action="/niki mart/process/cashiers_process.php" method="post">

        <!-- Tabel untuk menata posisi input -->
        <table cellpadding="10">

            <!-- Input tersembunyi untuk memberitahu proses adalah 'edit' -->
            <input type="hidden" name="action" value="edit" />

            <!-- Input tersembunyi untuk mengirim ID kasir yang sedang diedit -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($cashier['id']); ?>" />

            <!-- Baris pertama: input nama kasir yang akan diedit -->
            <tr>
                <td><label>Cashier Name:</label></td>
                <td>
                    <!-- Menampilkan nama kasir lama di kolom input -->
                    <input type="text" name="name_cashier" value="<?php echo htmlspecialchars($cashier['name']); ?>" required />
                </td>
            </tr>

            <!-- Baris kedua: tombol untuk menyimpan perubahan -->
            <tr>
                <td></td>
                <td>
                    <!-- Tombol untuk mengirim data ke file proses -->
                    <button type="submit" style="float:right">Update</button>
                </td>
            </tr>
        </table>
    </form>

</center>

<?php
// Menyertakan footer agar bagian bawah halaman tampil
include ROOTPATH . "/includes/footer.php";
?>

<!-- 
💡 Ringkasan Fungsi Kode:
	1.	Bagian awal (PHP atas)
        🔹 Menentukan lokasi proyek, menyambung ke database, dan memanggil header.
        🔹 Mengecek apakah ada parameter id di URL.
        🔹 Mengambil data kasir dari tabel kasir berdasarkan id.
	2.	Bagian HTML (form edit)
        🔹 Menampilkan form dengan data kasir yang sudah ada.
        🔹 User bisa mengubah nama kasir dan menekan tombol Update.
	3.	Bagian akhir (PHP bawah)
        🔹 Menampilkan footer dan mengakhiri halaman.

Dengan struktur ini, halaman edit.php berfungsi untuk menampilkan data kasir yang akan diedit, dan setelah tombol Update ditekan, data dikirim ke cashiers_process.php untuk diproses di server. 
-->
