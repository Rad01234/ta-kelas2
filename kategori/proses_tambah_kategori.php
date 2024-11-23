<?php
include("../koneksi.php");
session_start();


if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

$nama = $_POST['namaT'];

$query_cek = "SELECT * FROM kategori WHERE LOWER(nama_kategori) = LOWER('$nama')";
$result_cek = mysqli_query($koneksi, $query_cek);
if (mysqli_num_rows($result_cek) > 0) {
    $_SESSION['tambah_error'] = true;
    echo '<script>
            window.location = "kategori.php";
          </script>';
    exit;
}

$query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama')";

$result = mysqli_query($koneksi, $query);

if ($result) {
    $_SESSION['tambah_success'] = true;
    echo "<script>
    window.location='kategori.php';
    </script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>