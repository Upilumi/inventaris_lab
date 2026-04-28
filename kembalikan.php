<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

include 'config/koneksi.php';

if (!isset($_GET['id'])) {
  header("Location: peminjaman.php");
  exit;
}

$id = $_GET['id'];

// Ambil data peminjaman
$q = mysqli_query($conn, "
  SELECT * FROM peminjaman 
  WHERE id='$id' AND status='Dipinjam'
");
$data = mysqli_fetch_assoc($q);

if (!$data) {
  header("Location: peminjaman.php");
  exit;
}

// Tambah stok inventaris
mysqli_query($conn, "
  UPDATE inventaris 
  SET jumlah = jumlah + {$data['jumlah']}
  WHERE kode_barang = '{$data['kode_barang']}'
");

// Update status peminjaman
mysqli_query($conn, "
  UPDATE peminjaman 
  SET status='Dikembalikan'
  WHERE id='$id'
");

header("Location: peminjaman.php");
exit;
