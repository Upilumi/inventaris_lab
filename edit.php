<?php
session_start();
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}

include 'config/koneksi.php';

if (!isset($_GET['id'])) {
  header("Location: data.php");
  exit;
}

$id = $_GET['id'];
$data = mysqli_query($conn, "SELECT * FROM inventaris WHERE id='$id'");
$d = mysqli_fetch_assoc($data);

if (!$d) {
  header("Location: data.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Inventaris</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand">Inventaris LAB</span>
    <a href="data.php" class="btn btn-secondary btn-sm">Kembali</a>
  </div>
</nav>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-7">

      <div class="card shadow-sm">
        <div class="card-header bg-warning">
          <h5 class="mb-0">Edit Data Inventaris</h5>
        </div>

        <div class="card-body">

          <form method="POST">

            <div class="mb-3">
              <label class="form-label">Kode Barang</label>
              <input 
                type="text" 
                name="kode" 
                class="form-control"
                value="<?= htmlspecialchars($d['kode_barang']) ?>" 
                required>
            </div>

            <div class="mb-3">
              <label class="form-label">Nama Barang</label>
              <input 
                type="text" 
                name="nama" 
                class="form-control"
                value="<?= htmlspecialchars($d['nama_barang']) ?>" 
                required>
            </div>

            <div class="mb-3">
              <label class="form-label">Jumlah</label>
              <input 
                type="number" 
                name="jumlah" 
                class="form-control"
                min="0"
                value="<?= $d['jumlah'] ?>" 
                required>
            </div>

            <div class="mb-3">
              <label class="form-label">Kondisi</label>
              <select name="kondisi" class="form-select" required>
                <option value="Baik" <?= $d['kondisi']=='Baik'?'selected':'' ?>>Baik</option>
                <option value="Rusak Ringan" <?= $d['kondisi']=='Rusak Ringan'?'selected':'' ?>>Rusak Ringan</option>
                <option value="Rusak Berat" <?= $d['kondisi']=='Rusak Berat'?'selected':'' ?>>Rusak Berat</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Lokasi</label>
              <input 
                type="text" 
                name="lokasi" 
                class="form-control"
                value="<?= htmlspecialchars($d['lokasi']) ?>">
            </div>

            <div class="mb-3">
              <label class="form-label">Keterangan</label>
              <textarea 
                name="keterangan" 
                class="form-control" 
                rows="3"><?= htmlspecialchars($d['keterangan']) ?></textarea>
            </div>

            <div class="d-flex justify-content-between">
              <button type="submit" name="update" class="btn btn-warning">
                💾 Update Data
              </button>
              <a href="data.php" class="btn btn-outline-secondary">
                Batal
              </a>
            </div>

          </form>

        </div>
      </div>

<?php
if (isset($_POST['update'])) {

  mysqli_query($conn, "
    UPDATE inventaris SET
      kode_barang='$_POST[kode]',
      nama_barang='$_POST[nama]',
      jumlah='$_POST[jumlah]',
      kondisi='$_POST[kondisi]',
      lokasi='$_POST[lokasi]',
      keterangan='$_POST[keterangan]'
    WHERE id='$id'
  ");

  echo '<div class="alert alert-success mt-3">
          ✅ Data inventaris berhasil diperbarui
        </div>';

  echo '<meta http-equiv="refresh" content="1;url=data.php">';
}
?>

    </div>
  </div>
</div>

</body>
</html>
