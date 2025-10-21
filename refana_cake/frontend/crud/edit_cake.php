<?php
session_start();
include '../../backend/cakes.php';

if (!isset($_SESSION['admin_logged_in']) || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['submit_cake']) || $_POST['mode'] != 'edit') {
    header("Location: ../admin_login.php");
    exit();
}

$cake_id = (int)$_POST['cake_id'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$image_path = $_POST['image_path'] ?? 'assets/images/default.jpg';
    
$success = updateCake($cake_id, $name, $description, $price, $image_path, $stock);

if ($success) {
    $_SESSION['message'] = "Kue berhasil diperbarui!";
    $_SESSION['message_type'] = "success";
} else {
    $conn = $GLOBALS['conn']; 
    $_SESSION['message'] = "Gagal memperbarui kue: " . ($conn->error ?? "Error tidak diketahui.");
    $_SESSION['message_type'] = "danger";
}

header("Location: ../admin_dashboard.php");
exit();
?>