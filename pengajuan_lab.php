<?php
session_start();
if (!isset($_SESSION['login'])) exit;

include 'config/koneksi.php';

/* =========================
   TANDAI NOTIF SUDAH DIBACA
========================= */
mysqli_query($conn, "UPDATE pengajuan_lab SET dibaca='1' WHERE dibaca='0'");

include 'layout/layout_start.php';


// search
$keyword = $_GET['cari'] ?? '';

if ($keyword) {
  $data = mysqli_query($conn,"
    SELECT * FROM pengajuan_lab 
    WHERE pemohon LIKE '%$keyword%' 
    OR kelas LIKE '%$keyword%'
    ORDER BY tanggal DESC
  ");
} else {
  $data = mysqli_query($conn,"SELECT * FROM pengajuan_lab ORDER BY tanggal DESC");
}
?>

<h4 class="mb-3 border-start border-4 ps-3"
    style="border-color:var(--nu-hijau)">
Pengajuan LAB
</h4>

<p class="text-muted">Kelola pengajuan penggunaan LAB</p>

<div class="card shadow-sm">
<div class="card-body">

<div class="d-flex justify-content-between flex-wrap gap-2 mb-3">

<form method="GET" class="d-flex gap-2">
  <input type="text" name="cari" class="form-control"
         placeholder="Cari pemohon / kelas..."
         value="<?= $keyword ?>">
  <button class="btn btn-success">Cari</button>
</form>

<a href="pengajuan_tambah.php" class="btn btn-success">
➕ Ajukan
</a>

</div>

<div class="table-responsive">
<table class="table table-hover align-middle">

<thead class="table-light">
<tr>
<th>Tanggal</th>
<th>Jam</th>
<th>Pemohon</th>
<th>Kelas</th>
<th>Keperluan</th>
<th>Status</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php if(mysqli_num_rows($data) == 0){ ?>
<tr>
<td colspan="7" class="text-center text-muted py-4">
Tidak ada data pengajuan
</td>
</tr>
<?php } ?>

<?php while($d=mysqli_fetch_assoc($data)){ ?>

<tr>

<td><?= date('d-m-Y', strtotime($d['tanggal'])) ?></td>

<td>
<span class="badge bg-light text-dark">
<?= $d['jam_mulai'] ?> - <?= $d['jam_selesai'] ?>
</span>
</td>

<td><?= htmlspecialchars($d['pemohon']) ?></td>
<td><?= $d['kelas'] ?></td>
<td><?= $d['keperluan'] ?></td>

<td>
<?php
$status = $d['status'];

if($status == 'Disetujui'){
  echo '<span class="badge bg-success">✔ Disetujui</span>';
}elseif($status == 'Ditolak'){
  echo '<span class="badge bg-danger">✖ Ditolak</span>';
}else{
  echo '<span class="badge bg-warning text-dark">⏳ Menunggu</span>';
}
?>
</td>

<td>

<?php if($_SESSION['role']=='admin' && $status=='Menunggu'){ ?>

<a href="pengajuan_setujui.php?id=<?= $d['id'] ?>"
   onclick="return confirm('Setujui pengajuan ini?')"
   class="btn btn-success btn-sm">
✔
</a>

<a href="pengajuan_tolak.php?id=<?= $d['id'] ?>"
   onclick="return confirm('Tolak pengajuan ini?')"
   class="btn btn-danger btn-sm">
✖
</a>

<?php } else { ?>
<span class="text-muted">-</span>
<?php } ?>

</td>

</tr>

<?php } ?>

</tbody>
</table>
</div>

</div>
</div>

<?php include 'layout/layout_end.php'; ?>