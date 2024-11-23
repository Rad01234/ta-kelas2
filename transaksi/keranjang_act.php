<?php
include('../koneksi.php');
session_start();

// Check if the user session variable is set
if (!isset($_SESSION['username'])) {
    // If not set, redirect to the login page
    header("Location: ./user/login.php");
    exit();
}

if (isset($_POST['id_barang'])) {
    $id_barang = $_POST['id_barang'];
    $qty = $_POST['qty'];

    $data = mysqli_query($koneksi, "SELECT * FROM barang WHERE id_barang='$id_barang'");
    // echo var_dump($data);
    // return false;
    $b = mysqli_fetch_assoc($data);

    $barang = [
        'id' => $b['id_barang'],
        'nama' => $b['nama_barang'],
        'harga' => $b['harga_satuan'],
        'qty' => $qty
    ];
}

$_SESSION['cart'][] = $barang;
    krsort($_SESSION['cart']);

    switch ($_SESSION['role']) {
        case "Admin":
            header("Location: transaksi.php");
            break;
        case "Kasir":
            header("Location: ../kasir/transaksi_kasir.php");
            break;
        default:
            echo "<script>alert('Role tidak dikenali'); window.location='login.php';</script>";
            break;
    }
?>