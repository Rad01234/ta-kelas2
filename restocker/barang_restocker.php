<?php
include('../sidebarR.php');
if (!isset($_SESSION['username'])) {
    header("Location: ../user/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang</title>
    <link rel="stylesheet" href="../styleR.css">
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
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .home_content {
            overflow-y: auto;
            /* buat scroll atasbawah */
        }

        .navbar {
            height: 68px;
        }
    </style>

</head>

<body>
    <div class="home_content">
        <nav class="navbar bg-light bg-gradient shadow-sm rounded sticky-top">
            <div class="container-fluid d-flex">
                <span class="navbar-text me-auto fs-4"><strong>Barang</strong></span>
            </div>
        </nav>

        <div class="container-fluid mt-4 sticky-top">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="w-100">
                            <form class="" action="" method="POST">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bx bx-search"></i>
                                    </span>
                                    <input type="text" name="tcari"
                                        value="<?= isset($_POST['tcari']) ? htmlspecialchars($_POST['tcari']) : '' ?>"
                                        class="form-control" placeholder="Masukkan kata kunci!">
                                    <button class="btn btn-primary" name="bcari" type="submit">
                                        <i class='bx bx-check fs-5'></i>
                                    </button>
                                    <a href="barang_restocker.php" class="btn btn-danger">
                                        <i class='bx bx-x fs-5'></i>
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-3 mb-3">
            <div class="card">
                <div class="card-body pb-0">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle table-hover">
                            <thead>
                                <tr class="table-primary">
                                    <th class="text-center" scope="col">No.</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Harga Satuan</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col">Merek</th>
                                    <th scope="col">Kategori</th>
                                    <th class="text-center" scope="col">Gambar</th>
                                    <th class="text-center" scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;

                                // untuk pencarian data jika tombol cari di klik
                                if (isset($_POST['bcari'])) {
                                    // tampilkan data yang dicari
                                    $keyword = $_POST['tcari'];
                                    $query = "SELECT barang.*, kategori.* 
                                    FROM barang 
                                    JOIN kategori ON barang.id_kategori = kategori.id_kategori
                                    WHERE barang.nama_barang LIKE '%$keyword%' OR kategori.nama_kategori LIKE '%$keyword%'";
                                } else {
                                    $query = "SELECT barang.*, kategori.* 
                                    FROM barang 
                                    JOIN kategori ON barang.id_kategori = kategori.id_kategori";
                                }

                                $result = mysqli_query($koneksi, $query);
                                while ($row_list = mysqli_fetch_array($result)):
                                    ?>
                                    <tr>
                                        <td class="text-center"><?= $no++ ?></td>
                                        <td><?= $row_list['nama_barang'] ?></td>
                                        <td>Rp. <?= $row_list['harga_satuan'] ?></td>
                                        <td><?= $row_list['stok'] ?></td>
                                        <td><?= $row_list['merek'] ?></td>
                                        <td><?= $row_list['nama_kategori'] ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn" data-bs-toggle="modal"
                                                data-bs-target="#gambarModal"
                                                data-image="../img/<?= $row_list['gambar'] ?>">
                                                <img src="../img/<?= $row_list['gambar'] ?>" width="50px" alt="Cover">
                                            </button>
                                        </td>
                                        <td class='text-center p-0'>
                                            <a class='btn btn-warning text-decoration-none text-white'
                                                data-bs-toggle="modal" data-bs-target="#editModal"
                                                data-id="<?= $row_list['id_barang'] ?>"
                                                data-nama="<?= $row_list['stok'] ?>">
                                                <i class='bx bx-edit'></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editModalLabel">Edit Stok</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="proses_stok.php" method="POST">
                                    <div class="modal-body">
                                        <input type="hidden" name="id_barang" id="edit-id-barang">
                                        <div class="mb-3">
                                            <label for="edit-stok" class="form-label">Masukkan Stok Baru</label>
                                            <input type="number" name="stok" id="edit-stok" class="form-control"
                                                required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="gambarModal" tabindex="-1" aria-labelledby="gambarModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="gambarModalLabel">Gambar Barang</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="modalImage" src="" width="250px" alt="Cover">
                                </div>
                                <div class="modal-footer"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            let btn = document.querySelector("#Btn");
            let sidebar = document.querySelector(".sidebar");

            btn.onclick = function () {
                sidebar.classList.toggle("active");
            }

            // tooltip perlu di inisialisasi dahulu :)
            document.addEventListener('DOMContentLoaded', function () {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerElement) {
                    return new bootstrap.Tooltip(tooltipTriggerElement);
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var modal = document.getElementById('gambarModal');
                var modalImage = document.getElementById('modalImage');

                modal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget; // tombol hidup modal
                    var imageSrc = button.getAttribute('data-image'); // ambil image
                    modalImage.src = imageSrc; // update img src
                });
            });
        </script>

        <script>
            const editModal = document.getElementById('editModal');
            editModal.addEventListener('show.bs.modal', event => {
                // tombol hidup modal
                const button = event.relatedTarget;

                // ambil data-id and data-nama
                const id = button.getAttribute('data-id');
                const nama = button.getAttribute('data-nama');

                // set values dalam form modal
                document.getElementById('edit-id-barang').value = id;
                document.getElementById('edit-stok').value = nama;
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <?php
        if (isset($_SESSION['edit_success']) && $_SESSION['edit_success'] === true) {
            unset($_SESSION['edit_success']);

            echo "
            <script>
            Swal.fire({
            icon: 'success',
            title: 'Pengelolaan Stok Berhasil!',
            text: 'Tidak ada masalah!',
            showConfirmButton: true
            });
            </script>
            ";
        }
        ?>

        <?php
        if (isset($_SESSION['edit_error']) && $_SESSION['edit_error'] === true) {
            unset($_SESSION['edit_error']);

            echo "
            <script>
            Swal.fire({
            icon: 'error',
            title: 'Pengelolaan Stok Gagal!',
            text: 'Stok harus berupa angka positif!',
            showConfirmButton: true
            });
            </script>
            ";
        }
        ?>
</body>

</html>