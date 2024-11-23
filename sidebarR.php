<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header("Location: ../user/login.php");
    exit();
}

include('../koneksi.php');

$currentPage = basename($_SERVER['PHP_SELF']);

$username = $_SESSION['username'];
$query = "SELECT id_user, username, role, gambar_user FROM user WHERE username = '$username'";
$result = mysqli_query($koneksi, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userImage = !empty($row['gambar_user']) ? $row['gambar_user'] : 'pfp.png';
} else {
    $userImage = 'pfp.png';
    $row['username'] = 'Guest';
    $row['role'] = 'User';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styleR.css">
    <link rel="shortcut icon" href="../img_w/logo_d.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Icon Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Icon Boxicons  -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <div class="sidebar bg-primary bg-gradient">
        <div class="logo_content">
            <div class="logo">
                <img class="logo_brand" src="../img_w/logo_d.png" alt="cover">
                <div class="logo_name">STOKO</div>
            </div>
            <i class='bx bx-menu' id="Btn"></i>
        </div>
        <ul class="nav_list">
            <li class="<?= $currentPage === 'index_restocker.php' ? 'nav_now' : '' ?>">
                <a href="<?= $currentPage === 'index_restocker.php' ? '#' : '../restocker/index_restocker.php' ?>"
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Dashboard">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
            <li class="<?= $currentPage === 'barang_restocker.php' ? 'nav_now' : '' ?>">
                <a href="<?= $currentPage === 'barang_restocker.php' ? '#' : '../restocker/barang_restocker.php' ?>"
                    data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Barang">
                    <i class='bx bx-package'></i>
                    <span class="links_name">Barang</span>
                </a>
            </li>
        </ul>
        <ul class="nav_list_setting">
            <li>
                <a href="../user/account.php" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-title="Account">
                    <i class='bx bx-user-circle'></i>
                    <span class="links_name">Account</span>
                </a>
            </li>
        </ul>
        <div class="profile_content">
            <div class="profile">
                <div class="profile_details">
                    <img src="../img/<?= htmlspecialchars($userImage); ?>" alt="Profile Picture">
                    <div class="name_role">
                        <div class="name"><?= htmlspecialchars($row['username']); ?></div>
                        <div class="role"><?= htmlspecialchars($row['role']); ?></div>
                    </div>
                </div>
                <a href="#" id="logout">
                    <i class='bx bx-log-out' id="log_out" data-bs-toggle="tooltip" data-bs-placement="right"
                        data-bs-title="Logout"></i>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    <script>

        document.getElementById('logout').addEventListener('click', function (e) {
            e.preventDefault(); // mencegah pergi ke link di tag <a>

            Swal.fire({
                title: 'Apakah Anda Ingin Logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../user/logout.php';
                }
            });
        });
    </script>
</body>

</html>