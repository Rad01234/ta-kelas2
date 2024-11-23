<?php
include("../koneksi.php");
session_start();

if (isset($_GET['id_transaksi'])) {
    $id = $_GET['id_transaksi'];
    $query1 = "DELETE FROM transaksi WHERE id_transaksi = $id";
    $result1 = mysqli_query($koneksi, $query1);

    $query2 = "DELETE FROM detail_transaksi WHERE id_transaksi = $id";
    $result2 = mysqli_query($koneksi, $query2);

    if ($result1) {
        switch ($_SESSION['role']) {
            case "Admin":
                $_SESSION['hapus_success'] = true;
                echo "<script>
                window.location='history.php';
                </script>";
                break;
            case "Kasir":
                $_SESSION['hapus_success'] = true;
                echo "<script>
                window.location='../kasir/history_kasir.php';
                </script>";
                break;
            default:
                echo "<script>alert('Role tidak dikenali'); window.location='login.php';</script>";
                break;
        }
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