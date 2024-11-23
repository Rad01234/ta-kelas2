<?php 
include('../koneksi.php');
session_start();

// Check if the user session variable is set
if (!isset($_SESSION['username'])) {
    // If not set, redirect to the login page
    header("Location: ./user/login.php");
    exit();
}

$_SESSION['cart'] = [];
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