<?php
session_start();
require_once '../../backend/cakes.php'; 

if (!isset($_SESSION['cart'])) {
    header("Location: ../cart.php");
    exit();
}

$cart = &$_SESSION['cart'];

if (isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $cake_id = (int)$_GET['id'];
    if (array_key_exists($cake_id, $cart)) {
        $removed_name = $cart[$cake_id]['name'];
        unset($cart[$cake_id]);
        $_SESSION['message'] = "**$removed_name** berhasil dihapus dari keranjang.";
        $_SESSION['message_type'] = "success";
    }
    header("Location: ../cart.php");
    exit();
}

if (isset($_POST['update_cart'])) {
    $cake_id = (int)$_POST['cake_id'];
    $new_quantity = (int)$_POST['quantity'];

    if (array_key_exists($cake_id, $cart) && $new_quantity > 0) {
        $cake = getCakeById($cake_id);
        
        if ($new_quantity > $cake['stock']) {
            $new_quantity = $cake['stock'];
            $_SESSION['message'] = "Kuantitas **{$cart[$cake_id]['name']}** disesuaikan ke stok maksimum ({$cake['stock']}).";
            $_SESSION['message_type'] = "warning";
        } else {
            $_SESSION['message'] = "Kuantitas **{$cart[$cake_id]['name']}** berhasil diperbarui menjadi $new_quantity.";
            $_SESSION['message_type'] = "success";
        }
        
        $cart[$cake_id]['quantity'] = $new_quantity;
    } else {
        $_SESSION['message'] = "Item tidak valid atau kuantitas 0.";
        $_SESSION['message_type'] = "danger";
    }

    header("Location: ../cart.php");
    exit();
}

header("Location: ../cart.php");
exit();
?>