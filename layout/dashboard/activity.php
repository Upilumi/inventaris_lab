<?php

function timeAgo($datetime)
{
    $time = time() - strtotime($datetime);

    if ($time < 60)
        return "Baru saja";

    if ($time < 3600)
        return floor($time / 60) . " menit lalu";

    if ($time < 86400)
        return floor($time / 3600) . " jam lalu";

    if ($time < 172800)
        return "Kemarin";

    if ($time < 2592000)
        return floor($time / 86400) . " hari lalu";

    if ($time < 31536000)
        return floor($time / 2592000) . " bulan lalu";

    return floor($time / 31536000) . " tahun lalu";
}

$qLog = mysqli_query($conn,"
SELECT *
FROM log_aktivitas
ORDER BY created_at DESC
LIMIT 10
");

?>

<style>

.timeline{

    position:relative;

    padding-left:20px;

    max-height:450px;

    overflow-y:auto;

    padding-right:10px;

}
.timeline-item{

    position:relative;

    padding-left:45px;

    padding-bottom:30px;

}

.timeline-item:last-child{

    padding-bottom:0;

}

.timeline-item::before{

    content:"";

    position:absolute;

    left:14px;

    top:28px;

    width:2px;

    height:100%;

    background:#dee2e6;

}

.timeline-item:last-child::before{

    display:none;

}

.timeline-dot{

    position:absolute;

    left:0;

    top:4px;

    width:28px;

    height:28px;

    border-radius:50%;

    display:flex;

    justify-content:center;

    align-items:center;

    color:white;

    font-size:14px;

    font-weight:bold;

    box-shadow:0 3px 8px rgba(0,0,0,.15);

    z-index:2;

    transition:.25s;

}

.timeline-item:hover .timeline-dot{

    transform:scale(1.25);

}

.timeline-item:hover::before{

    background:#0d6efd;

}

.timeline-title{

    font-size:16px;

    font-weight:600;

}

.timeline-user{

    margin-top:2px;

    color:#6c757d;

}

.timeline-time{

    margin-top:2px;

    font-size:12px;

    color:#adb5bd;

}

.timeline::-webkit-scrollbar{

    width:7px;

}

.timeline::-webkit-scrollbar-thumb{

    background:#d0d0d0;

    border-radius:20px;

}

.timeline::-webkit-scrollbar-thumb:hover{

    background:#198754;

}

.timeline-item{

    transition:.25s;

    border-radius:12px;

    cursor:pointer;

    padding: 12px 15px 20px 45px;

}

.timeline-item:hover{

    background:#f8f9fa;

    transform:translateX(5px);

    box-shadow:0 6px 18px rgba(0,0,0,.08);

}

.card-body{

    padding:0;
}

.timeline{

    padding:18px;

}

</style>

<div class="card shadow-sm border-0">

    <div class="card-header bg-white">

<div class="d-flex justify-content-between align-items-center">

<div>

<h5 class="mb-0">

📝 Aktivitas Terbaru

</h5>

<small class="text-muted">

Aktivitas pengguna terakhir

</small>

</div>

<span class="badge bg-primary">

<?= mysqli_num_rows($qLog) ?>

</span>

</div>

</div>

    <div class="card-body">

        <div class="timeline">

<?php

while ($log = mysqli_fetch_assoc($qLog)) {

?>

<div class="timeline-item">

<div class="timeline-dot bg-<?= $log['warna'] ?>">

<?= $log['icon'] ?>

</div>

<div class="timeline-title">

<?= htmlspecialchars($log['aktivitas']) ?>

</div>

<div class="timeline-user">

<?= htmlspecialchars($log['pengguna']) ?>

</div>

<div class="timeline-time">

<?= timeAgo($log['created_at']) ?>

</div>

</div>

<?php

}

?>

        </div>

    </div>

</div>