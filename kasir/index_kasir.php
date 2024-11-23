<?php
include('../sidebarK.php');


if (!isset($_SESSION['username'])) {
    header("Location: ../user/login.php");
    exit();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Kasir') {
    header("Location: ../user/login.php");
    exit();
}

$total_transaksi = $koneksi->query("SELECT COUNT(*) AS total_transaksi FROM transaksi")->fetch_assoc()['total_transaksi'];
$total_terjual = $koneksi->query("SELECT SUM(total_harga) AS total_terjual FROM transaksi")->fetch_assoc()['total_terjual'];

$koneksi->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../styleK.css">
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


        .card {
            height: auto;
            flex-grow: 1;
            /* buat fleksibilitas bisa nge-grow */
        }

        .chart-card {
            display: flex;
            background-color: #f8f9fa;
            overflow: hidden;
            border-radius: 10px;
            align-items: center;
            padding: 20px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            height: 59vh;
            width: 100%;
        }

        @media (max-width: 768px) {
            .chart-card {
                height: 150px;
                min-height: 150px;
            }
        }

        .dashboard_icon_card {
            font-size: 65px
        }
    </style>

</head>

<body>
    <div class="home_content">
        <nav class="navbar bg-light bg-gradient shadow-sm rounded sticky-top">
            <div class="container-fluid d-flex">
                <span class="navbar-text me-auto fs-4"><strong>Dashboard</strong></span>
            </div>
        </nav>

        <div class="container-fluid mt-4">
            <div class="row row-cols-1 row-cols-md-2 g-3">
                <div class="col">
                    <div class="card text-center text-bg-danger overflow-hidden rounded-4">
                        <div class="row g-0 align-items-center">
                            <div class="col-4">
                            <i class='bx bx-wallet dashboard_icon_card'></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body text-bg-light">
                                    <h5 class="card-title"><strong>Transaksi</strong></h5>
                                    <p class="card-text fs-4"><strong><?= $total_transaksi; ?></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>   
                <div class="col">
                    <div class="card text-center text-bg-success text-white overflow-hidden rounded-4">
                        <div class="row g-0 align-items-center">
                            <div class="col-4">
                            <i class='bx bx-money dashboard_icon_card'></i>
                            </div>
                            <div class="col-8">
                                <div class="card-body text-bg-light">
                                    <h5 class="card-title"><strong>Terjual</strong></h5>
                                    <p class="card-text fs-4"><strong>Rp. <?= number_format($total_terjual) ?></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        <div class="container-fluid mt-4 mb-4">
            <div class="card chart-card">

                <canvas id="myBarChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        //ambil data daari php
        const totalTransaksi = <?= $total_transaksi; ?>;
        const totalTerjual = <?= $total_terjual; ?>;

        // menggunakan chart.js utk bar chart
        const ctx = document.getElementById('myBarChart').getContext('2d');
        const myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Transaksi', 'Total Stok'], // label tiap batang
                datasets: [{
                    label: ' Jumlah',
                    data: [totalTransaksi, totalTerjual], // data utk tiap batang
                    backgroundColor: [
                        'rgba(220, 53, 69, 0.2)',
                        'rgba(40, 167, 69, 0.2)',
                    ],
                    borderColor: [
                        'rgba(220, 53, 69, 1)',
                        'rgba(40, 167, 69, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false // menghidden legend
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
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
</body>

</html>