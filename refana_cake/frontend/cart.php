<?php
session_start();
$cart_items = $_SESSION['cart'] ?? [];
$total_price = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja | Refana Cake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <style>
        body { background-color: #fff8f0; color: #5d3a1a; }
        .navbar { background-color: #6f4e37; }
        .navbar a { color: white !important; }
        .navbar-brand { font-family: 'Cookie', cursive; font-size: 2.5rem; }
        .cart-item { background-color: white; border: 1px solid #6f4e37; border-radius: 8px; margin-bottom: 15px; padding: 15px; }
        .btn-primary-custom { background-color: #6f4e37; border-color: #6f4e37; color: white; }
        .btn-primary-custom:hover { background-color: #5d3a1a; border-color: #5d3a1a; }
        .total-box { background-color: #f5e9d4; border: 2px solid #6f4e37; padding: 20px; border-radius: 8px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">Refana Cake</a>
        <div class="ms-auto">
            <a href="shop.php" class="btn btn-sm btn-outline-light">Kembali Belanja</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h2 class="mb-4" style="color: #6f4e37;">Keranjang Belanja Anda</h2>

    <?php 
    if (isset($_SESSION['message'])): 
        $type = $_SESSION['message_type'] ?? 'info';
        echo '<div class="alert alert-' . $type . '">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message'], $_SESSION['message_type']);
    endif;
    ?>

    <?php if (empty($cart_items)): ?>
        <div class="alert alert-info text-center">Keranjang Anda kosong. <a href="shop.php">Mulai belanja di sini!</a></div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-8">
                <?php foreach ($cart_items as $cake_id => $item): 
                    $subtotal = $item['price'] * $item['quantity'];
                    $total_price += $subtotal;
                ?>
                <div class="row cart-item align-items-center">
                    <div class="col-2">
                        <img src="../<?= $item['image_path'] ?>" alt="<?= $item['name'] ?>" style="width: 100%; height: 80px; object-fit: cover; border-radius: 5px;">
                    </div>
                    <div class="col-4">
                        <h5 class="mb-1"><?= $item['name'] ?></h5>
                        <p class="text-muted mb-0">Harga: Rp <?= number_format($item['price'], 0, ',', '.') ?></p>
                    </div>
                    <div class="col-3">
                        <form action="crud/update_cart.php" method="POST" class="d-flex align-items-center">
                            <input type="hidden" name="cake_id" value="<?= $cake_id ?>">
                            <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1" class="form-control form-control-sm me-2" style="width: 70px;">
                            <button type="submit" name="update_cart" class="btn btn-secondary btn-sm">Update</button>
                        </form>
                    </div>
                    <div class="col-2 text-end">
                        <p class="fw-bold mb-0">Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
                    </div>
                    <div class="col-1 text-end">
                        <a href="crud/update_cart.php?action=remove&id=<?= $cake_id ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Hapus item ini?');">X</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="col-md-4">
                <div class="total-box">
                    <h4 style="color: #6f4e37;">Ringkasan Belanja</h4>
                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <p class="fw-bold">Total Pembayaran:</p>
                        <h4 class="fw-bold" style="color: #6f4e37;">Rp <?= number_format($total_price, 0, ',', '.') ?></h4>
                    </div>
                    <a href="checkout.php" class="btn btn-primary-custom w-100">Lanjut ke Checkout</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>