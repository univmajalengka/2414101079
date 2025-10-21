<?php
session_start();
$order_id = (int)$_GET['id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Berhasil | Refana Cake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <style>
        body { background-color: #fff8f0; color: #5d3a1a; }
        .navbar { background-color: #6f4e37; }
        .navbar-brand { font-family: 'Cookie', cursive; font-size: 2.5rem; color: white !important; }
        .success-box { background-color: white; padding: 50px; border-radius: 10px; box-shadow: 0 0 15px rgba(0,0,0,0.1); }
        .btn-primary-custom { background-color: #6f4e37; border-color: #6f4e37; color: white; }
        .btn-primary-custom:hover { background-color: #5d3a1a; border-color: #5d3a1a; }
        .icon-success { font-size: 4rem; color: #4CAF50; margin-bottom: 20px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">Refana Cake</a>
    </div>
</nav>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="success-box text-center">
                <div class="icon-success">
                    &#10003;
                </div>
                
                <?php 
                if (isset($_SESSION['message'])) {
                    $alert_class = ($_SESSION['message_type'] === 'success') ? 'alert-success' : 'alert-danger';
                    echo '<div class="alert ' . $alert_class . ' my-3" role="alert">' . $_SESSION['message'] . '</div>';
                    unset($_SESSION['message']); 
                    unset($_SESSION['message_type']);
                }
                ?>
                
                <h1 style="color: #6f4e37;">Pesanan Berhasil!</h1>
                <p class="lead">Terima kasih atas pesanan Anda. Pesanan Anda telah diterima dan sedang diproses.</p>
                
                <?php if ($order_id > 0): ?>
                    <p class="fw-bold fs-5">Nomor Pesanan Anda: #<?= $order_id ?></p>
                    
                    <?php else: ?>
                    <p class="alert alert-warning">Nomor pesanan tidak ditemukan.</p>
                <?php endif; ?>

                <a href="shop.php" class="btn btn-primary-custom mt-3 me-2">Lanjut Belanja</a>
                <a href="index.php" class="btn btn-outline-secondary mt-3">Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>