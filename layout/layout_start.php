<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/* =========================
   NOTIF GLOBAL
========================= */
$qNotif = mysqli_query($conn, "
  SELECT * FROM pengajuan_lab 
  WHERE dibaca='0'
  ORDER BY id DESC
  LIMIT 5
");

$notifCount = mysqli_num_rows($qNotif);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
  <title>Inventaris LAB</title>
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
</head>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

/* =========================
   COLOR THEME
========================= */
:root {
  --hijau: #198754;
  --hijau-tua: #0c4a2d;
  --hover: #14532d;
  --emas: #ffc107;
  --bg: #f3f6f4;
}

/* =========================
   GLOBAL
========================= */
body {
  background: var(--bg);
  font-family: 'Segoe UI', sans-serif;
}

/* =========================
   WRAPPER
========================= */
.wrapper {
  display: flex;
  min-height: 100vh;
}

/* =========================
   SIDEBAR
========================= */
.sidebar {
  width: 250px;
  background: var(--hijau-tua);
  transition: 0.3s;
}

.sidebar.mini {
  width: 70px;
}

/* Logo */
.logo-text {
  color: white;
  padding: 15px;
  text-align: center;
  font-weight: bold;
}

/* Menu */
.sidebar a {
  display: block;
  color: #adb5bd;
  padding: 12px 20px;
  text-decoration: none;
  border-radius: 8px;
  margin: 5px 10px;
  transition: 0.2s;
}

.sidebar a:hover {
  background: var(--hover);
  color: white;
}

.sidebar a.active {
  background: var(--hijau);
  color: white;
  border-left: 4px solid var(--emas);
}

/* Mini mode */
.sidebar.mini .menu-text,
.sidebar.mini .logo-text {
  display: none;
}

/* =========================
   CONTENT
========================= */
.content {
  flex: 1;
  padding: 20px;
}

/* =========================
   TOPBAR
========================= */
.topbar {
  background: white;
  padding: 10px 20px;
  border-left: 6px solid var(--hijau);
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-radius: 12px;
  margin-bottom: 20px;
  box-shadow: 0 3px 10px rgba(0,0,0,0.08);

  position: sticky;
  top: 0;
  z-index: 10;
}

.toggle-btn {
  font-size: 22px;
  cursor: pointer;
}

/* =========================
   CARD
========================= */
.card {
  border: none;
  border-radius: 14px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.05);
  transition: 0.3s;
}

.card:hover {
  transform: translateY(-5px);
}

/* =========================
   BUTTON
========================= */
.btn-success,
.btn-primary {
  background: var(--hijau);
  border: none;
}

.btn-success:hover,
.btn-primary:hover {
  background: var(--hover);
}

/* =========================
   NOTIF
========================= */
.badge {
  position: relative;
  font-size: 10px;
  padding: 6px 10px;
  border-radius: 8px;
}

.notif-badge {
  position: absolute;
  top: -5px;
  right: -10px;
}

/* =========================
   DROPDOWN
========================= */
.dropdown-menu {
  border-radius: 12px;
}

.dropdown-item:hover {
  background: #f1f5f3;
  transform: translateX(3px);
  transition: 0.2s;
}

/* =========================
   OVERLAY
========================= */
#overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.3);
  display: none;
  z-index: 998;
}

#overlay.show {
  display: block;
}

/* =========================
   MOBILE
========================= */
@media (max-width: 768px){

  .content {
    margin-left: 0 !important;
    padding: 10px !important;
  }

  .sidebar {
    position: fixed;
    left: -250px;
    top: 0;
    height: 100%;
    z-index: 999;
    transition: 0.3s;
  }

  .sidebar.show {
    left: 0;
  }

}

</style>

</head>

<body
data-status="<?= $_GET['status'] ?? '' ?>"
data-message="<?= $_GET['message'] ?? '' ?>">

<div id="overlay" onclick="toggleSidebarMobile()"></div>

<div class="wrapper">

<!-- SIDEBAR -->
<?php include __DIR__.'/sidebar.php'; ?>

<!-- CONTENT -->
<div class="content">

<!-- TOPBAR -->
<?php include __DIR__.'/topbar.php'; ?>