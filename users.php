
<?php
session_start();
if (!isset($_SESSION['login'])) exit;
if($_SESSION['role']!='admin'){
  exit('Akses ditolak');
}

include 'config/koneksi.php';
include 'layout/layout_start.php';

$data = mysqli_query($conn, "SELECT * FROM users ORDER BY id DESC");
?>

<h4 class="mb-3">Manajemen User</h4>

<div class="card shadow-sm">
<div class="card-body">

<a href="user_tambah.php" class="btn btn-success mb-3">
➕ Tambah User
</a>

<table class="table table-bordered">
<thead>
<tr>
<th>ID</th>
<th>Username</th>
<th>Role</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>
<?php while($u = mysqli_fetch_assoc($data)) { ?>
<tr>
<td><?= $u['id'] ?></td>
<td><?= $u['username'] ?></td>
<td>
<span class="badge bg-primary"><?= $u['role'] ?></span>
</td>
<td>

<a href="user_edit.php?id=<?= $u['id'] ?>"
   class="btn btn-warning btn-sm">
✏️
</a>

<a href="user_hapus.php?id=<?= $u['id'] ?>"
   class="btn btn-danger btn-sm"
   onclick="return confirm('Hapus user?')">
🗑️
</a>

</td>

</tr>
<?php } ?>
</tbody>
</table>

</div>
</div>

<?php include 'layout/layout_end.php'; ?>
