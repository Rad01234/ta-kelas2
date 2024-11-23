<?php
include('../koneksi.php');
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

$id_user = isset($_GET['id_user']) ? $_GET['id_user'] : null;

if ($id_user === null) {
    die("Id Tidak ada");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // ubah nama dan email menjadi huruf kecil
    $username_lower = strtolower($username);
    $email_lower = strtolower($email);

    $query = "SELECT * FROM user WHERE (LOWER(username) = '$username_lower' OR LOWER(email) = '$email_lower') AND id_user != $id_user";
    $data = mysqli_query($koneksi, $query);
    $rowcount = mysqli_num_rows($data);

    if ($rowcount != 0) {
        $_SESSION['edit_error'] = true;
        echo "<script>
        window.location='edit_pegawai.php?id_user=$id_user';
        </script>";
        exit;
    }

    if ($_FILES['gambar_user']['error'] == 0) {
        $gambar = $_FILES['gambar_user']['name'];


        $file_gambar = "../img/";
        $filenya = $file_gambar . basename($gambar);
        move_uploaded_file($_FILES['gambar_user']['tmp_name'], $filenya);


        $update_data = "UPDATE user SET 
            username = '$username',
            email = '$email',
            role = '$role',
            gambar_user = '$gambar'
            WHERE id_user = $id_user";
    } else {

        $update_data = "UPDATE user SET 
            username = '$username',
            email = '$email',
            role = '$role'
            WHERE id_user = $id_user";
    }
    
    $update_cek = mysqli_query($koneksi, $update_data);
    if ($update_cek) {
        $_SESSION['edit_success'] = true;
        echo "<script>
        window.location='pegawai.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>