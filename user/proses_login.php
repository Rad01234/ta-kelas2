<?php
session_start();
include('../koneksi.php');

$username = $_POST['username'];
$password = $_POST['password'];

// untuk digunakan di form ketika error
$_SESSION['input_username'] = $username;

$login = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
$cek = mysqli_num_rows($login);

if ($cek != 0) {
    $data = mysqli_fetch_assoc($login);
    $isPasswordTrue = password_verify($password, $data['password']);

    if ($isPasswordTrue) {
        $_SESSION['id_user'] = $data['id_user']; 
        $_SESSION['username'] = $data['username']; 
        $_SESSION['role'] = $data['role']; 

        switch ($data['role']) {
            case "Admin":
                $_SESSION['login_success'] = true;
                echo "<script>window.location='../admin/index_admin.php';</script>";
                break;
            case "Restocker":
                $_SESSION['login_success'] = true;
                echo "<script>window.location='../restocker/index_restocker.php';</script>";
                break;
            case "Kasir":
                $_SESSION['login_success'] = true;
                echo "<script>window.location='../kasir/index_kasir.php';</script>";
                break;
        }
    } else {
        $_SESSION['login_errorNP'] = true;
        echo "<script>window.location='login.php';</script>";
    }
} else {
    $_SESSION['login_errorR'] = true;
    echo "<script>window.location='register.php';</script>";
}
?>
