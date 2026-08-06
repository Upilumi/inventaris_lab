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

include 'layout/dashboard/hero.php';
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

.dashboard-hero{
    border-radius:20px;
    background:linear-gradient(135deg,#0d6efd,#20c997);
    color:white;
}

.dashboard-hero p,
.dashboard-hero small{
    color:rgba(255,255,255,.9)!important;
}

.dashboard-hero h5{
    color:white;
}
</style>

<?php include 'layout/dashboard/cards.php'; ?>

<?php include 'layout/dashboard/charts.php'; ?>

<div class="row mt-4">

    <div class="col-lg-8">

        <?php
        include 'layout/dashboard/activity.php';
        ?>

    </div>

    <div class="col-lg-4">

        <?php
        include 'layout/dashboard/quick_action.php';
        ?>

    </div>

</div>

<div class="row mt-4">

    <div class="col-lg-6">
        <?php include 'layout/dashboard/latest_items.php'; ?>
    </div>

    <div class="col-lg-6">

        <!-- nanti kita isi Barang Hampir Habis -->

    </div>

</div>

<?php include 'layout/dashboard/widgets.php'; ?>

<?php include 'layout/layout_end.php'; ?>