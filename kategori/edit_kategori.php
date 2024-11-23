<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

$id_kategori = isset($_GET['id_kategori']) ? $_GET['id_kategori'] : null;

if ($id_kategori === null) {
    die("Id Tidak ada");
}

$query = "SELECT * FROM kategori WHERE id_kategori = '$id_kategori'";
$result = mysqli_query($koneksi, $query);

if (!$result) {
    die("Query Gagal Coba perbaiki lagi : " . mysqli_error($koneksi));
}

$data = mysqli_fetch_assoc($result);

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
</head>
<body>
<h5><?php echo $_SESSION['username']; ?></h5>

    <form role="form" action="proses_edit_kategori.php?id_kategori=<?= $id_kategori ?>" method="POST">
    <div>
    <label for="tambahKategori">Kategori</label>
    <input type="text" name="kategori" value="<?= $data['nama_kategori']; ?>">
    </div>
    <input type="submit" value="Submit" name="editK">
    </form>
</body>
</html>