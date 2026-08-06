<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

include 'config/koneksi.php';

$role = $_SESSION['role'] ?? 'user';

// =========================
// AMANKAN INPUT
// =========================
$keyword = $_GET['cari'] ?? '';
$keyword = mysqli_real_escape_string($conn, $keyword);

// =========================
// QUERY
// =========================
if ($keyword != '') {
  $data = mysqli_query($conn, "
    SELECT * FROM inventaris 
    WHERE 
      kode_barang LIKE '%$keyword%' OR
      nama_barang LIKE '%$keyword%' OR
      lokasi LIKE '%$keyword%'
    ORDER BY id DESC
  ");
} else {
  $data = mysqli_query($conn, "SELECT * FROM inventaris ORDER BY id DESC");
}

$qNotif = mysqli_query($conn, "
  SELECT * FROM pengajuan_lab 
  WHERE dibaca='0'
  ORDER BY id DESC
  LIMIT 5
");

$notifCount = mysqli_num_rows($qNotif);

include 'layout/layout_start.php';
?>

<?php if(isset($_GET['success']) && $_GET['success']=="tambah"): ?>

<div class="toast-container position-fixed top-0 end-0 p-3">

    <div class="toast text-bg-success border-0" id="toastSuccess">

        <div class="d-flex">

            <div class="toast-body">
                ✅ Barang berhasil ditambahkan.
            </div>

            <button
                type="button"
                class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast">
            </button>

        </div>

    </div>

</div>

<?php endif; ?>

<!-- HEADER -->
<h4 class="mb-3 border-start border-4 ps-3"
    style="border-color:var(--nu-hijau)">
Data Inventaris
</h4>
<p class="text-muted">Daftar seluruh barang LAB</p>

<!-- CARD -->
<div class="card shadow-sm">
<div class="card-body">

<form method="GET" class="row mb-3">
  <div class="col-md-4">
    <input 
      type="text" 
      name="cari" 
      class="form-control" 
      placeholder="Cari kode / nama / lokasi barang..."
      value="<?= htmlspecialchars($keyword) ?>"
    >
  </div>
  <div class="col-md-2">
    <button class="btn btn-primary">Cari</button>
    <a href="data.php" class="btn btn-secondary">Reset</a>
  </div>
</form>

<?php if ($keyword != '') { ?>
  <div class="alert alert-info">
    Hasil pencarian: <b><?= htmlspecialchars($keyword) ?></b>
  </div>
<?php } ?>

<a href="tambah.php" class="btn btn-success mb-3">
  ➕ Tambah Barang
</a>

<!-- TABLE RESPONSIVE -->
<div class="table-responsive">
<table class="table table-bordered table-striped">

<thead style="background:var(--nu-hijau);color:white">
<tr>
  <th>No</th>
  <th>Kode</th>
  <th>Nama</th>
  <th>Jumlah</th>
  <th>Kondisi</th>
  <th>Lokasi</th>
  <?php if($role=='admin'){ ?>
  <th>Aksi</th>
  <?php } ?>
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
  <td><?= $d['jumlah'] ?></td>

  <td>
    <?php if ($d['kondisi']=='Baik') { ?>
      <span class="badge" style="background:var(--nu-hijau)">Baik</span>
    <?php } elseif ($d['kondisi']=='Rusak Ringan') { ?>
      <span class="badge" style="background:var(--nu-emas);color:black">
        Rusak Ringan
      </span>
    <?php } else { ?>
      <span class="badge bg-danger">Rusak Berat</span>
    <?php } ?>
  </td>

  <td><?= htmlspecialchars($d['lokasi']) ?></td>

  <?php if($role=='admin'){ ?>
  <td>
    <a href="edit.php?id=<?= $d['id'] ?>" class="btn btn-warning btn-sm">✏️</a>

    <a href="hapus.php?id=<?= $d['id'] ?>" 
       onclick="return confirm('Yakin hapus data ini?')"
       class="btn btn-danger btn-sm">🗑️</a>

    <a href="label.php?id=<?= $d['id'] ?>" 
       target="_blank"
       class="btn btn-info btn-sm">🏷️</a>
  </td>
  <?php } ?>

</tr>

<?php 
  }
} else {
?>

<tr>
  <td colspan="7" class="text-center text-muted">
    Tidak ada data ditemukan
  </td>
</tr>

<?php } ?>

</tbody>
</table>
</div>

</div>
</div>

<script>

document.addEventListener("DOMContentLoaded", function(){

    var toastEl = document.getElementById("toastSuccess");

    if(toastEl){

        var toast = new bootstrap.Toast(toastEl,{
            delay:3000
        });

        toast.show();

    }

});

</script>

<?php include 'layout/layout_end.php'; ?>