<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'config/koneksi.php';

/* =========================
   STATISTIK INVENTARIS
========================= */
$query = mysqli_query($conn, "
SELECT 
  COALESCE(SUM(jumlah),0) as total,
  COALESCE(SUM(CASE WHEN kondisi='Baik' THEN jumlah ELSE 0 END),0) as baik,
  COALESCE(SUM(CASE WHEN kondisi IN ('Rusak Ringan','Rusak Berat') THEN jumlah ELSE 0 END),0) as rusak
FROM inventaris
");

$data = mysqli_fetch_assoc($query);

$totalBarang = $data['total'];
$totalBaik   = $data['baik'];
$totalRusak  = $data['rusak'];

/* =========================
   HITUNG PERSENTASE
========================= */
$persenBaik  = $totalBarang ? round(($totalBaik/$totalBarang)*100) : 0;
$persenRusak = $totalBarang ? round(($totalRusak/$totalBarang)*100) : 0;

/* =========================
   NOTIFIKASI
========================= */

// barang dipinjam
$qPinjam = mysqli_query($conn, "
SELECT COUNT(*) as jml 
FROM peminjaman 
WHERE status='Dipinjam'
");
$nPinjam = mysqli_fetch_assoc($qPinjam)['jml'] ?? 0;

// jadwal hari ini
$today = date('Y-m-d');
$qLab = mysqli_query($conn, "
SELECT COUNT(*) as jml 
FROM pengajuan_lab 
WHERE tanggal='$today' 
AND status='Disetujui'
");
$nLab = mysqli_fetch_assoc($qLab)['jml'] ?? 0;

include 'layout/layout_start.php';
?>

<style>
.card-dashboard{
    border-radius:16px;
    transition:0.3s;
}
.card-dashboard:hover{
    transform:translateY(-5px);
}
.icon-box{
    font-size:30px;
}
.progress{
    height:6px;
}
</style>

<h4 class="mb-4">Dashboard</h4>

<!-- ===================== -->
<!-- CARD UTAMA -->
<!-- ===================== -->
<div class="row g-4">

<!-- TOTAL -->
<div class="col-12 col-md-4">
<div class="card card-dashboard shadow-sm">
<div class="card-body d-flex justify-content-between align-items-center">

<div>
<h6>Total Barang</h6>
<h2 class="text-primary"><?= $totalBarang ?></h2>
<small class="text-muted">Semua inventaris</small>
</div>

<div class="icon-box text-primary">📦</div>

</div>
</div>
</div>

<!-- BAIK -->
<div class="col-12 col-md-4">
<div class="card card-dashboard shadow-sm">
<div class="card-body">

<div class="d-flex justify-content-between align-items-center">
<div>
<h6>Kondisi Baik</h6>
<h2 class="text-success"><?= $totalBaik ?></h2>
</div>
<div class="icon-box text-success">✅</div>
</div>

<div class="progress mt-2">
<div class="progress-bar bg-success" style="width:<?= $persenBaik ?>%"></div>
</div>

<small class="text-muted"><?= $persenBaik ?>%</small>

</div>
</div>
</div>

<!-- RUSAK -->
<div class="col-12 col-md-4">
<div class="card card-dashboard shadow-sm">
<div class="card-body">

<div class="d-flex justify-content-between align-items-center">
<div>
<h6>Rusak</h6>
<h2 class="text-danger"><?= $totalRusak ?></h2>
</div>
<div class="icon-box text-danger">⚠️</div>
</div>

<div class="progress mt-2">
<div class="progress-bar bg-danger" style="width:<?= $persenRusak ?>%"></div>
</div>

<small class="text-muted"><?= $persenRusak ?>%</small>

</div>
</div>
</div>

</div>

<!-- ===================== -->
<!-- INFO TAMBAHAN -->
<!-- ===================== -->
<div class="row g-4 mt-3">

<div class="col-12 col-md-4">
<div class="card shadow-sm border-0">
<div class="card-body">
<h6>Barang Rusak</h6>
<h4 class="text-danger"><?= $totalRusak ?></h4>
</div>
</div>
</div>

<div class="col-12 col-md-4">
<div class="card shadow-sm border-0">
<div class="card-body">
<h6>Sedang Dipinjam</h6>
<h4 class="text-warning"><?= $nPinjam ?></h4>
</div>
</div>
</div>

<div class="col-12 col-md-4">
<div class="card shadow-sm border-0">
<div class="card-body">
<h6>Jadwal LAB Hari Ini</h6>
<h4 class="text-success"><?= $nLab ?></h4>
</div>
</div>
</div>

</div>

<?php include 'layout/layout_end.php'; ?>