<?php
include 'koneksi.php';

$penginapan = isset($_POST['penginapan']) ? 1 : 0;
$transportasi = isset($_POST['transportasi']) ? 1 : 0;
$makanan = isset($_POST['makanan']) ? 1 : 0;

mysqli_query($conn,"INSERT INTO pesanan VALUES(
NULL,
'$_POST[paket]',
'$_POST[nama]',
'$_POST[hp]',
'$_POST[tanggal]',
'$_POST[hari]',
'$_POST[peserta]',
$penginapan,
$transportasi,
$makanan,
'$_POST[harga_paket]',
'$_POST[total]'
)");

header("Location: modifikasi_pesanan.php");
?>
