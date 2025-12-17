<?php
include 'koneksi.php';
$hp = $_GET['hp'];
$data = mysqli_query($koneksi,"SELECT * FROM pesanan WHERE hp='$hp'");
?>
<!DOCTYPE html>
<html>
<head>
<title>Pesanan Saya</title>
<link rel="stylesheet" href="css/form.css">
</head>
<body>

<div class="pesanan-wrapper">
<h2>Pesanan Saya</h2>

<table class="pesanan-table">
<tr>
  <th>Paket</th>
  <th>Nama</th>
  <th>Tanggal</th>
  <th>Hari</th>
  <th>Peserta</th>
  <th>Total</th>
  <th>Aksi</th>
</tr>

<?php if(mysqli_num_rows($data)==0): ?>
<tr>
  <td colspan="7">Tidak ada pesanan</td>
</tr>
<?php endif; ?>

<?php while($d=mysqli_fetch_assoc($data)): ?>
<tr>
  <td><?= $d['paket'] ?></td>
  <td><?= $d['nama'] ?></td>
  <td><?= $d['tanggal'] ?></td>
  <td><?= $d['hari'] ?></td>
  <td><?= $d['peserta'] ?></td>
  <td>Rp <?= number_format($d['total'],0,',','.') ?></td>
  <td class="aksi">
    <a class="edit" href="edit_pesanan.php?id=<?= $d['id'] ?>&hp=<?= $hp ?>">Edit</a>
    <a class="hapus" href="hapus_pesanan.php?id=<?= $d['id'] ?>&hp=<?= $hp ?>" onclick="return confirm('Hapus pesanan?')">Hapus</a>
  </td>
</tr>
<?php endwhile; ?>

</table>
</div>

</body>
</html>
