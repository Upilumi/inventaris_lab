<?php

session_start();

if (!isset($_SESSION['login'])) {

    header("Location: login.php");
    exit;

}
include 'config/koneksi.php';
require_once 'helpers/activity_helper.php';

/*
|--------------------------------------------------------------------------
| VALIDASI ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id'])) {

    header("Location: data.php");
    exit;

}

$id = (int) $_GET['id'];

/*
|--------------------------------------------------------------------------
| AMBIL DATA BARANG
|--------------------------------------------------------------------------
*/

$query = mysqli_query(

    $conn,

    "SELECT * FROM inventaris WHERE id='$id'"

);

$barang = mysqli_fetch_assoc($query);

if (!$barang) {

    header("Location: data.php");
    exit;

}

if (isset($_POST['update'])) {

$kode       = mysqli_real_escape_string($conn, $_POST['kode']);
$nama       = mysqli_real_escape_string($conn, $_POST['nama']);
$jumlah     = (int) $_POST['jumlah'];
$kondisi    = mysqli_real_escape_string($conn, $_POST['kondisi']);
$lokasi     = mysqli_real_escape_string($conn, $_POST['lokasi']);
$keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

$sql = "
UPDATE inventaris
SET
kode_barang = '$kode',
nama_barang = '$nama',
jumlah = '$jumlah',
kondisi = '$kondisi',
lokasi = '$lokasi',
keterangan = '$keterangan'
WHERE id = '$id'
";

if(mysqli_query($conn,$sql)){

log_activity(
"✏️",
"warning",
"Mengubah barang: ".$nama,
$_SESSION['nama']
);

header("Location: data.php?status=success&message=Barang berhasil diperbarui");
exit;

}else{

header("Location: data.php?status=error&message=Gagal memperbarui barang");
exit;

}

}

include 'layout/layout_start.php';
?>

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow">

                <div class="card-header bg-warning text-dark">

                    <h5 class="mb-0">
                        ✏️ Edit Data Inventaris
                    </h5>

                </div>

                <div class="card-body">

                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Kode Barang
                            </label>

                            <input
                                type="text"
                                name="kode"
                                class="form-control"
                                value="<?= htmlspecialchars($barang['kode_barang']) ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Nama Barang
                            </label>

                            <input
                                type="text"
                                name="nama"
                                class="form-control"
                                value="<?= htmlspecialchars($barang['nama_barang']) ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Jumlah
                            </label>

                            <input
                                type="number"
                                name="jumlah"
                                class="form-control"
                                min="1"
                                value="<?= $barang['jumlah'] ?>"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Kondisi
                            </label>

                            <select
                                name="kondisi"
                                class="form-select"
                                required>

                                <option value="Baik"
                                    <?= ($barang['kondisi'] == 'Baik') ? 'selected' : '' ?>>
                                    Baik
                                </option>

                                <option value="Rusak Ringan"
                                    <?= ($barang['kondisi'] == 'Rusak Ringan') ? 'selected' : '' ?>>
                                    Rusak Ringan
                                </option>

                                <option value="Rusak Berat"
                                    <?= ($barang['kondisi'] == 'Rusak Berat') ? 'selected' : '' ?>>
                                    Rusak Berat
                                </option>

                            </select>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Lokasi
                            </label>

                            <input
                                type="text"
                                name="lokasi"
                                class="form-control"
                                value="<?= htmlspecialchars($barang['lokasi']) ?>"
                                placeholder="Contoh: LAB Komputer 1 / Meja 05">

                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Keterangan
                            </label>

                            <textarea
                                name="keterangan"
                                rows="3"
                                class="form-control"
                                placeholder="Catatan tambahan (opsional)"><?= htmlspecialchars($barang['keterangan']) ?></textarea>

                        </div>

                        <div class="d-flex justify-content-between">

                            <button
                                type="submit"
                                name="update"
                                class="btn btn-warning">

                                ✏️ Update Data

                            </button>

                            <a
                                href="data.php"
                                class="btn btn-secondary">

                                Batal

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'layout/layout_end.php'; ?>
