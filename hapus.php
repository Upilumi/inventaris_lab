<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}
if($_SESSION['role']!='admin'){
  exit('Akses ditolak');
}

include 'config/koneksi.php';
$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM inventaris WHERE id='$id'");
header("Location: data.php");
