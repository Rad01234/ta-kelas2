<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" href="../img_w/logo_d.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            background-image: url(../img_w/login_bg.png);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            top: 0;
            left: 0;
            z-index: -1;
            font-family: 'Kanit', sans-serif;
        }

        .hr-with-text {
            display: flex;
            align-items: center;
            text-align: center;
        }

        .hr-with-text hr {
            flex-grow: 1;
            height: 2px;
            background-color: #000;
            margin: 0;
        }

        .hr-with-text h6 {
            margin: 0 15px;
            white-space: nowrap;
        }

        .login-card {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }

        .login-decor1-img {
            position: absolute;
            top: 6%;
            left: 50%;
            transform: translateX(-50%);
            width: 650px;
            height: auto;
            z-index: 0;

        }

        .login-decor2-img {
            position: absolute;
            bottom: 5%;
            right: 3%;
            width: 270px;
            height: auto;
            z-index: 1;
        }

        .login-decor3-img {
            position: absolute;
            top: 5%;
            left: 2%;
            width: 270px;
            height: auto;
            z-index: 1;
            transform: rotate(355deg);
        }

        .card {
            z-index: 1;
        }

        .logo-brand {
            height: 40px;
        }

        .centered-title {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .centered-title .card-title {
            font-weight: 700;
        }
    </style>

</head>

<body>
    <div class="container">
        <img class="login-decor2-img" src="../img_w/login_decor2.png" alt="cover">
        <img class="login-decor3-img" src="../img_w/login_decor3.png" alt="cover">
        <div class="login-card row justify-content-center">
            <img class="login-decor1-img" src="../img_w/login_decor1.png" alt="cover">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header" style="background-color: #006BFF;">

                    </div>
                    <div class="card-body bg-info">
                        <div class="centered-title mb-2">
                            <img class="logo-brand" src="../img_w/logo_d.png" alt="logo">
                            <h3 class="card-title text-white">STOKO</h3>
                            <img class="logo-brand" src="../img_w/logo_d.png" alt="logo">
                        </div>
                        <div class="hr-with-text mb-3">
                            <hr>
                            <h6 class="text-white">LOGIN</h6>
                            <hr>
                        </div>
                        <form class="form-control p-4" action="proses_login.php" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Masukkan Nama Anda"
                                    value="<?php echo isset($_SESSION['input_username']) ? $_SESSION['input_username'] : ''; ?>"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" name="password" id="password"
                                        placeholder="Masukkan Password Anda" required>
                                    <span class="input-group-text">
                                        <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <p>Belum punya akun? <a class="" href="register.php">Register</a></p>
                                <button type="submit" class="btn btn-primary" name="login">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer" style="background-color: #006BFF;">

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

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

    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    <?php
    if (isset($_SESSION['login_errorNP']) && $_SESSION['login_errorNP'] === true) {
        unset($_SESSION['login_errorNP']);

        echo "
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login Gagal!',
            text: 'Nama atau Password salah!',
            showConfirmButton: true
        });
    </script>
    ";
    }


    if (isset($_SESSION['register_success']) && $_SESSION['register_success'] === true) {
        unset($_SESSION['register_success']);

        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Pendaftaran Berhasil!',
            text: 'Silahkan Login',
            showConfirmButton: true
        });
    </script>
    ";
    }
    
    unset($_SESSION['input_username']);
    ?>


</body>

</html>