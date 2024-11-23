<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

$nama = $_POST['nama'];
$harga_satuan = $_POST['harga_satuan'];
$stok = $_POST['stok'];
$merek = $_POST['merek'];
$kategori = $_POST['kategori'];

$_SESSION['input_nama'] = $nama;
$_SESSION['input_harga'] = $harga_satuan;
$_SESSION['input_stok'] = $stok;
$_SESSION['input_merek'] = $merek;

$query_cek = "SELECT * FROM barang WHERE LOWER(nama_barang) = LOWER('$nama')";
$result_cek = mysqli_query($koneksi, $query_cek);
if (mysqli_num_rows($result_cek) > 0) {
    $_SESSION['tambah_errorN'] = true;
    echo '<script>
            window.location = "tambah_barang.php";
          </script>';
    exit;
}

// proses kirim gambar
$kirim_folder = "../img/";
$ke_file = $kirim_folder . basename($_FILES["gambar"]["name"]);

$tipe_file = $_FILES['gambar']['type'];
$ukuran_file = $_FILES['gambar']['size'];

$tipe = array("image/jpeg", "image/png");
$maximal_ukuran = 5 * 1024 * 1024; // maksimal ukuran 5MB

if (!in_array($tipe_file, $tipe)) {
    $_SESSION['tambah_errorT'] = true;
    echo '<script>
            window.location = "tambah_barang.php";
          </script>';
}

if ($ukuran_file > $maximal_ukuran) {
    $_SESSION['tambah_errorU'] = true;
    echo '<script>
            window.location = "tambah_barang.php";
          </script>';
}

if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $ke_file)) {
    $query = "INSERT INTO barang (nama_barang, harga_satuan, stok, merek, gambar, id_kategori) 
              VALUES ('$nama', '$harga_satuan', '$stok', '$merek', '$ke_file', '$kategori')";

    if ($koneksi->query($query) === TRUE) {
        $_SESSION['tambah_success'] = true;
        echo '<script>
                window.location="barang.php";
              </script>';
    } else {
        echo "Error: " . $query . "<br>" . $koneksi->error;
    }
} else {
    $_SESSION['tambah_errorG'] = true;
    echo '<script>
            window.location="tambah_barang.php";
          </script>';
}
?>