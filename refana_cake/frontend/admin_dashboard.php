<?php 
session_start(); 
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

require_once __DIR__ . '/../backend/cakes.php'; 

$cakes = getAllCakes();
$orders_list = getOrders();

$total_sales_month = getTotalSalesThisMonth();
$pending_orders = countNewOrders();
$total_customers = countTotalCustomers();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Refana Cake</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
    <style>
        body { background-color: #fff8f0; color: #5d3a1a; }
        .navbar { background-color: #6f4e37; }
        .navbar a { color: white !important; }
        .navbar-brand { font-family: 'Cookie', cursive; font-size: 2.2rem; }
        .card-summary { background-color: #f5e9d4; border: 1px solid #6f4e37; color: #5d3a1a; }
        .tab-content { background-color: white; border: 1px solid #dee2e6; border-top: none; }
        .btn-primary-custom { background-color: #6f4e37; border-color: #6f4e37; color: white; }
        .btn-primary-custom:hover { background-color: #5d3a1a; border-color: #5d3a1a; }
        .nav-tabs .nav-link.active {
            background-color: #f5e9d4 !important;
            border-bottom-color: #fff8f0 !important;
            color: #6f4e37 !important;
            font-weight: bold;
        }
        .btn-transparent-custom {
            background-color: transparent !important; 
            color: white !important; 
            border: 1px solid white !important; 
        }
        .btn-transparent-custom:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
            color: white !important;
            border: 1px solid white !important;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand text-white" href="../index.php">Refana Cake</a>
        <span class="navbar-text text-white ms-auto me-3">
            Halo, Admin (<?= $_SESSION['admin_username'] ?>)
        </span>
        <a class="btn btn-sm btn-transparent-custom" href="logout.php">Logout</a> 
    </div>
</nav>

<div class="container my-5">
    <h2 class="mb-4" style="color: #6f4e37;">Admin Dashboard</h2>

    <?php 
    if (isset($_SESSION['message'])) {
        echo '<div class="alert alert-' . $_SESSION['message_type'] . '">' . $_SESSION['message'] . '</div>';
        unset($_SESSION['message'], $_SESSION['message_type']);
    }
    ?>

    <ul class="nav nav-tabs" id="adminTabs" role="tablist">
        <li class="nav-item"><button class="nav-link active" id="summary-tab" data-bs-toggle="tab" data-bs-target="#summary" type="button">Ringkasan</button></li>
        <li class="nav-item"><button class="nav-link" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button">Kelola Produk</button></li>
        <li class="nav-item"><button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button">Kelola Pesanan</button></li>
    </ul>

    <div class="tab-content p-3" id="adminTabsContent">
        
        <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
            <h3 class="mb-4">Ringkasan Kinerja Bisnis</h3>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-summary text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title text-muted">Total Penjualan Bulan Ini</h5>
                            <h2 class="card-text fw-bold" style="color: #6f4e37;">Rp <?= number_format($total_sales_month, 0, ',', '.') ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-summary text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title text-muted">Pesanan Baru (Pending)</h5>
                            <h2 class="card-text fw-bold" style="color: #6f4e37;"><?= $pending_orders ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-summary text-center p-3">
                        <div class="card-body">
                            <h5 class="card-title text-muted">Total Pelanggan Terdaftar</h5>
                            <h2 class="card-text fw-bold" style="color: #6f4e37;"><?= $total_customers ?></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div> 


        <div class="tab-pane fade" id="products" role="tabpanel" aria-labelledby="products-tab">
            <h3 class="mb-4">Daftar Kue yang Dijual</h3>
            
            <button class="btn btn-primary-custom mb-3" data-bs-toggle="modal" data-bs-target="#cakeModal" onclick="prepareCakeModal('add')">+ Tambah Kue Baru</button>
            
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th><th>Gambar</th><th>Nama</th><th>Harga</th><th>Stok</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($cakes) > 0): ?>
                        <?php foreach ($cakes as $cake): ?>
                        <tr id="cake-row-<?= $cake['id'] ?>">
                            <td><?= $cake['id'] ?></td>
                            <td><img src="../<?= $cake['image_path'] ?>" alt="<?= $cake['name'] ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;"></td>
                            <td data-name="<?= htmlspecialchars($cake['name']) ?>" data-desc="<?= htmlspecialchars($cake['description']) ?>"><?= $cake['name'] ?></td>
                            <td>Rp <?= number_format($cake['price'], 0, ',', '.') ?></td>
                            <td data-price="<?= $cake['price'] ?>" data-stock="<?= $cake['stock'] ?>" data-path="<?= htmlspecialchars($cake['image_path']) ?>"><?= $cake['stock'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#cakeModal" onclick="prepareCakeModal('edit', <?= $cake['id'] ?>)">Edit</button>
                                <a href="crud/delete_cake.php?id=<?= $cake['id'] ?>" onclick="return confirm('Yakin ingin menghapus kue <?= $cake['name'] ?>?');" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="text-center">Belum ada produk kue yang terdaftar.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>


        <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
            <h3 class="mb-4">Daftar Pesanan Terbaru</h3>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID Pesanan</th><th>Pelanggan</th><th>Tanggal</th><th>Total</th><th>Status</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders_list as $order): ?>
                    <tr id="order-row-<?= $order['id'] ?>" 
                        data-customer="<?= htmlspecialchars($order['customer']) ?>" 
                        data-date="<?= $order['date'] ?>" 
                        data-total="<?= number_format($order['total'], 0, ',', '.') ?>"
                        data-address="<?= htmlspecialchars($order['address']) ?>"
                        data-items="<?= htmlspecialchars($order['items']) ?>"
                        data-status="<?= $order['status'] ?>">
                        <td>#<?= $order['id'] ?></td>
                        <td><?= $order['customer'] ?></td>
                        <td><?= $order['date'] ?></td>
                        <td>Rp <?= number_format($order['total'], 0, ',', '.') ?></td>
                        <td>
                            <?php 
                                $badge_class = 'bg-secondary';
                                if ($order['status'] == 'Processing') $badge_class = 'bg-warning text-dark';
                                else if ($order['status'] == 'Delivered') $badge_class = 'bg-success';
                                else if ($order['status'] == 'Pending') $badge_class = 'bg-danger';
                                else if ($order['status'] == 'Ready for Pickup/Delivery') $badge_class = 'bg-info text-dark';
                            ?>
                            <span class="badge <?= $badge_class ?>"><?= $order['status'] ?></span>
                        </td>
                        <td>
                            <button class="btn btn-primary-custom btn-sm" data-bs-toggle="modal" data-bs-target="#orderDetailModal" onclick="showOrderDetail(<?= $order['id'] ?>)">Detail</button>
                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#changeStatusModal" onclick="showChangeStatus(<?= $order['id'] ?>, '<?= $order['status'] ?>')">Ubah Status</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div> </div> <div class="modal fade" id="cakeModal" tabindex="-1" aria-labelledby="cakeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cakeModalLabel">Tambah/Edit Kue</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="cake-form" method="POST" action="crud/add_cake.php">
                <div class="modal-body">
                    <input type="hidden" id="modal-mode" name="mode" value="add">
                    <input type="hidden" id="modal-cake-id" name="cake_id" value="">

                    <div class="mb-3">
                        <label for="modal-name" class="form-label">Nama Kue</label>
                        <input type="text" class="form-control" id="modal-name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal-description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="modal-description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="modal-price" class="form-label">Harga (Rp)</label>
                        <input type="number" class="form-control" id="modal-price" name="price" required min="1000">
                    </div>
                    <div class="mb-3">
                        <label for="modal-stock" class="form-label">Stok</label>
                        <input type="number" class="form-control" id="modal-stock" name="stock" required min="0">
                    </div>
                    <div class="mb-3">
                        <label for="modal-image-path" class="form-label">Path Gambar</label>
                        <input type="text" class="form-control" id="modal-image-path" name="image_path" value="assets/images/default.jpg">
                        <small class="text-muted">Contoh: assets/images/black_forest.jpg</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" name="submit_cake" id="modal-submit-btn" class="btn btn-primary-custom">Simpan Kue</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailModalLabel">Detail Pesanan #<span id="detail-order-id"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Pelanggan:</strong> <span id="detail-customer"></span></p>
                <p><strong>Tanggal:</strong> <span id="detail-date"></span></p>
                <p><strong>Total Pembayaran:</strong> Rp <span id="detail-total"></span></p>
                <p><strong>Status:</strong> <span id="detail-status" class="badge"></span></p>
                <p><strong>Alamat Pengiriman:</strong> <span id="detail-address"></span></p>
                <hr>
                <h6>Item Pesanan:</h6>
                <pre id="detail-items"></pre>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changeStatusModalLabel">Ubah Status Pesanan #<span id="status-order-id"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="crud/update_order_status.php" method="POST">
                <div class="modal-body">
                    <input type="hidden" name="order_id" id="status-order-id-input">
                    <p>Status saat ini: <span id="current-status" class="fw-bold"></span></p>

                    <div class="mb-3">
                        <label for="new_status" class="form-label">Pilih Status Baru</label>
                        <select class="form-select" id="new_status" name="new_status" required>
                            <option value="Pending">Pending</option>
                            <option value="Processing">Processing</option>
                            <option value="Ready for Pickup/Delivery">Ready for Pickup/Delivery</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="update_order_status" class="btn btn-primary-custom">Simpan Status Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="dashboard.js"></script> 
</body>
</html>