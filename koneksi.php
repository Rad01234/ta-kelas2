<?php
$host ='localhost';
$user ='root';
$password ='';
$database ='toko';

$koneksi = mysqli_connect($host, $user, $password, $database);

if (!$koneksi){
    die ("Gagal menyambungkan database : ".mysqli_connect_error());
}

?>