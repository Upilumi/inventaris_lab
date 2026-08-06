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