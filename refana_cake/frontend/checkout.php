<?php
session_start();
require_once dirname(__DIR__) . '/backend/cakes.php'; 
$cart_items = $_SESSION['cart'] ?? [];
$total_price = 0;

if (empty($cart_items)) {
    $_SESSION['message'] = "Keranjang Anda kosong. Silakan pilih kue terlebih dahulu.";
    $_SESSION['message_type'] = "warning";
    header("Location: shop.php");
    exit();
}

foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | Refana Cake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <style>
        body { background-color: #fff8f0; color: #5d3a1a; }
        .navbar { background-color: #6f4e37; }
        .navbar a { color: white !important; }
        .navbar-brand { font-family: 'Cookie', cursive; font-size: 2.5rem; }
        .btn-primary-custom { background-color: #6f4e37; border-color: #6f4e37; color: white; }
        .btn-primary-custom:hover { background-color: #5d3a1a; border-color: #5d3a1a; }
        .summary-box { background-color: #f5e9d4; border: 2px solid #6f4e37; padding: 20px; border-radius: 8px; }
        .checkout-form { background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">Refana Cake</a>
        <div class="ms-auto">
            <a href="cart.php" class="btn btn-sm btn-outline-light">Kembali ke Keranjang</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    <?php 
    if (isset($_SESSION['message'])) {
        $alert_class = ($_SESSION['message_type'] === 'success') ? 'alert-success' : 'alert-danger';
        echo '<div class="alert ' . $alert_class . ' mt-3" role="alert">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
    ?>

    <h2 class="mb-4 text-center" style="color: #6f4e37;">Selesaikan Pemesanan</h2>
    <div class="row">
        
        <div class="col-md-7">
            <div class="checkout-form">
                <h4 class="mb-3" style="color: #6f4e37;">Informasi Pelanggan</h4>
                <form action="crud/process_order.php" method="POST">
                    
                    <div class="mb-3">
                        <label for="customer_name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="customer_email" name="customer_email" required>
                    </div>
                    <div class="mb-3">
                        <label for="customer_phone" class="form-label">Nomor Telepon</label>
                        <input type="tel" class="form-control" id="customer_phone" name="customer_phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">Alamat Pengiriman Lengkap</label>
                        <textarea class="form-control" id="shipping_address" name="shipping_address" rows="3" required></textarea>
                    </div>
                    
                    <h4 class="mt-4 mb-3" style="color: #6f4e37;">Pembayaran</h4>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="payment_method" name="payment_method" required>
                            <option value="">Pilih Metode</option>
                            <option value="Transfer Bank">Transfer Bank</option>
                            <option value="Cash on Delivery">Cash on Delivery (COD)</option>
                        </select>
                    </div>
                    
                    <input type="hidden" name="total_amount" value="<?= $total_price ?>">
                    <button type="submit" name="process_order" class="btn btn-primary-custom w-100 mt-3">Bayar & Proses Pesanan</button>
                </form>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="summary-box">
                <h4 style="color: #6f4e37;">Ringkasan Pesanan</h4>
                <hr>
                <ul class="list-group list-group-flush mb-3">
                    <?php foreach ($cart_items as $item): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-0 px-0">
                        <?= $item['name'] ?> (<?= $item['quantity'] ?>x)
                        <span class="fw-bold">Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?></span>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Total Akhir:</h5>
                    <h4 class="fw-bold" style="color: #6f4e37;">Rp <?= number_format($total_price, 0, ',', '.') ?></h4>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>