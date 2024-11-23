<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$role = $_POST['role'];

$_SESSION['input_username'] = $username;
$_SESSION['input_email'] = $email;
$_SESSION['input_role'] = $role;

// ubah nama dan email menjadi huruf kecil
$username_lower = strtolower($username);
$email_lower = strtolower($email);

$query = "SELECT * FROM user WHERE LOWER(username) = '$username_lower' OR LOWER(email) = '$email_lower'";
$data = mysqli_query($koneksi, $query);
$rowcount = mysqli_num_rows($data);

if ($rowcount != 0) {
    $_SESSION['tambah_error'] = true;
    echo "<script>
    window.location='tambah_pegawai.php';
    </script>";
}

// jika belum daftar
else {
    $pass = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO user (username, password, email, role) VALUES('$username', '$pass', '$email', '$role')";
    $data = mysqli_query($koneksi, $query);

    if (!$data) {
        die("Error : " . mysqli_error($koneksi));
    }

    $_SESSION['tambah_success'] = true;
    echo "<script>
    window.location='pegawai.php';
    </script>";
}

?>