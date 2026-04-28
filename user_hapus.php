<?php
session_start();
if (!isset($_SESSION['login'])) exit;
if($_SESSION['role']!='admin'){
  exit('Akses ditolak');
}

include 'config/koneksi.php';

$id = $_GET['id'];

// ❌ CEGAH HAPUS DIRI SENDIRI
$q = mysqli_query($conn,"SELECT username FROM users WHERE id='$id'");
$u = mysqli_fetch_assoc($q);

if($u['username'] == $_SESSION['username']){
  exit('Tidak boleh menghapus akun yang sedang dipakai');
}

mysqli_query($conn,"DELETE FROM users WHERE id='$id'");

header("Location: users.php");
