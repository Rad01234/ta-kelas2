<?php
include('../koneksi.php');
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: ./user/login.php");
    exit();
}

$bayar = preg_replace('/\D/', '', $_POST['bayar']);
$tanggal_waktu = date('Y-m-d H:i:s');
$nomor = rand(111111, 999999);
$metode = $_POST['metode'];
$total = $_POST['total'];
$kembali = $bayar - $total;

$query1 = "INSERT INTO transaksi (tanggal_waktu, nomor, total_harga, bayar, kembali)
           VALUES ('$tanggal_waktu', '$nomor', '$total', '$bayar', '$kembali')";
$result1 = mysqli_query($koneksi, $query1);

if ($result1) {
    // mengambil id_transaksi dari query sebelumnya
    $id_transaksi = mysqli_insert_id($koneksi);

    foreach ($_SESSION['cart'] as $key => $value) {
        $id_barang = $value['id'];
        $harga = $value['harga'];
        $qty = $value['qty'];
        $subtotal = $harga * $qty;

        $query_check = "SELECT stok, nama_barang FROM barang WHERE id_barang = '$id_barang'";
        $result_check = mysqli_query($koneksi, $query_check);
        $row = mysqli_fetch_assoc($result_check);

        if ($row['stok'] < $qty) {
            echo 'Stok barang dengan nama ' . $row['nama_barang'] . ' tidak mencukupi. Stok saat ini: ' . $row['stok'];
            exit();
        }


        $query2 = "INSERT INTO detail_transaksi (id_transaksi, id_barang, metode, harga, qty, subtotal) 
                    VALUES ('$id_transaksi', '$id_barang', '$metode', '$harga', '$qty', '$subtotal')";
        $result2 = mysqli_query($koneksi, $query2);

        if (!$result2) {
            echo "Error inserting detail: " . mysqli_error($koneksi);
            exit();
        }

        $query3 = "UPDATE barang SET stok = stok - $qty WHERE id_barang = '$id_barang'";
        $result3 = mysqli_query($koneksi, $query3);

        if (!$result3) {
            echo "Error updating stock: " . mysqli_error($koneksi);
            exit();
        }
    }

    $_SESSION['cart'] = [];
    // jika kedua query berhasil
    header("Location: transaksi_selesai.php?id_trx=" . $id_transaksi);

} else {
    echo "Error: " . mysqli_error($koneksi);
}


?>