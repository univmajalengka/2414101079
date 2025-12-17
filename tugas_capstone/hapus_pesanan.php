<?php
include 'koneksi.php';
$id = $_GET['id'];
$hp = $_GET['hp'];

mysqli_query($koneksi,"DELETE FROM pesanan WHERE id='$id'");
header("Location: pesanan_saya.php?hp=$hp");
