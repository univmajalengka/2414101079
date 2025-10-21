<?php
session_start();
include '../../backend/cakes.php';

if (!isset($_SESSION['admin_logged_in']) || !isset($_GET['id'])) {
    header("Location: ../admin_dashboard.php");
    exit();
}

$id = (int)$_GET['id'];

if ($id > 0) {
    $success = deleteCake($id);

    if ($success) {
        $_SESSION['message'] = "Kue berhasil dihapus.";
        $_SESSION['message_type'] = "success";
    } else {
        $conn = $GLOBALS['conn'];
        $_SESSION['message'] = "Gagal menghapus kue: " . ($conn->error ?? "Error tidak diketahui.");
        $_SESSION['message_type'] = "danger";
    }
} else {
    $_SESSION['message'] = "ID Kue tidak valid.";
    $_SESSION['message_type'] = "danger";
}

header("Location: ../admin_dashboard.php");
exit();
?>