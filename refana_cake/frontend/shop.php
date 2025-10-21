<?php
session_start();
require_once '../backend/cakes.php';
$cakes = getAllCakes();

$cart_count = 0;
if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cart_count += $item['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Kue | Refana Cake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <style>
        body { background-color: #fff8f0; color: #5d3a1a; }
        .navbar { background-color: #6f4e37; }
        .navbar a { color: white !important; }
        .navbar-brand { font-family: 'Cookie', cursive; font-size: 2.5rem; }
        .cake-card { border: 1px solid #6f4e37; border-radius: 10px; overflow: hidden; }
        .cake-card img { height: 200px; object-fit: cover; }
        .btn-primary-custom { background-color: #6f4e37; border-color: #6f4e37; color: white; }
        .btn-primary-custom:hover { background-color: #5d3a1a; border-color: #5d3a1a; }
        .price { font-size: 1.2rem; font-weight: bold; color: #6f4e37; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">Refana Cake</a>
        <div class="ms-auto">
            <a href="admin_dashboard.php" class="btn btn-sm btn-outline-light me-2">Admin</a>
            <a href="cart.php" class="btn btn-sm btn-outline-light position-relative">
                Keranjang
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?= $cart_count ?>
                    <span class="visually-hidden">items in cart</span>
                </span>
            </a>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h2 class="mb-4 text-center" style="color: #6f4e37;">Menu Kue Kami</h2>
    <p class="text-center lead">Pilih kue yang Anda inginkan dan tambahkan ke keranjang.</p>
    
    <?php 
    if (isset($_SESSION['message'])): 
        $type = $_SESSION['message_type'] ?? 'info';
        echo '<div class="alert alert-' . $type . '">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message'], $_SESSION['message_type']);
    endif;
    ?>

    <div class="row row-cols-1 row-cols-md-3 g-4 mt-4">
        <?php if (!empty($cakes)): ?>
            <?php foreach ($cakes as $cake): ?>
            <div class="col">
                <div class="card h-100 cake-card shadow-sm">
                    <img src="../<?= $cake['image_path'] ?>" class="card-img-top" alt="<?= $cake['name'] ?>">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title" style="color: #6f4e37;"><?= $cake['name'] ?></h5>
                        <p class="card-text flex-grow-1"><small><?= substr($cake['description'], 0, 100) ?>...</small></p>
                        <div class="mt-auto">
                            <p class="price mb-2">Rp <?= number_format($cake['price'], 0, ',', '.') ?></p>
                            <form action="crud/add_to_cart.php" method="POST">
                                <input type="hidden" name="cake_id" value="<?= $cake['id'] ?>">
                                <input type="hidden" name="price" value="<?= $cake['price'] ?>">
                                <div class="input-group">
                                    <input type="number" name="quantity" class="form-control" value="1" min="1" max="<?= $cake['stock'] ?>" required>
                                    <button type="submit" name="add_to_cart" class="btn btn-primary-custom" <?= $cake['stock'] == 0 ? 'disabled' : '' ?>>
                                        <?= $cake['stock'] == 0 ? 'Stok Habis' : 'Masukkan Keranjang' ?>
                                    </button>
                                </div>
                                <small class="text-muted">Stok: <?= $cake['stock'] ?></small>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12"><div class="alert alert-warning text-center">Maaf, belum ada kue yang tersedia saat ini.</div></div>
        <?php endif; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>