<?php 
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}
include 'config/koneksi.php'; 

include 'layout/layout_start.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Inventaris</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">


<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-7">

      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
          <h5 class="mb-0">Tambah Data Inventaris</h5>
        </div>

        <div class="card-body">
          <form method="POST">

            <div class="mb-3">
              <label class="form-label">Kode Barang</label>
              <input type="text" name="kode" class="form-control" placeholder="Contoh: PC-LAB-01" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Nama Barang</label>
              <input type="text" name="nama" class="form-control" placeholder="Contoh: Komputer PC" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Jumlah</label>
              <input type="number" name="jumlah" class="form-control" min="1" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Kondisi</label>
              <select name="kondisi" class="form-select" required>
                <option value="">-- Pilih Kondisi --</option>
                <option>Baik</option>
                <option>Rusak Ringan</option>
                <option>Rusak Berat</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Lokasi</label>
              <input type="text" name="lokasi" class="form-control" placeholder="Contoh: LAB Komputer 1 / Meja 05">
            </div>

            <div class="mb-3">
              <label class="form-label">Keterangan</label>
              <textarea name="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
            </div>

            <div class="d-flex justify-content-between">
              <button type="submit" name="simpan" class="btn btn-primary">
                💾 Simpan Data
              </button>
              <a href="data.php" class="btn btn-outline-secondary">
                Batal
              </a>
            </div>

          </form>
        </div>

      </div>

      <?php
      if (isset($_POST['simpan'])) {
        mysqli_query($conn, "
          INSERT INTO inventaris VALUES(
            null,
            '$_POST[kode]',
            '$_POST[nama]',
            '$_POST[jumlah]',
            '$_POST[kondisi]',
            '$_POST[lokasi]',
            '$_POST[keterangan]'
          )
        ");
        echo '<div class="alert alert-success mt-3">Data inventaris berhasil disimpan.</div>';
      }
      ?>

    </div>
  </div>
</div>

</body>
</html>

<?php include 'layout/layout_end.php'; ?>