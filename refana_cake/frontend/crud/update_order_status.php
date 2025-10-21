<?php
session_start();
require_once dirname(__DIR__, 2) . '/backend/cakes.php'; 

if (!isset($_SESSION['admin_logged_in']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['update_order_status'])) {
    header("Location: ../admin_login.php");
    exit();
}

$order_id = (int)$_POST['order_id'];
$new_status = $_POST['new_status'];

$success = updateOrderStatus($order_id, $new_status);

if ($success) {
    $_SESSION['message'] = "Status Pesanan **#$order_id** berhasil diubah menjadi **$new_status**.";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Gagal mengubah status pesanan. Error: " . (isset($conn) ? $conn->error : "Koneksi database gagal.");
    $_SESSION['message_type'] = "danger";
}

header("Location: ../admin_dashboard.php");
exit();
?>