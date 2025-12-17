<?php
include 'koneksi.php';

$paket   = $_POST['paket'];
$nama    = $_POST['nama'];
$hp      = $_POST['hp'];
$tanggal = $_POST['tanggal'];
$hari    = $_POST['hari'];
$peserta = $_POST['peserta'];
$harga   = $_POST['harga'];
$total   = $_POST['total'];

mysqli_query($koneksi,"INSERT INTO pesanan 
(paket,nama,hp,tanggal,hari,peserta,harga,total)
VALUES
('$paket','$nama','$hp','$tanggal','$hari','$peserta','$harga','$total')");

header("Location: pesanan_saya.php?hp=$hp");
