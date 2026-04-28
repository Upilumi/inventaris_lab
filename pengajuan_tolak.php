<?php
session_start();
if($_SESSION['role']!='admin') exit;

include 'config/koneksi.php';

mysqli_query($conn,"
UPDATE pengajuan_lab 
SET status='Ditolak'
WHERE id='$_GET[id]'
");

header("Location: pengajuan_lab.php");
