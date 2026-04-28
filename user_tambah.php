<?php
session_start();
if (!isset($_SESSION['login'])) exit;
if($_SESSION['role']!='admin'){
  exit('Akses ditolak');
}

include 'config/koneksi.php';
include 'layout/layout_start.php';

if(isset($_POST['simpan'])){

  $u = $_POST['username'];
  $p = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $r = $_POST['role'];

  mysqli_query($conn,"
    INSERT INTO users(username,password,role)
    VALUES('$u','$p','$r')
  ");

  echo "<meta http-equiv='refresh' content='0;url=users.php'>";
}
?>

<h4>Tambah User</h4>

<div class="card shadow-sm">
<div class="card-body">

<form method="POST">

<label>Username</label>
<input name="username" class="form-control mb-2" required>

<label>Password</label>
<input type="password" name="password" class="form-control mb-2" required>

<label>Role</label>
<select name="role" class="form-select mb-3">
<option value="admin">Admin</option>
<option value="petugas">Petugas</option>
</select>

<button class="btn btn-success" name="simpan">
💾 Simpan
</button>

</form>

</div>
</div>

<?php include 'layout/layout_end.php'; ?>
