<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? 'user';
$uri  = basename($_SERVER['PHP_SELF']);
?>

<div class="sidebar" id="sidebar">

  <h5 class="logo-text">Inventaris LAB</h5>

  <!-- DASHBOARD -->
  <a href="dashboard.php" class="<?= $uri=='dashboard.php' ? 'active' : '' ?>">
    🏠 <span class="menu-text">Dashboard</span>
  </a>

  <!-- INVENTARIS -->
  <a class="menu-toggle d-flex justify-content-between align-items-center"
     data-bs-toggle="collapse"
     href="#menuInventaris"
     role="button"
     aria-expanded="<?= in_array($uri,['data.php','tambah.php','peminjaman.php']) ? 'true':'false' ?>">

    <span>📦 <span class="menu-text">Inventaris</span></span>
    <span class="arrow">▾</span>
  </a>

  <div id="menuInventaris"
       class="collapse <?= in_array($uri,['data.php','tambah.php','peminjaman.php']) ? 'show':'' ?>">

    <a href="data.php" class="<?= $uri=='data.php' ? 'active' : '' ?>">
      📋 <span class="menu-text">Data</span>
    </a>

    <?php if($role == 'admin'){ ?>
    <a href="tambah.php" class="<?= $uri=='tambah.php' ? 'active' : '' ?>">
      ➕ <span class="menu-text">Tambah</span>
    </a>
    <?php } ?>

    <a href="peminjaman.php" class="<?= $uri=='peminjaman.php' ? 'active' : '' ?>">
      🔄 <span class="menu-text">Peminjaman</span>
    </a>

  </div>

  <!-- PENGAJUAN LAB -->
  <a href="pengajuan_lab.php" class="<?= $uri=='pengajuan_lab.php' ? 'active' : '' ?>">
    🧪 <span class="menu-text">Pengajuan LAB</span>
  </a>

  <!-- MANAJEMEN USER -->
  <?php if($role == 'admin'){ ?>
  <a href="users.php" class="<?= $uri=='users.php' ? 'active' : '' ?>">
    👥 <span class="menu-text">Manajemen User</span>
  </a>
  <?php } ?>

  <!-- LOGOUT -->
  <a href="#"
  class="nav-link text-danger"
  onclick="confirmLogout('logout.php'); return false;">

  🚪 Logout

  </a>

</div>