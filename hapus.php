<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    exit("Akses ditolak");
}

include 'config/koneksi.php';
require_once 'helpers/activity_helper.php';

/*
|--------------------------------------------------------------------------
| Validasi ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    header("Location: data.php?status=error&message=ID barang tidak valid");
    exit;
}

$id = (int)$_GET['id'];

/*
|--------------------------------------------------------------------------
| Ambil data barang
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare($conn, "
    SELECT nama_barang
    FROM inventaris
    WHERE id=?
");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {

    header("Location: data.php?status=error&message=Barang tidak ditemukan");
    exit;
}

$barang = mysqli_fetch_assoc($result);

/*
|--------------------------------------------------------------------------
| Hapus barang
|--------------------------------------------------------------------------
*/

$stmt = mysqli_prepare($conn, "
    DELETE FROM inventaris
    WHERE id=?
");

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {

    // Simpan activity log
    log_activity(
        "🗑️",
        "danger",
        "Menghapus barang: " . $barang['nama_barang'],
        $_SESSION['nama']
    );

    header("Location: data.php?status=success&message=Barang berhasil dihapus");
    exit;

} else {

    header("Location: data.php?status=error&message=Gagal menghapus barang");
    exit;
}