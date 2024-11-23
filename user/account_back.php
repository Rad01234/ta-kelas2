<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

switch ($_SESSION['role']) {
    case "Admin":
        header("Location: ../admin/index_admin.php"); 
        exit; 
    case "Restocker":
        header("Location: ../restocker/index_restocker.php"); 
        exit;
    case "Kasir":
        header("Location: ../kasir/index_kasir.php"); 
        exit;
    default:
        echo "<script>alert('Role tidak dikenali'); window.location='../user/login.php';</script>";
        break;
}
?>
