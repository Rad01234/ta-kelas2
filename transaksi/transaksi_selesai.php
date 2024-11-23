<?php
session_start();
include('../koneksi.php');

if (!isset($_SESSION['username'])) {
    header("Location: ./user/login.php");
    exit();
}

$id_trx = $_GET['id_trx'];

$data = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id_transaksi = '$id_trx'");
$trx = mysqli_fetch_assoc($data);

$detail = mysqli_query($koneksi, "SELECT detail_transaksi.*, barang.nama_barang FROM detail_transaksi INNER JOIN barang ON 
    detail_transaksi.id_barang=barang.id_barang WHERE detail_transaksi.id_transaksi='$id_trx'");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selesai</title>
    <link rel="shortcut icon" href="../img_w/logo_d.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style type="text/css">
        body {
            /* color: #a7a7a7; */
        }
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div align="center" class="no-print mt-2">
        <button onclick="window.print()" class="btn btn-secondary">Cetak</button>
        <button onclick="window.history.back()" class="btn btn-danger">Back</button>
    </div>
    <div align="center">
        <table width="500" border="0" cellpadding="1" cellspacing="0">
            <tr>
                <th class="text-center">STOKO<br>
                    Jl. Tirto Agung, Lowokwaru Merjosari <br>
                    Malang, Jawa Timur, 601010</th>
            </tr>
            <tr align="center">
                <td>
                    <hr>
                </td>
            </tr>
            <tr>
                <td>
                    <?= $trx['nomor'] ?> | <?= date('d-m-Y H:i:s', strtotime($trx['tanggal_waktu'])) ?>
                </td>
            </tr>
            <tr>
                <td>
                    <hr>
                </td>
            </tr>
        </table>
        <table width="500" border="0" cellpadding="3" cellspacing="0">
            <?php while ($row = mysqli_fetch_array($detail)) { ?>
                <tr>
                    <td><?= $row['nama_barang'] ?></td>
                    <td><?= $row['qty'] ?></td>
                    <td align="right"><?= number_format($row['harga']) ?></td>
                    <td align="right"><?= number_format($row['subtotal']) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="4">
                    <hr>
                </td>
            </tr>
            <tr>
                <td align="right" colspan="3">Total</td>
                <td align="right" colspan="3"><?= number_format($trx['total_harga']) ?></td>
            </tr>
            <tr>
                <td align="right" colspan="3">Bayar</td>
                <td align="right" colspan="3"><?= number_format($trx['bayar']) ?></td>
            </tr>
            <tr>
                <td align="right" colspan="3">Kembali</td>
                <td align="right" colspan="3"><?= number_format($trx['kembali']) ?></td>
            </tr>
        </table>
        <table width="500" border="0" cellpadding="1" cellspacing="0">
            <tr>
                <td>
                    <hr>
                </td>
            </tr>
            <tr>
                <th class="text-center">Terima Kasih, Selamat Belanja Kembali</th>
            </tr>
            <tr>
                <th class="text-center">===== Layanan Konsumer =====</th>
            </tr>
            <tr>
                <th class="text-center"> SMS/CALL 080808080808 </th>
            </tr>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>