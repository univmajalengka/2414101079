<?php
$paket_list = [
  "1 Day Trip Phinisi Boat" => 2700000,
  "2 Hari 1 Malam" => 3500000,
  "3 Hari 2 Malam" => 5500000,
  "Honeymoon Package" => 8000000
];
?>
<!DOCTYPE html>
<html>
<head>
<title>Form Pemesanan</title>
<link rel="stylesheet" href="css/form.css">
</head>
<body>

<form method="post" action="simpan_pesanan.php">
  <h2>Form Pemesanan Paket Wisata</h2>

  <label>Nama Paket</label>
  <select name="paket" id="paket" onchange="updateHarga()" required>
    <option value="">-- Pilih Paket --</option>
    <?php foreach($paket_list as $nama => $harga): ?>
      <option value="<?= $nama ?>" data-harga="<?= $harga ?>">
        <?= $nama ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label>Nama</label>
  <input type="text" name="nama" required>

  <label>No HP</label>
  <input type="text" name="hp" required>

  <label>Tanggal</label>
  <input type="date" name="tanggal" required>

  <label>Hari</label>
  <input type="number" name="hari" value="1" required oninput="updateHarga()">

  <label>Peserta</label>
  <input type="number" name="peserta" value="1" required oninput="updateHarga()">

  <label>Harga</label>
  <input type="text" id="harga" name="harga" readonly>

  <label>Total</label>
  <input type="text" id="total" name="total" readonly>

  <button type="submit">Pesan Sekarang</button>
</form>

<script>
function updateHarga(){
  const paket = document.getElementById("paket");
  if(paket.value==="") return;
  const harga = parseInt(paket.options[paket.selectedIndex].dataset.harga);
  const hari = parseInt(document.querySelector('[name="hari"]').value);
  const peserta = parseInt(document.querySelector('[name="peserta"]').value);
  document.getElementById("harga").value = harga;
  document.getElementById("total").value = harga * hari * peserta;
}
</script>

</body>
</html>
