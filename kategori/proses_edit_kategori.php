<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

$id_kategori = isset($_POST['id_kategori']) ? $_POST['id_kategori'] : null;
$nama = isset($_POST['namaE']) ? $_POST['namaE'] : null;

$query_cek = "SELECT * FROM kategori WHERE LOWER(nama_kategori) = LOWER('$nama') AND id_kategori != $id_kategori";
$result_cek = mysqli_query($koneksi, $query_cek);
if (mysqli_num_rows($result_cek) > 0) {
    $_SESSION['edit_error'] = true;
    echo '<script>
            window.location = "kategori.php";
          </script>';
    exit;
}

if ($id_kategori === null || $nama === null) {
    die("ID atau kategori tidak diberikan.");
}

$query = "UPDATE kategori SET 
    nama_kategori = '$nama' WHERE id_kategori = '$id_kategori'";

$result = mysqli_query($koneksi, $query);

if ($result) {
    $_SESSION['edit_success'] = true;
    echo "<script>
    window.location='kategori.php';
    </script>";
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>