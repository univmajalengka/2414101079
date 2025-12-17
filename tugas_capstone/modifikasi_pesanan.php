<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html>
<head>
<title>Daftar Pesanan</title>
<link rel="stylesheet" href="css/form.css">
<style>
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
th, td {
  padding: 12px;
  border-bottom: 1px solid #ddd;
  text-align: center;
}
th {
  background: #0a5cff;
  color: white;
}
a.action {
  margin: 0 5px;
  text-decoration: none;
  color: #0a5cff;
  font-weight: 500;
}
</style>
</head>
<body>

<h2>Daftar Pesanan</h2>

<table>
<tr>
  <th>Paket</th>
  <th>Nama</th>
  <th>Hari</th>
  <th>Peserta</th>
  <th>Total</th>
  <th>Aksi</th>
</tr>

<?php
$data = mysqli_query($koneksi,"SELECT * FROM pesanan");
while($d=mysqli_fetch_array($data)){
?>
<tr>
  <td><?= $d['paket'] ?></td>
  <td><?= $d['nama'] ?></td>
  <td><?= $d['hari'] ?></td>
  <td><?= $d['peserta'] ?></td>
  <td>Rp <?= number_format($d['total'],0,',','.') ?></td>
  <td>
    <a class="action" href="edit_pesanan.php?id=<?= $d['id'] ?>">Edit</a>
    <a class="action" href="hapus_pesanan.php?id=<?= $d['id'] ?>"
       onclick="return confirm('Hapus pesanan?')">Hapus</a>
  </td>
</tr>
<?php } ?>
</table>

</body>
</html>
