<?php
session_start();
require_once 'config.php';
require_once 'cakes.php'; 

if (!isset($_SESSION['customer_logged_in']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../frontend/login.php");
    exit();
}

if (isset($_POST['submit_review'])) {
    $customer_id = $_SESSION['customer_id'];
    $cake_id = (int)$_POST['cake_id'];
    $order_id = (int)$_POST['order_id'];
    $rating = (int)$_POST['rating'];
    $comment = $_POST['comment'];
    
    if ($rating < 1 || $rating > 5) {
        $_SESSION['message'] = "Peringkat harus antara 1 sampai 5.";
        $_SESSION['message_type'] = "danger";
        header("Location: ../frontend/order_history.php");
        exit();
    }
    
    if (addReview($customer_id, $cake_id, $order_id, $rating, $comment)) {
        $_SESSION['message'] = "Terima kasih! Ulasan Anda berhasil dikirim.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal mengirim ulasan, atau Anda sudah mengulas produk ini.";
        $_SESSION['message_type'] = "danger";
    }

    header("Location: ../frontend/order_history.php");
    exit();
}
header("Location: ../frontend/order_history.php");
exit();
?>