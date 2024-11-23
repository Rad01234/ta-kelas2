<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

if (isset($_GET['id_kategori'])) {
    $id = $_GET['id_kategori'];
    $query = "DELETE FROM kategori WHERE id_kategori = $id";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['hapus_success'] = true;
        echo "<script>
        window.location='kategori.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }

} else {
    $_SESSION['hapus_error'] = true;
    echo "<script>
    </script>";
    echo "Error: " . mysqli_error($koneksi);
}
?>