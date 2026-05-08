<?php
session_start();
include 'config/koneksi.php';

if (isset($_POST['login'])) {

  $username = trim($_POST['username']);
  $password = $_POST['password'];

  $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username=?");
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);

  $result = mysqli_stmt_get_result($stmt);
  $data = mysqli_fetch_assoc($result);

  if ($data && password_verify($password, $data['password'])) {

    session_regenerate_id(true);

    $_SESSION['login'] = true;
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    header("Location: dashboard.php");
    exit;

  } else {
    $error = "Username atau password salah";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login | Inventaris LAB</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #198754, #0d6efd);
      min-height: 100vh;
    }
  </style>
</head>

<body class="d-flex align-items-center justify-content-center">

<div class="col-md-4">

  <div class="text-center mb-4 text-white">
    <img 
      src="assets/img/logo.png" 
      alt="Logo Sekolah"
      style="height:90px;"
      class="mb-2"
    >
    <h4 class="fw-bold mb-0">SMK UNGGULAN NU MOJOAGUNG</h4>
    <small>Sistem Inventaris LAB TKJ</small>
  </div>

  <div class="card shadow-lg">
    <div class="card-body p-4">

      <h5 class="text-center mb-3">Login Sistem</h5>

      <?php if (isset($error)) { ?>
        <div class="alert alert-danger text-center">
          <?= $error ?>
        </div>
      <?php } ?>

      <form method="POST">

        <div class="mb-3">
          <label class="form-label">Username</label>
          <input 
            type="text" 
            name="username" 
            class="form-control"
            placeholder="Masukkan username"
            required>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <input 
            type="password" 
            name="password" 
            class="form-control"
            placeholder="Masukkan password"
            required>
        </div>

        <button 
          type="submit" 
          name="login" 
          class="btn btn-success w-100">
          🔐 Login
        </button>

      </form>

    </div>
  </div>

  <div class="text-center text-white mt-3">
    <small>
      © <?= date('Y') ?> SMK Unggulan NU Mojoagung
    </small>
  </div>

</div>

</body>
</html>
