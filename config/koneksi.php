<?php

date_default_timezone_set('Asia/Jakarta');

$host = "localhost";
$user = "labuser";
$pass = "123456";
$db   = "inventaris_lab";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal");
}

mysqli_set_charset($conn, "utf8mb4");

require_once __DIR__ . '/../helpers/activity_helper.php';