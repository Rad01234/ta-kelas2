<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

if (isset($_GET['id_barang'])) {
    $id = $_GET['id_barang'];
    $query = "DELETE FROM barang WHERE id_barang = $id";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['hapus_success'] = true;
        echo "<script>
        window.location='barang.php';
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