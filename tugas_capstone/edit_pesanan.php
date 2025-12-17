<?php
include 'koneksi.php';
$id = $_GET['id'];
$hp = $_GET['hp'];

$paket_list = [
  "1 Day Trip Phinisi Boat" => 2700000,
  "2 Hari 1 Malam" => 3500000,
  "3 Hari 2 Malam" => 5500000,
  "Honeymoon Package" => 8000000
];

$data = mysqli_query($koneksi,"SELECT * FROM pesanan WHERE id='$id'");
$d = mysqli_fetch_assoc($data);
?>
<!DOCTYPE html>
<html>
<head>
<title>Edit Pesanan</title>
<link rel="stylesheet" href="css/form.css">
</head>
<body>

<form method="post" action="proses_update.php">
  <h2>Edit Pesanan</h2>

  <input type="hidden" name="id" value="<?= $d['id'] ?>">
  <input type="hidden" name="hp_lama" value="<?= $d['hp'] ?>">

  <label>Nama Paket</label>
  <select name="paket" id="paket" onchange="updateTotal()" required>
    <?php foreach($paket_list as $nama => $harga): ?>
      <option value="<?= $nama ?>" data-harga="<?= $harga ?>" <?= $d['paket']==$nama?'selected':'' ?>>
        <?= $nama ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label>Nama</label>
  <input type="text" name="nama" value="<?= $d['nama'] ?>" required>

  <label>No HP</label>
  <input type="text" name="hp" value="<?= $d['hp'] ?>" required>

  <label>Tanggal</label>
  <input type="date" name="tanggal" value="<?= $d['tanggal'] ?>" required>

  <label>Hari</label>
  <input type="number" name="hari" id="hari" value="<?= $d['hari'] ?>" required oninput="updateTotal()">

  <label>Peserta</label>
  <input type="number" name="peserta" id="peserta" value="<?= $d['peserta'] ?>" required oninput="updateTotal()">

  <label>Harga</label>
  <input type="text" name="harga" id="harga" value="<?= $d['harga'] ?>" readonly>

  <label>Total</label>
  <input type="text" name="total" id="total" value="<?= $d['total'] ?>" readonly>

  <button type="submit">Update</button>
</form>

<script>
function updateTotal(){
  const paket = document.getElementById("paket");
  const harga = parseInt(paket.options[paket.selectedIndex].dataset.harga);
  const hari = parseInt(document.getElementById("hari").value);
  const peserta = parseInt(document.getElementById("peserta").value);

  document.getElementById("harga").value = harga;
  document.getElementById("total").value = harga * hari * peserta;
}
</script>

</body>
</html>
