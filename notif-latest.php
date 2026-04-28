<?php
include 'config/koneksi.php';

$q = mysqli_query($conn, "
  SELECT * FROM pengajuan_lab 
  WHERE dibaca='0'
  ORDER BY id DESC
  LIMIT 1
");

$data = mysqli_fetch_assoc($q);

echo json_encode($data);