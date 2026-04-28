<?php
include 'config/koneksi.php';

$q = mysqli_query($conn, "SELECT COUNT(*) as total FROM pengajuan_lab WHERE dibaca='0'");
$d = mysqli_fetch_assoc($q);

echo $d['total'];