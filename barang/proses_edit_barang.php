<?php
include('../koneksi.php');
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

$id_barang = isset($_GET['id_barang']) ? $_GET['id_barang'] : null;

if ($id_barang === null) {
    die("Id Tidak ada");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $harga_satuan = $_POST['harga_satuan'];
    $stok = $_POST['stok'];
    $merek = $_POST['merek'];
    $kategori = $_POST['kategori'];

    $query_cek = "SELECT * FROM barang WHERE LOWER(nama_barang) = LOWER('$nama') AND id_barang != $id_barang";
    $result_cek = mysqli_query($koneksi, $query_cek);
    if (mysqli_num_rows($result_cek) > 0) {
        $_SESSION['edit_error'] = true;
        echo "<script>
            window.location = 'edit_barang.php?id_barang=$id_barang';
          </script>";
        exit;
    }

    if ($_FILES['gambar']['error'] == 0) {
        $gambar = $_FILES['gambar']['name'];


        $file_gambar = "../img/";
        $filenya = $file_gambar . basename($gambar);
        move_uploaded_file($_FILES['gambar']['tmp_name'], $filenya);


        $update_data = "UPDATE barang SET 
            nama_barang = '$nama',
            harga_satuan = '$harga_satuan',
            stok = '$stok',
            merek = '$merek',
            id_kategori = '$kategori',
            gambar = '$gambar'
            WHERE id_barang = $id_barang";
    } else {

        $update_data = "UPDATE barang SET 
            nama_barang = '$nama',
            harga_satuan = '$harga_satuan',
            stok = '$stok',
            merek = '$merek',
            id_kategori = '$kategori'
            WHERE id_barang = $id_barang";
    }

    $update_cek = mysqli_query($koneksi, $update_data);

    if ($update_cek) {
        $_SESSION['edit_success'] = true;
        echo "<script>
        window.location='barang.php';
        </script>";
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>