<?php
session_start();
if (!isset($_SESSION['customer_logged_in'])) {
    header("Location: login.php");
    exit();
}

require_once '../backend/cakes.php'; 
$customer_id = $_SESSION['customer_id'];
$customer_name = $_SESSION['customer_name'] ?? 'Pelanggan';
$orders = getOrdersByCustomerId($customer_id);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan | Refana Cake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <style>
        body { background-color: #fff8f0; color: #5d3a1a; }
        .navbar { background-color: #6f4e37; }
        .navbar a { color: white !important; }
        .navbar-brand { font-family: 'Cookie', cursive; font-size: 2.5rem; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="index.php">Refana Cake</a>
        <div class="ms-auto">
            <a class="btn btn-sm btn-outline-light" href="logout.php">Logout</a>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h2 class="mb-4" style="color: #6f4e37;">Riwayat Pesanan Anda, <?= htmlspecialchars($customer_name) ?></h2>
    
    <?php 
    if (isset($_SESSION['message'])): 
        $alert_class = $_SESSION['message_type'] ?? 'info';
    ?>
        <div class="alert alert-<?= $alert_class ?> alert-dismissible fade show" role="alert">
            <?= $_SESSION['message'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php 
        unset($_SESSION['message'], $_SESSION['message_type']);
    endif; 
    ?>

    <?php if (count($orders) > 0): ?>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Tanggal</th>
                <th>Item</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td>#<?= $order['order_id'] ?></td>
                <td><?= date('d M Y H:i', strtotime($order['order_date'])) ?></td>
                <td><?= htmlspecialchars($order['items_list']) ?></td>
                <td>Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></td>
                <td>
                    <?php 
                        $badge_class = 'bg-secondary';
                        if ($order['status'] == 'Processing') $badge_class = 'bg-warning text-dark';
                        else if ($order['status'] == 'Delivered') $badge_class = 'bg-success';
                        else if ($order['status'] == 'Pending') $badge_class = 'bg-danger';
                        else if ($order['status'] == 'Ready for Pickup/Delivery') $badge_class = 'bg-info text-dark';
                        else if ($order['status'] == 'Cancelled') $badge_class = 'bg-danger';
                    ?>
                    <span class="badge <?= $badge_class ?>"><?= $order['status'] ?></span>
                </td>
                <td>
                    <?php if ($order['status'] == 'Delivered'): ?>
                        <button 
                            type="button" 
                            class="btn btn-sm btn-success btn-review" 
                            data-bs-toggle="modal" 
                            data-bs-target="#reviewModal"
                            data-order-id="<?= $order['order_id'] ?>"
                            data-items-list="<?= htmlspecialchars($order['items_list']) ?>">
                            Beri Ulasan
                        </button>
                    <?php elseif ($order['status'] == 'Cancelled'): ?>
                        <span class="text-danger small fw-bold">Dibatalkan</span>
                    <?php else: ?>
                        <span class="text-muted small">Dalam Proses</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <div class="alert alert-info">Anda belum memiliki riwayat pesanan. Yuk, <a href="shop.php">mulai belanja!</a></div>
    <?php endif; ?>
    
    <a href="index.php" class="btn btn-outline-secondary mt-3">Kembali ke Beranda</a>
</div>

<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="../backend/process_review.php" method="POST">
        <div class="modal-header">
          <h5 class="modal-title" id="reviewModalLabel" style="color: #6f4e37;">Ulas Pesanan <span id="modal-order-id-display"></span></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p class="small text-muted mb-3">Pesanan yang diulas: <strong id="modal-items-list-display"></strong></p>
            
            <input type="hidden" name="order_id" id="modal-order-id">
            <input type="hidden" name="cake_id" id="modal-cake-id" value="1"> 
            
            <div class="mb-3">
                <label class="form-label">Rating Bintang (1-5)</label>
                <div>
                    <?php for ($i = 5; $i >= 1; $i--): ?>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rating" id="rating<?= $i ?>" value="<?= $i ?>" required <?= ($i == 5 ? 'checked' : '') ?>>
                            <label class="form-check-label" for="rating<?= $i ?>"><?= $i ?> ★</label>
                        </div>
                    <?php endfor; ?>
                </div>
            </div>

            <div class="mb-3">
                <label for="comment" class="form-label">Komentar Anda (Tulis nama kue yang Anda ulas)</label>
                <textarea class="form-control" name="comment" id="comment" rows="3" required></textarea>
            </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          <button type="submit" name="submit_review" class="btn btn-success" style="background-color: #6f4e37; border-color: #6f4e37;">Kirim Ulasan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const reviewModal = document.getElementById('reviewModal');
    if (reviewModal) {
        reviewModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            
            const orderId = button.getAttribute('data-order-id');
            const itemsList = button.getAttribute('data-items-list');
            
            const modalTitleDisplay = reviewModal.querySelector('#modal-order-id-display');
            const modalItemsListDisplay = reviewModal.querySelector('#modal-items-list-display');
            const modalOrderId = reviewModal.querySelector('#modal-order-id');
            
            modalTitleDisplay.textContent = `#${orderId}`;
            modalItemsListDisplay.textContent = itemsList;
            modalOrderId.value = orderId;
            
        });
    }
});
</script>
</body>
</html>