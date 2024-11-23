<?php
include("../koneksi.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: /pakhir/user/login.php");
    exit;
}

$id_user = $_GET['id_user'];

if (isset($_POST['gambarP'])) {  // nama form
    $kirim_folder = "../img/";
    $ke_file = $kirim_folder . basename($_FILES["gambar"]["name"]);

    $tipe_file = $_FILES['gambar']['type'];
    $ukuran_file = $_FILES['gambar']['size'];

    $tipe = array("image/jpg", "image/jpeg", "image/png");
    $maximal_ukuran = 5 * 1024 * 1024;  // 5MB limit

    if (!in_array($tipe_file, $tipe)) {
        $_SESSION['edit_errorT'] = true;
        echo '<script>
            window.location = "account.php";
          </script>';
        exit();
    }

    if ($ukuran_file > $maximal_ukuran) {
        $_SESSION['edit_errorU'] = true;
        echo '<script>
            window.location = "account.php";
          </script>';
        exit();
    }

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $ke_file)) {
        $query = "UPDATE user SET gambar_user = '$ke_file' WHERE id_user = $id_user";

        if ($koneksi->query($query) === TRUE) {
            $_SESSION['edit_successG'] = true;
            echo '<script>
                window.location="account.php";
              </script>';
        } else {
            echo "Error: " . $query . "<br>" . $koneksi->error;
        }
    } else {
        $_SESSION['edit_errorG'] = true;
        echo '<script>
            window.location="account.php";
          </script>';
    }
}

if (isset($_POST['changePassword'])) {
    $oldPass = $_POST['oldPass'];
    $newPass = $_POST['newPass'];
    $confirmNewPass = $_POST['confirmNewPass'];

    if ($newPass !== $confirmNewPass) {
        $_SESSION['edit_errorO'] = true;
        echo '<script>
            window.location = "account.php";
          </script>';
        exit();
    }

    $query = "SELECT password FROM user WHERE id_user = '$id_user'";
    $result = mysqli_query($koneksi, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $currentPassword = $row['password'];

        if (password_verify($oldPass, $currentPassword)) {
            $hashedNewPass = password_hash($newPass, PASSWORD_DEFAULT);

            $updateQuery = "UPDATE user SET password = '$hashedNewPass' WHERE id_user = '$id_user'";
            if ($koneksi->query($updateQuery) === TRUE) {
                $_SESSION['edit_successP'] =  true;
                echo '<script>
                    window.location = "account.php";
                  </script>';
            } else {
                echo "Error: " . $updateQuery . "<br>" . $koneksi->error;
            }
        } else {
            $_SESSION['edit_errorP'] =  true;
            echo '<script>
                window.location = "account.php";
              </script>';
        }
    } else {
        $_SESSION['edit_errorU'] =  true;
        echo '<script>
            window.location = "account.php";
          </script>';
    }
}
?>