<?php
include 'koneksi.php';
$data = mysqli_query($koneksi,"SELECT * FROM pesanan ORDER BY tanggal DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Daftar Semua Pesanan</title>
<link rel="stylesheet" href="css/form.css">
</head>
<body>

<div class="pesanan-wrapper">
<h2>Daftar Semua Pesanan</h2>

<table class="pesanan-table">
<tr>
  <th>Paket</th>
  <th>Nama</th>
  <th>No HP</th>
  <th>Tanggal</th>
  <th>Hari</th>
  <th>Peserta</th>
  <th>Total</th>
</tr>

<?php if(mysqli_num_rows($data)==0): ?>
<tr>
  <td colspan="7">Belum ada pesanan</td>
</tr>
<?php endif; ?>

<?php while($d=mysqli_fetch_assoc($data)): ?>
<tr>
  <td><?= $d['paket'] ?></td>
  <td><?= $d['nama'] ?></td>
  <td><?= $d['hp'] ?></td>
  <td><?= $d['tanggal'] ?></td>
  <td><?= $d['hari'] ?></td>
  <td><?= $d['peserta'] ?></td>
  <td>Rp <?= number_format($d['total'],0,',','.') ?></td>
</tr>
<?php endwhile; ?>

</table>
</div>

</body>
</html>
