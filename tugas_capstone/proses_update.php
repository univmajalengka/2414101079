<?php
include 'koneksi.php';

$id      = $_POST['id'];
$hp_lama = $_POST['hp_lama'];
$hp      = $_POST['hp'];
$paket   = $_POST['paket'];
$nama    = $_POST['nama'];
$tanggal = $_POST['tanggal'];
$hari    = $_POST['hari'];
$peserta = $_POST['peserta'];
$harga   = $_POST['harga'];
$total   = $_POST['total'];

mysqli_query($koneksi,"UPDATE pesanan SET
paket='$paket',
nama='$nama',
hp='$hp',
tanggal='$tanggal',
hari='$hari',
peserta='$peserta',
harga='$harga',
total='$total'
WHERE id='$id'");

header("Location: pesanan_saya.php?hp=$hp");
