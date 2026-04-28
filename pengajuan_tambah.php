<?php
session_start();
if (!isset($_SESSION['login'])) exit;

include 'config/koneksi.php';
include 'layout/layout_start.php';

?>

<h4 class="mb-3 border-start border-4 ps-3"
    style="border-color:var(--nu-hijau)">
Ajukan Penggunaan LAB
</h4>

<div class="card shadow-sm">
<div class="card-body">

<form method="POST">

<div class="row">

<div class="col-md-4 mb-3">
<label class="form-label">Tanggal</label>
<input type="date" name="tanggal" class="form-control" required>
</div>

<div class="col-md-4 mb-3">
<label class="form-label">Jam Mulai</label>
<input type="time" name="jam_mulai" class="form-control" required>
</div>

<div class="col-md-4 mb-3">
<label class="form-label">Jam Selesai</label>
<input type="time" name="jam_selesai" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Pemohon</label>
<input type="text" name="pemohon" class="form-control" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Kelas</label>
<input type="text" name="kelas" class="form-control" required>
</div>

<div class="col-md-12 mb-3">
<label class="form-label">Keperluan</label>
<textarea name="keperluan" class="form-control" required></textarea>
</div>

</div>

<button type="submit" name="simpan" class="btn btn-success">
💾 Ajukan
</button>

</form>

</div>
</div>

<?php
// ==========================
// PROSES SIMPAN
// ==========================
if(isset($_POST['simpan'])){

  $tanggal     = $_POST['tanggal'];
  $jam_mulai   = $_POST['jam_mulai'];
  $jam_selesai = $_POST['jam_selesai'];
  $pemohon     = mysqli_real_escape_string($conn, $_POST['pemohon']);
  $kelas       = mysqli_real_escape_string($conn, $_POST['kelas']);
  $keperluan   = mysqli_real_escape_string($conn, $_POST['keperluan']);

  // ==========================
  // VALIDASI TANGGAL MASA LALU
  // ==========================
  if($tanggal < date('Y-m-d')){
    echo alert("Tidak bisa memilih tanggal yang sudah lewat", "danger");
    exit;
  }

  // ==========================
  // VALIDASI JAM
  // ==========================
  if($jam_mulai >= $jam_selesai){
    echo alert("Jam tidak valid (mulai harus lebih kecil)", "danger");
    exit;
  }

  // ==========================
  // CEK BENTROK
  // ==========================
  $cek = mysqli_query($conn, "
    SELECT * FROM pengajuan_lab
    WHERE tanggal='$tanggal'
    AND status!='Ditolak'
    AND (
      ('$jam_mulai' < jam_selesai)
      AND
      ('$jam_selesai' > jam_mulai)
    )
  ");

  if(mysqli_num_rows($cek) > 0){
    $b = mysqli_fetch_assoc($cek);

    echo "<div class='alert alert-danger mt-3'>
    ❌ Jadwal bentrok dengan:
    <br><b>{$b['pemohon']}</b>
    <br>Jam: {$b['jam_mulai']} - {$b['jam_selesai']}
    </div>";
    exit;
  }

  // ==========================
  // INSERT DATA
  // ==========================
  mysqli_query($conn,"
    INSERT INTO pengajuan_lab
    (tanggal, jam_mulai, jam_selesai, pemohon, kelas, keperluan, status)
    VALUES
    ('$tanggal','$jam_mulai','$jam_selesai','$pemohon','$kelas','$keperluan','Menunggu')
  ");

  echo alert("Pengajuan berhasil dikirim!", "success");

  echo "<meta http-equiv='refresh' content='1;url=pengajuan_lab.php'>";
}

// helper alert
function alert($msg,$type){
  return "<div class='alert alert-$type mt-3'>$msg</div>";
}
?>

<?php include 'layout/layout_end.php'; ?>