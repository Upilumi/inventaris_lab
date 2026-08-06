<?php

function latestTimeAgo($datetime)
{
    $time = time() - strtotime($datetime);

    if ($time < 60) return "Baru saja";
    if ($time < 3600) return floor($time/60)." menit lalu";
    if ($time < 86400) return floor($time/3600)." jam lalu";
    if ($time < 172800) return "Kemarin";
    return floor($time/86400)." hari lalu";
}

$qBarang = mysqli_query($conn,"
SELECT *
FROM inventaris
ORDER BY created_at DESC
LIMIT 5
");
?>

<style>

.latest-item{
    display:flex;
    align-items:center;
    gap:15px;
    padding:15px;
    border-radius:14px;
    transition:.25s;
    cursor:pointer;
}

.latest-item:hover{
    background:#f8f9fa;
    transform:translateX(6px);
}

.latest-icon{
    width:55px;
    height:55px;
    border-radius:14px;
    background:#19875415;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:24px;
}

.latest-title{
    font-weight:600;
    font-size:15px;
}

.latest-meta{
    font-size:13px;
    color:#6c757d;
}

.latest-time{
    font-size:12px;
    color:#adb5bd;
}

</style>

<div class="card shadow-sm border-0">

<div class="card-header bg-white">

<div class="d-flex justify-content-between align-items-center">

<div>

<h5 class="mb-0">📦 Barang Terbaru</h5>

<small class="text-muted">
5 barang terakhir ditambahkan
</small>

</div>

</div>

</div>

<div class="card-body">

<?php if(mysqli_num_rows($qBarang)==0){ ?>

<div class="text-center text-muted py-4">

Belum ada data barang.

</div>

<?php } ?>

<?php while($b=mysqli_fetch_assoc($qBarang)){ ?>

<div class="latest-item">

<div class="latest-icon">

📦

</div>

<div class="flex-grow-1">

<div class="latest-title">

<?= htmlspecialchars($b['nama_barang']) ?>

</div>

<div class="latest-meta">

<?= htmlspecialchars($b['kode_barang']) ?>

•
<?= $b['jumlah'] ?> Unit

•
<?= htmlspecialchars($b['lokasi']) ?>

</div>

<div class="latest-time">

<?= latestTimeAgo($b['created_at']) ?>

</div>

</div>

<div>

<?php

$badge="success";

if($b['kondisi']=="Rusak Ringan")
    $badge="warning";

if($b['kondisi']=="Rusak Berat")
    $badge="danger";

?>

<span class="badge bg-<?= $badge ?>">

<?= $b['kondisi'] ?>

</span>

</div>

</div>

<?php } ?>

</div>

</div>