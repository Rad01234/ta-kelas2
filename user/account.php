<?php
session_start();
include('../koneksi.php');

if (!isset($_SESSION['username'])) {
    header("Location: ./user/login.php");
    exit();
}

$username = $_SESSION['username'];
$cek = "SELECT id_user FROM user WHERE username ='$username'";
$data_user = mysqli_query($koneksi, $cek);

if ($data_user && mysqli_num_rows($data_user) > 0) {
    $row_user = mysqli_fetch_assoc($data_user);
    $id_user = $row_user['id_user'];
}

$display = "SELECT * FROM user WHERE id_user ='$id_user'";
$data_profile = mysqli_query($koneksi, $display);

if ($data_profile && mysqli_num_rows($data_profile) > 0) {
    $row = mysqli_fetch_assoc($data_profile);
}

$userImage = !empty($row['gambar_user']) ? $row['gambar_user'] : 'pfp.png';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="shortcut icon" href="../img_w/logo_d.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .profile_img {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile_img img {
            width: 200px;
            height: auto;
            object-fit: cover;
            border-radius: 100%;
        }

        .change_img {
            text-align: center;
            margin-top: 25px;
        }

        .name_role {
            text-align: center;
            margin-top: 12px;
        }

        .name {
            font-weight: bold;
            font-size: 20px;
        }

        .role {
            font-size: 16px;
            color: gray;
        }

        .profile_img_preview {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .profile_img_preview img {
            width: 150px;
            height: auto;
            object-fit: cover;
            border-radius: 100%;
        }

        .name_role_preview {
            margin-top: 12px;
        }

        .name_preview {
            font-weight: bold;
            font-size: 20px;
        }

        .role_preview {
            font-size: 16px;
            color: gray;
        }
    </style>

</head>

<body>
    <div class="container">

        <div class="row d-flex justify-content-center mt-5">
            <div class="col-5">
                <div class="profile_card card">
                    <div class="card-header" style="background-color: #006BFF;"></div>
                    <div class="card-body p-4">
                        <div class="intro_card">
                            <div class="profile_img">
                                <img src="../img/<?= htmlspecialchars($userImage) ?>" alt="Profile Image">
                            </div>
                            <div class="name_role">
                                <div class="name"><?= htmlspecialchars($row['username']); ?></div>
                                <div class="role"><?= htmlspecialchars($row['role']); ?></div>
                            </div>
                            <div class="change_img">
                                <button type="button" class="btn btn-danger fs-4 me-2" data-bs-toggle="modal"
                                    data-bs-target="#profileImageModal">
                                    <i class='bx bx-image-alt'></i>
                                </button>

                                <div class="modal fade" id="profileImageModal" tabindex="3"
                                    aria-labelledby="profileImageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="profileImageModalLabel">Ganti Gambar
                                                    Profile
                                                </h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="proses_account.php?id_user=<?= $row['id_user'] ?>"
                                                method="POST" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <div class="container-fluid">
                                                        <div class="row d-flex justify-content-center">
                                                            <div class="col-8">
                                                                <p><strong>PREVIEW</strong></p>
                                                                <div class="profile_card_preview card">
                                                                    <div class="card-header"
                                                                        style="background-color: #006BFF;"></div>
                                                                    <div class="card-body p-4">
                                                                        <div class="intro_card_preview">
                                                                            <div class="profile_img_preview">
                                                                                <img id="profileImage"
                                                                                    src="../img/<?= htmlspecialchars($userImage) ?>"
                                                                                    alt="Profile Image">
                                                                            </div>
                                                                            <div class="name_role_preview">
                                                                                <div class="name_preview">
                                                                                    <?= htmlspecialchars($row['username']); ?>
                                                                                </div>
                                                                                <div class="role_preview">
                                                                                    <?= htmlspecialchars($row['role']); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card-footer"
                                                                        style="background-color: #006BFF;"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3">

                                                            <div class="custom-file-upload">
                                                                <label for="file-upload"
                                                                    class="custom-file-label btn btn-warning">
                                                                    Choose File
                                                                </label>
                                                                <span id="file-name" class="file-name">No file
                                                                    chosen</span>
                                                                <input id="file-upload" type="file" name="gambar"
                                                                    onchange="updateFileName()" style="display: none;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="gambarP"
                                                        class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-warning fs-4" data-bs-toggle="modal"
                                    data-bs-target="#passwordChangeModal">
                                    <i class='bx bxs-key text-white'></i>
                                </button>

                                <div class="modal fade" id="passwordChangeModal" tabindex="3"
                                    aria-labelledby="passwordChangeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="passwordChangeModalLabel">Ganti
                                                    Password Anda</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form id="passwordChangeForm"
                                                action="proses_account.php?id_user=<?= $row['id_user'] ?>"
                                                method="POST">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-12 mb-3">
                                                            <label for="passwordlama" class="form-label">Masukkan
                                                                Password Lama</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control"
                                                                    name="oldPass" id="password"
                                                                    placeholder="Masukkan Password Anda">
                                                                <span class="input-group-text">
                                                                    <i class="bi bi-eye-slash" id="togglePassword"
                                                                        style="cursor: pointer;"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <label for="passwordbaru" class="form-label">Masukkan
                                                                Password Baru</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control"
                                                                    name="newPass" id="passwordN"
                                                                    placeholder="Masukkan Password Anda">
                                                                <span class="input-group-text">
                                                                    <i class="bi bi-eye-slash" id="togglePasswordN"
                                                                        style="cursor: pointer;"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mt-3">
                                                            <label for="passwordbaru2" class="form-label">Konfirmasi
                                                                Password Baru</label>
                                                            <div class="input-group">
                                                                <input type="password" class="form-control"
                                                                    name="confirmNewPass" id="passwordC"
                                                                    placeholder="Masukkan Password Anda">
                                                                <span class="input-group-text">
                                                                    <i class="bi bi-eye-slash" id="togglePasswordC"
                                                                        style="cursor: pointer;"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="changePassword"
                                                        class="btn btn-primary">Save</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="background-color: #006BFF;"></div>
                </div>
                <div class="mt-2">
                    <a href="account_back.php" class="btn btn-secondary w-100">
                        <i class='bx bx-arrow-back'></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    <script>
        function updateFileName() {
            const input = document.getElementById('file-upload');
            const fileNameSpan = document.getElementById('file-name');
            const profileImage = document.getElementById('profileImage');

            if (input.files.length > 0) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function (event) {
                    const img = new Image();
                    img.onload = function () {
                        if (img.width > 750 || img.height > 750) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Foto kebesaran!',
                                text: 'Gunakan foto yang tidak melebihi 750x750',
                                showConfirmButton: true
                            });
                            input.value = "";
                            fileNameSpan.textContent = 'No file chosen';
                            profileImage.src = '../img_w/<?= $userImage ?>';
                        } else {
                            profileImage.src = event.target.result;
                            fileNameSpan.textContent = file.name;
                        }
                    };
                    img.src = event.target.result;
                };

                reader.readAsDataURL(file);
            } else {
                fileNameSpan.textContent = 'No file chosen';
                profileImage.src = '../img_w/<?= $userImage ?>';
            }
        }
    </script>

    <?php
    if (isset($_SESSION['edit_successG']) && $_SESSION['edit_successG'] === true) {
        unset($_SESSION['edit_successG']);

        echo "
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Edit Gambar Profile Berhasil!',
            text: 'Tidak ada masalah!',
            showConfirmButton: true
        });
        </script>
        ";
    }
    ?>

    <?php
    if (isset($_SESSION['edit_errorG']) && $_SESSION['edit_errorG'] === true) {
        unset($_SESSION['edit_errorG']);

        echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Penambahan Gagal!',
            text: 'Gambar tidak bisa di unggah!',
            showConfirmButton: true
        });
        </script>
        ";
    }
    ?>

    <?php
    if (isset($_SESSION['edit_errorU']) && $_SESSION['edit_errorU'] === true) {
        unset($_SESSION['edit_errorU']);

        echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Penambahan Gagal!',
            text: 'Ukuran foto jangan melebihi 5MB',
            showConfirmButton: true
        });
        </script>
        ";
    }
    ?>

    <?php
    if (isset($_SESSION['edit_errorT']) && $_SESSION['edit_errorT'] === true) {
        unset($_SESSION['edit_errorT']);

        echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Penambahan Gagal!',
            text: 'Foto harus dalam format PNG atau JPEG',
            showConfirmButton: true
        });
        </script>
        ";
    }
    ?>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordField = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);

            // tombol ikon
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>

    <script>
        const togglePasswordNew = document.querySelector('#togglePasswordN');
        const passwordFieldNew = document.querySelector('#passwordN');

        togglePasswordNew.addEventListener('click', function (e) {
            const type = passwordFieldNew.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordFieldNew.setAttribute('type', type);

            // tombol ikon
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>

    <script>
        const togglePasswordConfirm = document.querySelector('#togglePasswordC');
        const passwordFieldConfirm = document.querySelector('#passwordC');

        togglePasswordConfirm.addEventListener('click', function (e) {
            const type = passwordFieldConfirm.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordFieldConfirm.setAttribute('type', type);

            // tombol ikon
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>

    <script>
        document.getElementById('passwordChangeForm').addEventListener('submit', function (e) {
            const passwordN = document.getElementById('passwordN').value;
            let errors = [];

            if (passwordN.length < 8) {
                errors.push("Password baru minimal 8 karakter.");
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
    if (isset($_SESSION['edit_successP']) && $_SESSION['edit_successP'] === true) {
        unset($_SESSION['edit_successP']);

        echo "
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Edit Password Berhasil!',
            text: 'Tidak ada masalah!',
            showConfirmButton: true
        });
        </script>
        ";
    }
    ?>

    <?php
    if (isset($_SESSION['edit_errorP']) && $_SESSION['edit_errorP'] === true) {
        unset($_SESSION['edit_errorP']);

        echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Edit Password Gagal!',
            text: 'Pastikan password lama benar!',
            showConfirmButton: true
        });
        </script>
        ";
    }
    ?>

<?php
    if (isset($_SESSION['edit_errorO']) && $_SESSION['edit_errorO'] === true) {
        unset($_SESSION['edit_errorO']);

        echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Edit Password Gagal!',
            text: 'Password baru dan konfirmasi password tidak cocok!',
            showConfirmButton: true
        });
        </script>
        ";
    }
    ?>

    <?php
    if (isset($_SESSION['edit_errorU']) && $_SESSION['edit_errorU'] === true) {
        unset($_SESSION['edit_errorU']);

        echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Edit Password Gagal!',
            text: 'Pengguna tidak di temukan!',
            showConfirmButton: true
        });
        </script>
        ";
    }
    ?>
</body>

</html>