<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

include 'config/koneksi.php';

$role = $_SESSION['role'] ?? 'user';

// =====================
// FILTER AMAN
// =====================
$dari   = $_GET['dari'] ?? '';
$sampai = $_GET['sampai'] ?? '';
$status = $_GET['status'] ?? '';

$dari   = mysqli_real_escape_string($conn, $dari);
$sampai = mysqli_real_escape_string($conn, $sampai);
$status = mysqli_real_escape_string($conn, $status);

// =====================
// QUERY
// =====================
$sql = "SELECT * FROM peminjaman WHERE 1=1";

if ($dari && $sampai) {
  $sql .= " AND tanggal_pinjam BETWEEN '$dari' AND '$sampai'";
}

if ($status) {
  $sql .= " AND status='$status'";
}

$sql .= " ORDER BY id DESC";

$data = mysqli_query($conn, $sql);

include 'layout/layout_start.php';
?>

<!-- HEADER -->
<h4 class="mb-3 border-start border-4 ps-3"
    style="border-color:var(--nu-hijau)">
Peminjaman Barang
</h4>
<p class="text-muted">Data peminjaman barang LAB</p>

<div class="card shadow-sm">
<div class="card-body">

<!-- ACTION -->
<div class="mb-3 d-flex gap-2 flex-wrap">
  <a href="tambah_peminjaman.php" class="btn btn-success">
    ➕ Tambah Peminjaman
  </a>

  <?php if($role=='admin'){ ?>
  <a href="export_peminjaman.php?dari=<?= $dari ?>&sampai=<?= $sampai ?>&status=<?= $status ?>"
     class="btn btn-outline-success">
     ⬇ Export Excel
  </a>
  <?php } ?>
</div>

<!-- FILTER -->
<form method="GET" class="row g-2 mb-3">

  <div class="col-md-3">
    <label class="form-label">Dari</label>
    <input type="date" name="dari" class="form-control"
           value="<?= htmlspecialchars($dari) ?>">
  </div>

  <div class="col-md-3">
    <label class="form-label">Sampai</label>
    <input type="date" name="sampai" class="form-control"
           value="<?= htmlspecialchars($sampai) ?>">
  </div>

  <div class="col-md-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
      <option value="">Semua</option>
      <option value="Dipinjam" <?= $status=='Dipinjam'?'selected':'' ?>>Dipinjam</option>
      <option value="Dikembalikan" <?= $status=='Dikembalikan'?'selected':'' ?>>Dikembalikan</option>
    </select>
  </div>

  <div class="col-md-3 d-flex align-items-end">
    <button class="btn btn-primary me-2">Filter</button>
    <a href="peminjaman.php" class="btn btn-secondary">Reset</a>
  </div>

</form>

<!-- TABLE -->
<div class="table-responsive">
<table class="table table-bordered table-hover">

<thead style="background:var(--nu-hijau);color:white">
<tr>
  <th>No</th>
  <th>Kode</th>
  <th>Nama</th>
  <th>Peminjam</th>
  <th>Jumlah</th>
  <th>Tgl Pinjam</th>
  <th>Tgl Kembali</th>
  <th>Status</th>
  <th>Aksi</th>
</tr>
</thead>

<tbody>

<?php
$no = 1;

if (mysqli_num_rows($data) > 0) {
  while ($d = mysqli_fetch_assoc($data)) {
?>

<tr>
  <td><?= $no++ ?></td>
  <td><?= htmlspecialchars($d['kode_barang']) ?></td>
  <td><?= htmlspecialchars($d['nama_barang']) ?></td>
  <td><?= htmlspecialchars($d['peminjam']) ?></td>
  <td><?= $d['jumlah'] ?></td>
  <td><?= $d['tanggal_pinjam'] ?></td>
  <td><?= $d['tanggal_kembali'] ?></td>

  <td>
    <?php if ($d['status']=='Dipinjam') { ?>
      <span class="badge bg-warning text-dark">Dipinjam</span>
    <?php } else { ?>
      <span class="badge bg-success">Dikembalikan</span>
    <?php } ?>
  </td>

  <td>
    <?php if ($d['status']=='Dipinjam') { ?>
      <a href="kembalikan.php?id=<?= $d['id'] ?>"
         onclick="return confirm('Yakin barang sudah dikembalikan?')"
         class="btn btn-success btn-sm">
         🔁
      </a>
    <?php } else { ?>
      <span class="text-muted">✔</span>
    <?php } ?>
  </td>

</tr>

<?php 
  }
} else {
?>

<tr>
  <td colspan="9" class="text-center text-muted">
    Belum ada data peminjaman
  </td>
</tr>

<?php } ?>

</tbody>
</table>
</div>

</div>
</div>

<?php include 'layout/layout_end.php'; ?>