<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

$id_user = isset($_GET['id_user']) ? $_GET['id_user'] : null;

if ($id_user === null) {
    die("Id Tidak ada");
}

$query = "SELECT * FROM user WHERE id_user = '$id_user'";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query Gagal Coba perbaiki lagi : " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($result);

if ($data !== null) {
} else {
    echo "Data tidak ditemukan";
}

$userImage = $data['gambar_user'];


if ($data !== null) {
} else {
    echo "Data tidak ditemukan";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
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
        body {
            font-family: 'Kanit', sans-serif;
            overflow-y: auto;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card">
                    <div class="card-header" style="background-color: #006BFF;">

                    </div>
                    <div class="card-body bg-info">
                        <div class="centered-title d-flex justify-content-center align-items-center mb-2">
                            <h3 class="card-title text-white px-3">Edit Pegawai</h3>
                        </div>
                        <div class="border rounded p-4 bg-white">
                            <form class="row g-3" action="proses_edit_pegawai.php?id_user=<?= $id_user ?>" method="POST"
                                enctype="multipart/form-data">
                                <div class="col-12">
                                    <label for="editPegawai" class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control"
                                        value="<?php echo $data['username']; ?>" placeholder="Masukkan Nama Pegawai">
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control"
                                        value="<?php echo $data['email']; ?>" placeholder="Masukkan Email Pegawai">
                                </div>
                                <div class="col-12">
                                    <label for="role" class="form-label">Role</label>
                                    <select name="role" id="role" class="form-control custom-select-value">
                                        <option value="<?php echo $data['role']; ?>">-- <?php echo $data['role']; ?> --
                                        </option>
                                        <option value="restocker" <?php echo isset($_SESSION['input_role']) && $_SESSION['input_role'] == 'restocker' ? 'selected' : ''; ?>>Restocker
                                        </option>
                                        <option value="kasir" <?php echo isset($_SESSION['input_role']) && $_SESSION['input_role'] == 'kasir' ? 'selected' : ''; ?>>Kasir</option>
                                    </select>
                                </div>

                                <div class="col">
                                    <label for="form-label">Gambar</label>
                                    <div class="input-group mt-2">
                                        <button type="button" class="btn btn-warning"
                                            onclick="triggerFileUpload()">Choose File</button>
                                        <input type="text" id="file-name" class="form-control"
                                            value="<?= basename($data['gambar_user']); ?>" readonly>
                                        <!-- file input dihidden utk style -->
                                        <input id="file-upload" type="file" name="gambar_user"
                                            onchange="updateFileName()" style="display: none;">
                                    </div>
                                    <div class="form-text" id="basic-addon4">Hanya foto dalam format PNG dan JPEG, serta
                                        dengan ukuran Max 750x750</div>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="btn btn-success w-100" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal">
                                        Lihat Gambar
                                    </button>
                                    <div class="modal fade" id="exampleModal" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Preview Gambar
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <img id="userImage" src="../img/<?= htmlspecialchars($userImage) ?>"
                                                        width="250px" alt="Gambar Belum Di Kirim">

                                                </div>
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between text-center">
                                    <a class="btn btn-danger" href="pegawai.php">Batal</a>
                                    <button type="submit" class="btn btn-primary" name="editP">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer" style="background-color: #006BFF;">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function triggerFileUpload() {
            document.getElementById('file-upload').click();
        }

        function updateFileName() {
            const input = document.getElementById('file-upload');
            const fileNameInput = document.getElementById('file-name');
            const userImage = document.getElementById('userImage');

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
                            fileNameInput.value = 'No file chosen';
                            userImage.src = '../img/<?php echo htmlspecialchars($data['gambar_user']); ?>';
                        } else {
                            // di update jika memenuhi requirement
                            userImage.src = event.target.result;
                            fileNameInput.value = file.name;
                        }
                    };
                    // set image src utk trigger loading
                    img.src = event.target.result;
                };
                // file dibaca sebagai data url
                reader.readAsDataURL(file);
            } else {
                fileNameInput.value = 'No file chosen';
                userImage.src = '../img/<?php echo htmlspecialchars($data['gambar_user']); ?>';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            const username = document.querySelector('input[name="username"]').value.trim();
            const email = document.querySelector('input[name="email"]').value;
            let errors = [];

            if (username.length < 6) {
                errors.push("Username minimal 6 karakter.");
            } else if (/\s/.test(username)) {
                errors.push("Username tidak boleh mengandung spasi.");
            }

            if (!email.includes('@gmail.com')) {
                errors.push("Format Email harus memiliki '@gmail.com'.");
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
    if (isset($_SESSION['edit_error']) && $_SESSION['edit_error'] === true) {
        unset($_SESSION['edit_error']);

        echo "
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Edit Gagal!',
        text: 'Nama atau Email jangan sama dengan user lain!',
        showConfirmButton: true
    });
    </script>
    ";
    }
    ?>
</body>

</html>