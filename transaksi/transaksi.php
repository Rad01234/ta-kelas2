<?php
include('../sidebarA.php');

if (!isset($_SESSION['username'])) {
    header("Location: ../user/login.php");
    exit();
}

$barang = mysqli_query($koneksi, "SELECT * FROM barang");

$sum = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $key => $value) {
        $sum += floatval($value['harga']) * intval($value['qty']);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link rel="stylesheet" href="../style.css">
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

    <style>
        .container-fluid {
            flex-grow: 1;
        }
    </style>
</head>

<body>
    <div class="home_content">
        <nav class="navbar bg-light bg-gradient shadow-sm rounded sticky-top">
            <div class="container-fluid d-flex">
                <span class="navbar-text me-auto fs-4"><strong>Transaksi</strong></span>
            </div>
        </nav>


        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <form action="keranjang_act.php" method="POST" class="form-inline">
                                <div class="input-group">
                                    <select class="form-select" name="id_barang">
                                        <option value="">Pilih</option>
                                        <?php while ($row = mysqli_fetch_array($barang)) { ?>
                                            <option value="<?= $row['id_barang'] ?>"><?= $row['nama_barang'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <input type="number" name="qty" class="form-control" placeholder="Jumlah">
                                    <button class="btn btn-primary" type="submit">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card mt-4">
                        <div class="card-body">
                            <form action="keranjang_update.php" method="POST">
                                <div style="max-height: 300px; overflow-y: auto;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="table-warning">
                                                <th>Nama</th>
                                                <th>Harga</th>
                                                <th>Qty</th>
                                                <th>Sub Total</th>
                                                <th style="width: 7%;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (isset($_SESSION['cart']) && is_array($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
                                                <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                                                    <tr>
                                                        <td><?= $value['nama'] ?></td>
                                                        <td align="right"><?= number_format($value['harga']) ?></td>
                                                        <td class="col-md-2">
                                                            <input type="number" name="qty[<?= $key ?>]"
                                                                value="<?= $value['qty'] ?>" class="form-control">
                                                        </td>
                                                        <td align="right">
                                                            <?= number_format(floatval($value['qty']) * floatval($value['harga'])) ?>
                                                        </td>
                                                        <td>
                                                            <a href="keranjang_hapus.php?id=<?= $value['id'] ?>"
                                                                class="btn btn-danger fs-6" style="padding: 0.3rem 0.6rem;">
                                                                <i class='bx bx-x'></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                                                <tr>
                                                    <td colspan="5" class="text-center">Keranjang kosong</td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-success">Perbarui</button>
                                        <a href="keranjang_reset.php" class="btn btn-danger">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4>Total Rp. <?= number_format($sum) ?></h4>
                            <form action="proses_transaksi.php" method="POST">
                                <input type="hidden" name="total" value="<?= $sum ?>">
                                <div>
                                    <label for="bayar" class="form-label">Bayar</label>
                                    <input type="text" name="bayar" id="bayar" class="form-control">
                                </div>
                                <div class="mt-2">
                                    <label for="metode" class="form-label">Metode Pembayaran</label>
                                    <select name="metode" class="form-control">
                                        <option value="">-Pilih-</option>
                                        <option value="Tunai">Tunai</option>
                                        <option value="Debit">Debit</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary mt-4">Selesai</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">

        // inisialisasi inputan
        var bayar = document.getElementById('bayar');

        bayar.addEventListener('keyup', function (e) {
            bayar.value = formatRupiah(this.value, 'Rp. ');
        });

        // generate dari inputan angka menjadi format rupiah

        function formatRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, '').toString(),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                seperator = sisa ? '.' : '';
                rupiah += seperator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        // generate dari inputan rupiah menjadi angka
        function cleanRupiah(rupiah) {
            var clean = rupiah.replace(/\D/g, '');
            return clean;
        }

    </script>

    <script>
        let btn = document.querySelector("#Btn");
        let sidebar = document.querySelector(".sidebar");

        btn.onclick = function () {
            sidebar.classList.toggle("active");
        }

        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerElement) {
                return new bootstrap.Tooltip(tooltipTriggerElement);
            });
        });

    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    <script>
        document.querySelector("form[action='keranjang_act.php']").addEventListener("submit", function (e) {
            const id_barang = document.querySelector("select[name='id_barang']").value.trim();
            const qty = parseInt(document.querySelector("input[name='qty']").value.trim());

            let errors = [];

            if (id_barang === "") {
                errors.push("Barang harus dipilih.");
            }

            if (isNaN(qty) || qty <= 0) {
                errors.push("Jumlah harus lebih dari 0.");
            }

            if (errors.length > 0) {
                e.preventDefault(); // Mencegah pengiriman form
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    text: errors.join('\n'),
                    showConfirmButton: true,
                });
            }
        });

    </script>

    <script>
        document.querySelector("form[action='proses_transaksi.php']").addEventListener("submit", function (e) {
            const bayar = cleanRupiah(document.querySelector("input[name='bayar']").value.trim()); // Mengubah dari format Rupiah ke angka
            const metode = document.querySelector("select[name='metode']").value.trim();
            const total = <?= $sum ?>; // Total harga dari PHP

            let errors = [];

            if (bayar === "" || isNaN(parseFloat(bayar))) {
                errors.push("Pembayaran tidak boleh kosong dan harus berupa angka.");
            } else if (parseFloat(bayar) < total) {
                errors.push("Pembayaran harus lebih besar atau sama dengan total harga.");
            }

            if (metode === "") {
                errors.push("Metode pembayaran harus dipilih.");
            }

            if (errors.length > 0) {
                e.preventDefault(); // Mencegah pengiriman form
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    text: errors.join('\n'),
                    showConfirmButton: true,
                });
            }
        });

        // untuk membersihkan format Rupiah
        function cleanRupiah(rupiah) {
            return rupiah.replace(/\D/g, ''); // menhapus semua karakter non-digit
        }

    </script>
</body>

</html>