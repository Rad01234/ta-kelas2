<?php
include('koneksi.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="shortcut icon" href="img_w/logo_d.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Protest+Strike&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to top, rgba(255, 255, 255, 0), rgba(255, 255, 255, 1) 100%), url(./img_w/index_bg.png);
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 100vh;
            margin: 0;
            overflow-x: hidden;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
            /* modif opacity */
            z-index: -1;
        }

        .container {
            position: relative;
            /* buat relative utk posisi kontennya */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* center content vertically */
            width: 100%;
            text-align: center;
            z-index: 1;
        }

        .welcome {
            margin: 80px 0 0 0;
        }

        .welcome-text {
            font-family: 'Protest Strike', sans-serif;
            font-size: 4.0rem;
        }

        .index-decor1-img {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: auto;
            z-index: 0;

        }

        @keyframes slideInFromRight {
            0% {
                transform: translateX(100%);
                /* mulai off screen  dari kanan */
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                /* hingga muncul ke posisi awal */
                opacity: 1;
            }
        }

        .index-decor2-img {
            position: absolute;
            bottom: 5%;
            right: 0%;
            width: 230px;
            height: auto;
            z-index: 0;
            animation: slideInFromRight 0.4s ease-out forwards;
            /* menambbahkan animasi sesuai nama */
        }

        .index-decor3-img {
            position: absolute;
            bottom: 5%;
            left: 3%;
            width: 230px;
            height: auto;
            z-index: 0;
        }

        .mulai {}

        .btn-mulai {
            font-size: 2.0rem;
            width: 225px;
            height: 70px;
            border-radius: 30px;
            border: none;
        }

        .introduction {
            font-family: 'kanit', sans-serif;
            margin: 40px 0;
            padding: 0 40px;
            text-align: center;
            width: 100%;
            max-width: 900px;
            /* Set max width utk modif wrapping */
            flex-grow: 1;
            /* membolehkan utk grow tapi ngak mendorong elemen lain kebawah */
            min-height: 65px;
        }

        .typed-text {
            border-right: 2px solid black;
            white-space: pre-wrap;
            overflow: hidden;
            display: inline;
            max-width: 100%;
            /* tidak boleh overflow dari container */
        }
    </style>
</head>

<body>
    <div class="overlay"></div>
    <img class="index-decor1-img" src="./img_w/index_decor1.png" alt="cover">
    <img class="index-decor2-img" src="./img_w/index_decor2.png" alt="cover">
    <img class="index-decor3-img" src="./img_w/index_decor3.png" alt="cover">
    <div class="container">
        <div class="welcome">
            <h1 class="welcome-text">Selamat Datang!</h1>
        </div>
        <div class="introduction">
            <strong>
                <p>
                    <span class="typed-text"></span>
                </p>
            </strong>
        </div>
        <div class="mulai">
            <a class="btn-mulai btn btn-success text-decoration-none text-white" href="./user/login.php">
                <strong>Mulai</strong>
            </a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script>
        const text = "STOKO adalah Aplikasi Manajer Inventaris Stok Toko Perlengkapan Sekolah berbasis website yang bertujuan untuk membantu dalam pengelolaan data stok bagi Admin, Restocker, maupun Kasir"

        const typedTextElement = document.querySelector('.typed-text');
        let index = 0;

        function type() {
            if (index < text.length) {
                typedTextElement.innerHTML += text.charAt(index);
                index++;
                // kecepatan ketik
                setTimeout(type, 20); 
            } else {
                typedTextElement.style.borderRight = "none";
            }
        }
        type();
    </script>
</body>

</html>