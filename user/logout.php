<?php 
session_start();
session_destroy();
header("location: /pakhir/index.php");
?>