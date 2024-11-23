<?php
include('../koneksi.php');
session_start();

// Check if the user session variable is set
if (!isset($_SESSION['username'])) {
    // If not set, redirect to the login page
    header("Location: ./user/login.php");
    exit();
}

// $qty = $_POST['qty'];
// print_r($qty)

if (isset($_POST['qty'])) {
    foreach ($_POST['qty'] as $key => $value) {
        if (isset($_SESSION['cart'][$key])) {
            // Update quantity di session cart
            $_SESSION['cart'][$key]['qty'] = intval($value);
        }
    }
}

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