<?php
include('../koneksi.php');
session_start();

// Check if the user session variable is set
if (!isset($_SESSION['username'])) {
    // If not set, redirect to the login page
    header("Location: ./user/login.php");
    exit();
}

$id = $_GET['id'];

$cart = $_SESSION['cart'];
// print_r($cart);

// untuk mengambil data secara spesifik
$k = array_filter($cart, function ($var) use ($id) {
    return ($var['id'] == $id);
});
// print_r($k);

foreach ($k as $key => $value) {
    unset($_SESSION['cart'][$key]);
}

$_SESSION['cart'] = array_values($_SESSION['cart']);

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