<?php
$username = $_SESSION['username'] ?? 'User';

/* =========================
   ANTI ERROR NOTIF
========================= */
$notifCount = $notifCount ?? 0;
$qNotif = $qNotif ?? null;
?>

<div class="topbar d-flex justify-content-between align-items-center flex-wrap">

  <!-- LEFT -->
  <div class="d-flex align-items-center gap-2">

    <!-- TOGGLE -->
    <span class="toggle-btn d-md-none" onclick="toggleSidebarMobile()">☰</span>
    <span class="toggle-btn d-none d-md-inline" onclick="toggleSidebarDesktop()">☰</span>

    <!-- LOGO -->
    <img src="assets/img/logo.png" style="height:40px;">

    <!-- TITLE -->
    <div class="topbar-text">
      <div class="fw-bold">SMK NU MOJOAGUNG</div>
      <small class="text-muted">Inventaris LAB</small>
    </div>

  </div>

  <!-- RIGHT -->
  <div class="d-flex align-items-center gap-3">

    <!-- JAM -->
    <span id="clock" class="text-muted small"></span>

    <!-- NOTIF -->
    <div class="dropdown me-2">

      <button class="btn btn-light position-relative" data-bs-toggle="dropdown">
        🔔

        <?php if($notifCount > 0){ ?>
        <span class="badge bg-danger notif-badge">
          <?= $notifCount ?>
        </span>
        <?php } ?>
      </button>

      <ul class="dropdown-menu dropdown-menu-end shadow p-0" style="width:320px; max-height:300px; overflow:auto;">

        <li class="dropdown-header fw-bold d-flex justify-content-between">
          Notifikasi
          <?php if($notifCount > 0){ ?>
          <small class="text-primary" style="cursor:pointer"
            onclick="window.location='pengajuan_lab.php'">
            Lihat Semua
          </small>
          <?php } ?>
        </li>

        <?php if($notifCount > 0 && $qNotif){ ?>

          <?php while($n = mysqli_fetch_assoc($qNotif)){ ?>
          <li>
            <a class="dropdown-item small border-bottom" href="pengajuan_lab.php">

              <div class="fw-semibold">
                <?= htmlspecialchars($n['pemohon']) ?>
              </div>

              <div class="text-muted small">
                <?= htmlspecialchars($n['kelas']) ?>
              </div>

              <div class="small text-secondary">
                🕒 <?= $n['jam_mulai'] ?> - <?= $n['jam_selesai'] ?>
              </div>

            </a>
          </li>
          <?php } ?>

        <?php } else { ?>

          <li>
            <div class="text-center text-muted py-3">
              🔕 Tidak ada notifikasi
            </div>
          </li>

        <?php } ?>

      </ul>

    </div>

    <!-- USER -->
    <div class="dropdown">
      <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2" data-bs-toggle="dropdown">
        <span>👤</span>
        <span><?= htmlspecialchars($username) ?></span>
      </button>

      <ul class="dropdown-menu dropdown-menu-end shadow">
        <li><a class="dropdown-item" href="#">Profil</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
      </ul>
    </div>

  </div>

</div>