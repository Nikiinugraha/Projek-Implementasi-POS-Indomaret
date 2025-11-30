<?php
session_start();
// Memulai sesi PHP agar dapat menyimpan data sementara (seperti id_transaksi)

define('ROOTPATH', $_SERVER['DOCUMENT_ROOT'] . '/niki mart');
// Mendefinisikan konstanta ROOTPATH sebagai path absolut ke folder proyek
// Contoh: /var/www/html/niki mart

include ROOTPATH . "/config/config.php";
// Mengimpor file konfigurasi database (berisi koneksi $conn)

include ROOTPATH . "/includes/header.php";

?>
<link rel="stylesheet" href="/niki mart/asset/css/add-transactions.css">
<?php
// Menyertakan header HTML (biasanya berisi navbar atau CSS Bootstrap)


// Mengecek apakah tombol "next" diklik (form dikirim)
if (@$_POST['next']) {

    // Ambil data transaksi terakhir berdasarkan ID terbesar (transaksi terbaru)
    @$last_code = mysqli_fetch_assoc(mysqli_query($conn, "SELECT code FROM transactions ORDER BY id DESC LIMIT 1"));

    // Ambil ID dan kode transaksi terakhir
    $query = mysqli_query($conn, "SELECT id, code FROM transactions ORDER BY id DESC LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    // Jika sudah ada transaksi sebelumnya
    if ($data) {
        // Ambil kode transaksi terakhir, contoh: TRX0005
        $last_code = $data['code'];  

        // Ambil 4 digit terakhir dari kode (contoh: ambil 0005 → jadi 5)
        $urutan = (int) substr($last_code, 3, 4); 

        // Tambahkan 1 agar menjadi kode transaksi berikutnya
        $urutan++;

        // Bentuk kembali kode transaksi baru dengan awalan "TRX" dan 4 digit angka
        $transaction_code = "TRX" . str_pad($urutan, 4, "0", STR_PAD_LEFT); // hasil: TRX0006

        // Hitung ID baru (jika tidak auto-increment)
        $last_id = $data['id'];
        $id = $last_id + 1;

    } else {
        // Jika belum ada data transaksi sama sekali
        $transaction_code = "TRX0001";
    }


    // Ambil nama kasir yang dipilih dari form
    $cashier_name = $_POST['cashier_name'];

    // Cari ID kasir berdasarkan nama yang diinput
    $cashier = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM cashier WHERE name='$cashier_name'"));
    $id_cashier = $cashier['id'];

    // Atur zona waktu ke WITA (Makassar)
    date_default_timezone_set('Asia/Makassar');

    // Ambil waktu saat ini untuk disimpan sebagai tanggal transaksi
    $date = date("Y-m-d H:i:s");

    // Set total transaksi awal menjadi 0 (karena detail belum ditambahkan)
    $total = 0;

    // Simpan transaksi baru ke tabel `transaksi`
    $query = mysqli_query($conn, "INSERT INTO transactions (id, date, code, id_cashier, total, status) 
                                  VALUES ('$id', '$date', '$transaction_code', '$id_cashier', '$total', 'pending')");

    // Simpan id_transaksi ke session agar bisa digunakan di halaman detail
    $_SESSION['id_transactions'] = $id;

    // Jika proses simpan gagal
    if (!$query) {
        echo "<p>Gagal menyimpan transaksi: " . mysqli_error($conn) . "</p>";
    } else {
        // Jika berhasil, pindah ke halaman detail_transaksi.php
        header('Location: transaction_details.php');
        exit;
    }
}
?>

<br><br>
<center>
    <div style="width:60%; text-align:left;">
        <h2><span class="judul-add">Add</span><span class="judul-transaction"> Transaction</span></h2>
        <hr>
        <form action="" method="POST">

            <!-- Input nama kasir dengan datalist -->
            <label for="cashier_name">Choose Cashier:</label>
            <input type="text" class="form-control" name="cashier_name" placeholder="Type the cashier's name" list="cashier_list"
                required>

            <!-- Datalist berisi daftar nama kasir dari database -->
            <datalist id="cashier_list">
                <?php
                $qCashier = mysqli_query($conn, "SELECT name FROM cashier");
                while($k = mysqli_fetch_assoc($qCashier)) {
                    echo "<option value='{$k['name']}'></option>";
                }
                ?>
            </datalist>
            <br>

            <!-- Tombol kirim -->
            <input type="submit" name="next" class="btn btn-outline-success" value="next">
        </form>
    </div>
</center>


<?php include ROOTPATH . "/includes/footer.php"; ?>
