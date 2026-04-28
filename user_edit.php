<?php
session_start();
if (!isset($_SESSION['login'])) exit;
if($_SESSION['role']!='admin'){
  exit('Akses ditolak');
}

include 'config/koneksi.php';
include 'layout/layout_start.php';

$id = $_GET['id'] ?? 0;
$q  = mysqli_query($conn,"SELECT * FROM users WHERE id='$id'");
$u  = mysqli_fetch_assoc($q);

if(!$u){
  echo "User tidak ditemukan";
  include 'layout/layout_end.php';
  exit;
}

if(isset($_POST['simpan'])){

  $username = $_POST['username'];
  $role     = $_POST['role'];
  $pass     = $_POST['password'];

  // update basic
  mysqli_query($conn,"
    UPDATE users 
    SET username='$username', role='$role'
    WHERE id='$id'
  ");

  // jika password diisi → reset
  if($pass != ''){
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    mysqli_query($conn,"
      UPDATE users SET password='$hash'
      WHERE id='$id'
    ");
  }

  echo "<meta http-equiv='refresh' content='0;url=users.php'>";
}
?>

<h4>Edit User</h4>

<div class="card shadow-sm">
<div class="card-body">

<form method="POST">

<label>Username</label>
<input name="username"
       value="<?= htmlspecialchars($u['username']) ?>"
       class="form-control mb-3" required>

<label>Password Baru</label>
<input type="password"
       name="password"
       class="form-control mb-1">

<small class="text-muted">
Kosongkan jika tidak ingin mengganti password
</small>

<label class="mt-3">Role</label>
<select name="role" class="form-select mb-3">
<option value="admin" <?= $u['role']=='admin'?'selected':'' ?>>
Admin
</option>
<option value="petugas" <?= $u['role']=='petugas'?'selected':'' ?>>
Petugas
</option>
</select>

<button class="btn btn-success" name="simpan">
💾 Update User
</button>

<a href="users.php" class="btn btn-secondary">
Batal
</a>

</form>

</div>
</div>

<?php include 'layout/layout_end.php'; ?>
