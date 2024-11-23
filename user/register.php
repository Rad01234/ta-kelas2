<?php
session_start();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
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
            background-image: url('../img_w/register_bg.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: -1;
            font-family: 'Kanit', sans-serif;
        }

        hr {
            border: 2px solid;
        }

        .logo-brand {
            height: 40px;
        }


        .register-card {
            z-index: 0;
        }

        .register-decor1-img {
            position: absolute;
            bottom: 5%;
            left: 3%;
            width: 200px;
            height: auto;
            z-index: 1;
        }

        .register-decor2-img {
            position: absolute;
            top: 5%;
            right: 1.7%;
            width: 210px;
            height: auto;
            z-index: 1;
        }

        .centered-title .card-title {
            font-weight: 700px;
        }

        .centered-title .card-title {
            font-weight: 700;
        }
    </style>
</head>

<body>
    <div class="container">
        <img class="register-decor1-img" src="../img_w/register_decor1.png" alt="cover">
        <img class="register-decor2-img" src="../img_w/register_decor2.png" alt="cover">
        <div class="register-card pt-5 row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header" style="background-color: #006BFF;">

                    </div>
                    <div class="card-body bg-info">
                        <div class="centered-title d-flex justify-content-center align-items-center mb-2">
                            <img class="logo-brand" src="../img_w/logo_d.png" alt="logo">
                            <h3 class="card-title text-white px-3">STOKO</h3>
                            <img class="logo-brand" src="../img_w/logo_d.png" alt="logo">
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <hr class="flex-grow-1 border-dark m-0">
                            <h6 class="text-white mx-3 mb-0">REGISTER</h6>
                            <hr class="flex-grow-1 border-dark m-0">
                        </div>
                        <div class="border rounded p-4 bg-white">
                            <form class="row g-3" action="proses_register.php" method="POST">
                                <div class="col-md-6">
                                    <label for="nama" class="form-label">Username</label>
                                    <input type="text" class="form-control" name="username"
                                        placeholder="Masukkan Nama Anda"
                                        value="<?php echo isset($_SESSION['input_username']) ? $_SESSION['input_username'] : ''; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Masukkan Password Anda">
                                        <span class="input-group-text">
                                            <i class="bi bi-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                        placeholder="name@gmail.com"
                                        value="<?php echo isset($_SESSION['input_email']) ? $_SESSION['input_email'] : ''; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label class="pb-2" for="role">Role</label>
                                    <select class="form-control custom-select-value" name="role">
                                        <option value="" <?php echo empty($_SESSION['input_role']) ? 'selected' : ''; ?>>Pilih</option>
                                        <option value="restocker" <?php echo isset($_SESSION['input_role']) && $_SESSION['input_role'] == 'restocker' ? 'selected' : ''; ?>>Restocker
                                        </option>
                                        <option value="kasir" <?php echo isset($_SESSION['input_role']) && $_SESSION['input_role'] == 'kasir' ? 'selected' : ''; ?>>Kasir</option>
                                    </select>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <p>Sudah punya akun?
                                        <a class="" href="login.php">Login</a>
                                    </p>
                                    <button type="submit" class="btn btn-primary" name="login">Register</button>
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
    <div class="card-footer" style="background-color: #006BFF;">

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

            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    </script>

    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

    <?php
    if (isset($_SESSION['login_errorR']) && $_SESSION['login_errorR'] === true) {
        unset($_SESSION['login_errorR']);

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Gagal!',
                text: 'Nama tidak terdaftar!',
                showConfirmButton: true
            });
            </script>
            ";
    }

    if (isset($_SESSION['register_error']) && $_SESSION['register_error'] === true) {
        unset($_SESSION['register_error']);

        echo "
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Pendaftaran Gagal!',
                text: 'Nama atau Email sudah terdaftar!',
                showConfirmButton: true
            });
            </script>
            ";
    }

    unset($_SESSION['input_username']);
    unset($_SESSION['input_email']);
    unset($_SESSION['input_role']);
    ?>

    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            const username = document.querySelector('input[name="username"]').value.trim();
            const password = document.querySelector('input[name="password"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const role = document.querySelector('select[name="role"]').value;
            let errors = [];

            if (username.length < 6) {
                errors.push("Username minimal 6 karakter.");
            } else if (/\s/.test(username)) {
                errors.push("Username tidak boleh mengandung spasi.");
            }

            if (password.length < 8) {
                errors.push("Password minimal 8 karakter.");
            }

            if (!email.includes('@gmail.com')) {
                errors.push("Format Email harus memiliki '@gmail.com'.");
            }

            if (!role) {
                errors.push("Role harus dipilih.");
            }

            if (errors.length > 0) {
                e.preventDefault(); // batalkan pengiriman form
                let errorMessage = errors.join('\n'); // untuk setiap error yang ada, di gabung semua error
                Swal.fire({
                    icon: 'error',
                    title: 'Pendaftaran Gagal!',
                    text: errorMessage,
                    showConfirmButton: true,
                });
            }
        });
    </script>

</body>

</html>