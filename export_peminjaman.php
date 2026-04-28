<?php
session_start();
if (!isset($_SESSION['login'])) exit;

include 'config/koneksi.php';

$dari   = $_GET['dari']   ?? '';
$sampai = $_GET['sampai'] ?? '';
$status = $_GET['status'] ?? '';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=laporan_peminjaman.xls");

$sql = "SELECT * FROM peminjaman WHERE 1=1";

$nama = "laporan_peminjaman_" . date('Ymd') . ".xls";
header("Content-Disposition: attachment; filename=$nama");

if ($dari && $sampai) {
  $sql .= " AND tanggal_pinjam BETWEEN '$dari' AND '$sampai'";
}

if ($status != '') {
  $sql .= " AND status='$status'";
}

$sql .= " ORDER BY id DESC";

$data = mysqli_query($conn, $sql);

echo "<h3>Laporan Peminjaman Barang LAB</h3>";

if ($dari && $sampai) {
  echo "Periode: $dari s/d $sampai<br>";
}
if ($status) {
  echo "Status: $status<br>";
}

echo "<table border='1'>
<tr>
<th>No</th>
<th>Kode</th>
<th>Nama</th>
<th>Peminjam</th>
<th>Jumlah</th>
<th>Tgl Pinjam</th>
<th>Tgl Kembali</th>
<th>Status</th>
</tr>";

$no=1;
while($d=mysqli_fetch_assoc($data)){

echo "<tr>
<td>$no</td>
<td>{$d['kode_barang']}</td>
<td>{$d['nama_barang']}</td>
<td>{$d['peminjam']}</td>
<td>{$d['jumlah']}</td>
<td>{$d['tanggal_pinjam']}</td>
<td>{$d['tanggal_kembali']}</td>
<td>{$d['status']}</td>
</tr>";

$no++;
}

echo "</table>";
