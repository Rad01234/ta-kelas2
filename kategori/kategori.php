<?php
include('../sidebarA.php');
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
    <title>Kategori</title>
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
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .home_content {
            overflow-y: auto;
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
                <span class="navbar-text me-auto fs-4"><strong>Kategori</strong></span>
            </div>
        </nav>

        <div class="container-fluid mt-4 sticky-top">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">

                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#tambahModal">
                            Tambah
                        </button>
                        <div>
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
                                    <a href="kategori.php" class="btn btn-danger">
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
            <div class="row row-cols-1 row-cols-md-5 g-4">
                <?php
                $no = 1;

                if (isset($_POST['bcari'])) {
                    $keyword = $_POST['tcari'];
                    $query = "SELECT * FROM kategori WHERE nama_kategori LIKE '%$keyword%'";
                } else {
                    $query = "SELECT * FROM kategori";
                }

                $result = mysqli_query($koneksi, $query);
                while ($row_list = mysqli_fetch_array($result)): ?>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?= $row_list['nama_kategori'] ?>
                                </h5>
                                <div class="d-flex justify-content-between text-center mt-4">
                                    <a class='btn btn-warning text-decoration-none text-white' data-bs-toggle="modal"
                                        data-bs-target="#editModal" data-id="<?= $row_list['id_kategori'] ?>"
                                        data-nama="<?= $row_list['nama_kategori'] ?>">
                                        <i class='bx bx-edit'></i>
                                    </a>

                                    <a class='btn btn-danger text-decoration-none text-white' href='#'
                                        id="hapus<?= $row_list['id_kategori'] ?>">
                                        <i class='bx bx-trash'></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="tambahModalLabel">Kategori Baru</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form role="form" action="proses_tambah_kategori.php" method="POST">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tambah" class="form-label">Nama Kategori</label>
                                <input type="text" name="namaT" class="form-control"
                                    placeholder="Masukkan Kategori Baru">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" value="Submit" name="tambahK" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Kategori</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="proses_edit_kategori.php" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="id_kategori" id="edit-id-kategori">
                            <div class="mb-3">
                                <label for="edit-nama" class="form-label">Nama Kategori</label>
                                <input type="text" name="namaE" id="edit-nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
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

        // tambah tooltips
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerElement) {
                return new bootstrap.Tooltip(tooltipTriggerElement);
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
            document.getElementById('edit-id-kategori').value = id;
            document.getElementById('edit-nama').value = nama;
        });
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    <script>
        document.querySelector("form[action='proses_tambah_kategori.php']").addEventListener("submit", function (e) {
            const namaT = document.querySelector("input[name='namaT']").value.trim();
            let errors = [];

            if (namaT === "") {
                errors.push("Nama Kategori tidak boleh kosong.");
            }

            if (errors.length > 0) {
                e.preventDefault(); // batalkan pengiriman form
                let errorMessage = errors.join('\n'); // untuk setiap error yang ada, di gabung semua error
                Swal.fire({
                    icon: 'error',
                    title: 'Penambahan Gagal!',
                    text: errorMessage,
                    showConfirmButton: true,
                });
            }
        });
    </script>

    <?php
    if (isset($_SESSION['tambah_success']) && $_SESSION['tambah_success'] === true) {
        unset($_SESSION['tambah_success']);

        echo "
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Penambahan Berhasil!',
            text: 'Tidak ada masalah!',
            showConfirmButton: true
        });
        </script>
        ";
    }
    ?>

    <?php
    if (isset($_SESSION['tambah_error']) && $_SESSION['tambah_error'] === true) {
        unset($_SESSION['tambah_error']);

        echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Penambahan Gagal!',
            text: 'Kategori sudah terdaftar!',
            showConfirmButton: true
        });
        </script>
        ";
    }
    ?>

    <?php
    if (isset($_SESSION['edit_success']) && $_SESSION['edit_success'] === true) {
        unset($_SESSION['edit_success']);

        echo "
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Edit Berhasil!',
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
        title: 'Edit Gagal!',
        text: 'Kategori sudah terdaftar!',
        showConfirmButton: true
    });
    </script>
    ";
    }
    ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php
            $result = mysqli_query($koneksi, $query);
            while ($row_list = mysqli_fetch_array($result)):
                ?>
                document.getElementById('hapus<?= $row_list['id_kategori'] ?>').addEventListener('click', function (e) {
                    e.preventDefault(); // mencegah pergi ke link di tag <a>

                    Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: 'Data yang dihapus tidak bisa dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'hapus_kategori.php?id_kategori=' + <?= $row_list['id_kategori'] ?>;
                        }
                    });
                });
            <?php endwhile; ?>
        });
    </script>

    <?php
    if (isset($_SESSION['hapus_success']) && $_SESSION['hapus_success'] === true) {
        unset($_SESSION['hapus_success']);

        echo "
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Hapus Berhasil!',
        text: 'Tidak Ada Masalah!',
        showConfirmButton: true
    });
    </script>
    ";
    }
    ?>

    <?php
    if (isset($_SESSION['hapus_error']) && $_SESSION['hapus_error'] === true) {
        unset($_SESSION['hapus_error']);

        echo "
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Hapus Gagal!',
        text: 'ID Kategori tidak ada!',
        showConfirmButton: true
    });
    </script>
    ";
    }
    ?>
</body>

</html>