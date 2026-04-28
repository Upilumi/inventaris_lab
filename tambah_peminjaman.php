<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

include 'config/koneksi.php';

// ambil data barang
$inventaris = mysqli_query($conn, "SELECT * FROM inventaris ORDER BY nama_barang ASC");

include 'layout/layout_start.php';
?>

<h4 class="mb-3 border-start border-4 ps-3"
    style="border-color:var(--nu-hijau)">
Tambah Peminjaman
</h4>
<p class="text-muted">Input data peminjaman barang LAB</p>

<div class="card shadow-sm">
<div class="card-body">

<form method="POST">

<div class="row">

<!-- BARANG -->
<div class="col-md-6 mb-3">
  <label class="form-label">Barang</label>
  <select name="kode_barang" id="barang" class="form-select" required>
    <option value="">-- Pilih Barang --</option>
    <?php while ($b = mysqli_fetch_assoc($inventaris)) { ?>
      <option 
        value="<?= $b['kode_barang'] ?>"
        data-nama="<?= $b['nama_barang'] ?>"
        data-stok="<?= $b['jumlah'] ?>"
      >
        <?= $b['kode_barang'] ?> - <?= $b['nama_barang'] ?>
      </option>
    <?php } ?>
  </select>
  <small class="text-muted">Stok: <span id="stok">-</span></small>
</div>

<!-- PEMINJAM -->
<div class="col-md-6 mb-3">
  <label class="form-label">Nama Peminjam</label>
  <input type="text" name="peminjam" class="form-control" required>
</div>

<!-- JUMLAH -->
<div class="col-md-4 mb-3">
  <label class="form-label">Jumlah</label>
  <input type="number" name="jumlah" id="jumlah" class="form-control" min="1" required>
</div>

<!-- TANGGAL PINJAM -->
<div class="col-md-4 mb-3">
  <label class="form-label">Tanggal Pinjam</label>
  <input type="date" name="tanggal_pinjam" class="form-control" required>
</div>

<!-- TANGGAL KEMBALI -->
<div class="col-md-4 mb-3">
  <label class="form-label">Tanggal Kembali</label>
  <input type="date" name="tanggal_kembali" class="form-control">
</div>

</div>

<div class="d-flex gap-2">
  <button type="submit" name="simpan" class="btn btn-success">
    💾 Simpan
  </button>
  <a href="peminjaman.php" class="btn btn-secondary">
    Batal
  </a>
</div>

</form>

</div>
</div>

<?php
// ======================
// PROSES SIMPAN
// ======================
if (isset($_POST['simpan'])) {

  $kode_barang = mysqli_real_escape_string($conn, $_POST['kode_barang']);
  $peminjam    = mysqli_real_escape_string($conn, $_POST['peminjam']);
  $jumlah      = (int) $_POST['jumlah'];
  $tgl_pinjam  = $_POST['tanggal_pinjam'];
  $tgl_kembali = $_POST['tanggal_kembali'] ?: NULL;

  // ambil barang
  $q = mysqli_query($conn, "SELECT * FROM inventaris WHERE kode_barang='$kode_barang'");
  $barang = mysqli_fetch_assoc($q);

  if (!$barang) {
    echo alert("Barang tidak ditemukan", "danger");

  } elseif ($jumlah <= 0) {
    echo alert("Jumlah tidak valid", "danger");

  } elseif ($jumlah > $barang['jumlah']) {
    echo alert("Stok tidak cukup! Sisa: ".$barang['jumlah'], "warning");

  } elseif ($tgl_kembali && $tgl_kembali < $tgl_pinjam) {
    echo alert("Tanggal kembali tidak boleh sebelum tanggal pinjam", "danger");

  } else {

    // insert
    mysqli_query($conn, "
      INSERT INTO peminjaman 
      (kode_barang, nama_barang, peminjam, jumlah, tanggal_pinjam, tanggal_kembali, status)
      VALUES (
        '$kode_barang',
        '".$barang['nama_barang']."',
        '$peminjam',
        '$jumlah',
        '$tgl_pinjam',
        ".($tgl_kembali ? "'$tgl_kembali'" : "NULL").",
        'Dipinjam'
      )
    ");

    // update stok
    mysqli_query($conn, "
      UPDATE inventaris 
      SET jumlah = jumlah - $jumlah 
      WHERE kode_barang='$kode_barang'
    ");

    echo alert("Peminjaman berhasil!", "success");

    echo "<meta http-equiv='refresh' content='1;url=peminjaman.php'>";
  }
}

// helper alert
function alert($msg, $type){
  return "<div class='alert alert-$type mt-3'>$msg</div>";
}
?>

<script>
// AUTO TAMPIL STOK
document.getElementById('barang').addEventListener('change', function(){
  let stok = this.options[this.selectedIndex].dataset.stok;
  document.getElementById('stok').innerText = stok ?? '-';
});
</script>

<?php include 'layout/layout_end.php'; ?>