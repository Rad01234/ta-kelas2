<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

$id_barang = isset($_GET['id_barang']) ? $_GET['id_barang'] : null;

if ($id_barang === null) {
    die("Id Tidak ada");
}

$query = "SELECT * FROM barang WHERE id_barang = '$id_barang'";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query Gagal Coba perbaiki lagi : " . mysqli_error($koneksi));
}

$cek = "SELECT id_kategori FROM barang WHERE id_barang ='$id_barang'";
$data_kategori = mysqli_query($koneksi, $cek);

if ($data_kategori && mysqli_num_rows($data_kategori) > 0) {
    $row = mysqli_fetch_assoc($data_kategori);
    $id_kategori = $row['id_kategori'];

    $query = "SELECT * FROM kategori WHERE id_kategori = $id_kategori";
    $result2 = mysqli_query($koneksi, $query);

}

$data = mysqli_fetch_assoc($result);
$kategori = mysqli_fetch_assoc($result2);

$itemImage = $data['gambar'];


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
        <div class="row justify-content-center pt-4 mb-2">
            <div class="col-8">
                <div class="card">
                    <div class="card-header" style="background-color: #006BFF;">

                    </div>
                    <div class="card-body bg-info">
                        <div class="centered-title d-flex justify-content-center align-items-center mb-2">
                            <h3 class="card-title text-white px-3">Edit Barang</h3>
                        </div>
                        <div class="border rounded p-4 bg-white">
                            <form class="row g-3" action="proses_edit_barang.php?id_barang=<?= $id_barang ?>"
                                method="POST" enctype="multipart/form-data">
                                <div class="col-md-6">
                                    <label for="editBarang" class="form-label">Barang</label>
                                    <input type="text" name="nama" value="<?php echo $data['nama_barang']; ?>"
                                        class="form-control" placeholder="Masukkan Nama Barang">
                                </div>
                                <div class="col-md-6">
                                    <label for="harga_satuan" class="form-label">Harga</label>
                                    <input type="number" name="harga_satuan"
                                        value="<?php echo $data['harga_satuan']; ?>" class="form-control"
                                        placeholder="Masukkan Harga">
                                </div>
                                <div class="col-4">
                                    <label for="stok" class="form-label">Stok</label>
                                    <input type="number" name="stok" value="<?php echo $data['stok']; ?>"
                                        class="form-control" placeholder="Masukkan Stok Barang">
                                </div>
                                <div class="col-4">
                                    <label for="merek" class="form-label">Merek</label>
                                    <input type="text" name="merek" value="<?php echo $data['merek']; ?>"
                                        class="form-control" placeholder="Masukkan Nama Merek">
                                </div>
                                <div class="col-4">
                                    <label for="kategori" class="form-label">Kategori</label>
                                    <select name="kategori" id="kategori" class="form-control custom-select-value">
                                        <option value="">Pilih</option>
                                        <?php
                                        $query = "SELECT * FROM kategori";
                                        $cek = mysqli_query($koneksi, $query);

                                        while ($row = mysqli_fetch_array($cek)) {
                                            $selected = ($row['id_kategori'] == $kategori['id_kategori']) ? 'selected' : '';
                                            echo '<option value="' . $row['id_kategori'] . '" ' . $selected . '>' . $row['nama_kategori'] . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="form-label">Gambar</label>
                                    <div class="input-group mt-2">
                                        <button type="button" class="btn btn-warning"
                                            onclick="triggerFileUpload()">Choose File</button>
                                            <input type="text" id="file-name" class="form-control" value="<?= basename($data['gambar']); ?>" readonly>
                                        <!-- ffile input dihidden utk style -->
                                        <input id="file-upload" type="file" name="gambar" onchange="updateFileName()"
                                            style="display: none;">
                                    </div>
                                    <div class="form-text" id="basic-addon4">Hanya foto dalam format PNG dan JPG, serta
                                        dengan ukuran Max 1000x1000</div>
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

                                                    <img id="itemImage" src="../img/<?= htmlspecialchars($itemImage) ?>"
                                                        width="250px" alt="Gambar Belum Di Kirim">

                                                </div>
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between text-center">
                                    <a class="btn btn-danger" href="barang.php">Batal</a>
                                    <button type="submit" class="btn btn-primary" name="editB">Save</button>
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
            const itemImage = document.getElementById('itemImage');

            if (input.files.length > 0) {
                const file = input.files[0];
                const reader = new FileReader();

                reader.onload = function (event) {
                    const img = new Image();
                    img.onload = function () {
                        if (img.width > 1000 || img.height > 1000) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Foto kebesaran!',
                                text: 'Gunakan foto yang tidak melebihi 1000x1000',
                                showConfirmButton: true
                            });
                            input.value = "";
                            fileNameInput.value = 'No file chosen';
                            itemImage.src = '../img/<?php echo htmlspecialchars($data['gambar']); ?>';
                        } else {
                            // di update jika memenuhi requirement
                            itemImage.src = event.target.result;
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
                itemImage.src = '../img/<?php echo htmlspecialchars($data['gambar']); ?>';
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelector("form").addEventListener("submit", function (e) {
            const namaBarang = document.querySelector("input[name='nama']").value.trim();
            const harga = document.querySelector("input[name='harga_satuan']").value.trim();
            const stok = document.querySelector("input[name='stok']").value.trim();
            const merek = document.querySelector("input[name='merek']").value.trim();
            const kategori = document.querySelector("select[name='kategori']").value;
            const namaRegex = /^[a-zA-Z0-9\s\-\/]+$/; // huruf, angka, spasi, tanda hubung, dan garis miring.
            let errors = [];

            if (namaBarang === "" || !namaRegex.test(namaBarang)) {
                errors.push("Nama barang tidak boleh kosong dan tidak boleh mengandung simbol.");
            }

            if (harga === "" || isNaN(harga) || Number(harga) <= 0) {
                errors.push("Harga harus berupa angka positif dan tidak boleh kosong.");
            }

            if (stok === "" || isNaN(stok) || Number(stok) <= 0) {
                errors.push("Stok harus berupa angka positif dan tidak boleh kosong.");
            }

            if (merek === "") {
                errors.push("Merek harus diisi.");
            }

            if (kategori === "") {
                errors.push("Kategori harus dipilih.");
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
        text: 'Barang sudah tersedia!',
        showConfirmButton: true
    });
    </script>
    ";
    }
    ?>
</body>
</html>