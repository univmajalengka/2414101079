<?php
session_start();
// Pastikan semua input dikirim
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['add_to_cart'])) {
    header("Location: ../shop.php"); // Redirect ke shop.php
    exit();
}

$cake_id = (int)$_POST['cake_id'];
$quantity = (int)$_POST['quantity'];
$price = (float)$_POST['price'];

// Memanggil kembali data kue untuk mendapatkan nama dan path gambar
require_once __DIR__ . '/../../backend/cakes.php';
$cake = getCakeById($cake_id);

if (!$cake || $quantity <= 0 || $quantity > $cake['stock']) {
    $_SESSION['message'] = "Kuantitas atau ID kue tidak valid!";
    $_SESSION['message_type'] = "danger";
    header("Location: ../shop.php");
    exit();
}

// Inisialisasi keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Tambahkan atau perbarui item di keranjang
if (array_key_exists($cake_id, $_SESSION['cart'])) {
    // Jika kue sudah ada, tambahkan kuantitasnya
    $_SESSION['cart'][$cake_id]['quantity'] += $quantity;
    
    // Pastikan total kuantitas tidak melebihi stok
    if ($_SESSION['cart'][$cake_id]['quantity'] > $cake['stock']) {
        $_SESSION['cart'][$cake_id]['quantity'] = $cake['stock']; 
        $_SESSION['message'] = "Kuantitas **{$cake['name']}** disesuaikan ke stok maksimum ({$cake['stock']}).";
        $_SESSION['message_type'] = "warning";
    } else {
        $_SESSION['message'] = "Kuantitas **{$cake['name']}** berhasil diperbarui di keranjang.";
        $_SESSION['message_type'] = "success";
    }

} else {
    // Jika kue belum ada, tambahkan item baru
    $_SESSION['cart'][$cake_id] = [
        'cake_id' => $cake_id,
        'name' => $cake['name'],
        'price' => $price,
        'image_path' => $cake['image_path'],
        'quantity' => $quantity
    ];
    $_SESSION['message'] = "**{$cake['name']}** berhasil ditambahkan ke keranjang.";
    $_SESSION['message_type'] = "success";
}

header("Location: ../shop.php");
exit();
?>