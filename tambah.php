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
| PROSES SIMPAN DATA
|--------------------------------------------------------------------------
*/

if (isset($_POST['simpan'])) {

    $kode       = mysqli_real_escape_string($conn, $_POST['kode']);
    $nama       = mysqli_real_escape_string($conn, $_POST['nama']);
    $jumlah     = (int) $_POST['jumlah'];
    $kondisi    = mysqli_real_escape_string($conn, $_POST['kondisi']);
    $lokasi     = mysqli_real_escape_string($conn, $_POST['lokasi']);
    $keterangan = mysqli_real_escape_string($conn, $_POST['keterangan']);

    $sql = "
        INSERT INTO inventaris
        (
            kode_barang,
            nama_barang,
            jumlah,
            kondisi,
            lokasi,
            keterangan
        )
        VALUES
        (
            '$kode',
            '$nama',
            '$jumlah',
            '$kondisi',
            '$lokasi',
            '$keterangan'
        )
    ";

    if (mysqli_query($conn, $sql)) {

        log_activity(
            "📦",
            "success",
            "Menambahkan barang: " . $nama,
            $_SESSION['nama']
        );

        header("Location: data.php?success=tambah");
        exit;

    } else {

        die(mysqli_error($conn));

    }
}

include 'layout/layout_start.php';
?>

<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        Tambah Data Inventaris
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
                                placeholder="Contoh: PC-LAB-01"
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
                                placeholder="Contoh: Komputer PC"
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

                                <option value="">
                                    -- Pilih Kondisi --
                                </option>

                                <option value="Baik">
                                    Baik
                                </option>

                                <option value="Rusak Ringan">
                                    Rusak Ringan
                                </option>

                                <option value="Rusak Berat">
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
                                placeholder="Catatan tambahan (opsional)"></textarea>

                        </div>

                        <div class="d-flex justify-content-between">

                            <button
                                type="submit"
                                name="simpan"
                                class="btn btn-primary">

                                💾 Simpan Data

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