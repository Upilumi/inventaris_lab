<?php

date_default_timezone_set('Asia/Jakarta');

$host = "localhost";
$user = "inventaris_user";
$pass = "123321";
$db   = "inventaris_lab";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal");
}

mysqli_set_charset($conn, "utf8mb4");