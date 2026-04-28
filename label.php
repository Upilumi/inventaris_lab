<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

include 'config/koneksi.php';

if (!isset($_GET['id'])) {
  exit('ID tidak ditemukan');
}

$id = $_GET['id'];
$q = mysqli_query($conn, "SELECT * FROM inventaris WHERE id='$id'");
$d = mysqli_fetch_assoc($q);

if (!$d) {
  exit('Data tidak ditemukan');
}

$jumlah_label = (int) $d['jumlah'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Label Barang</title>

<style>
body {
  font-family: Arial, sans-serif;
}

.print-btn {
  margin-bottom: 10px;
}

.page {
  display: grid;
  grid-template-columns: repeat(3, 1fr); /* 3 label per baris */
  gap: 10px;
}

.label {
  border: 2px solid #000;
  padding: 8px;
  font-size: 11px;
}

.label h4 {
  margin: 0;
  font-size: 12px;
  text-align: center;
}

.label hr {
  margin: 5px 0;
}

@media print {
  .print-btn {
    display: none;
  }
}
</style>

</head>
<body>

<button class="print-btn" onclick="window.print()">🖨️ Cetak Label</button>

<div class="page">

<?php
for ($i = 1; $i <= $jumlah_label; $i++) {
?>
  <div class="label">
    <h4>SMK UNGGULAN NU MOJOAGUNG</h4>
    <hr>
    <div><b>Kode</b> : <?= htmlspecialchars($d['kode_barang']) ?></div>
    <div><b>Nama</b> : <?= htmlspecialchars($d['nama_barang']) ?></div>
    <div><b>Lokasi</b> : <?= htmlspecialchars($d['lokasi']) ?></div>
    <div><b>Kondisi</b> : <?= htmlspecialchars($d['kondisi']) ?></div>
    <div style="margin-top:4px;">
      <small>Unit <?= $i ?> dari <?= $jumlah_label ?></small>
    </div>
  </div>
<?php } ?>

</div>

</body>
</html>
