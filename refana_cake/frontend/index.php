<?php 
session_start(); 
require_once '../backend/cakes.php'; 
$cart_count = array_sum(array_column($_SESSION['cart'] ?? [], 'quantity')); 
$reviews = getPublishedReviews(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Refana Cake</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
  
  <style>
    body {
      background-color: #fff8f0;
      color: #5d3a1a;
    }
    .navbar, .footer {
      background-color: #6f4e37;
    }
    .navbar a, .footer a {
      color: white !important;
    }
    .navbar-brand {
        font-family: 'Cookie', cursive; 
        font-size: 2.2rem; 
    }
    .btn-order {
      background-color: #6f4e37;
      color: white;
      font-weight: bold;
      padding: 10px 30px;
      border-radius: 30px;
      border: none;
    }
    .btn-order:hover {
      background-color: #5d3a1a;
      color: white;
    }
    .favorite-cake img {
      max-width: 100%;
      border-radius: 15px;
    }
    .review {
      background-color: #f5e9d4;
      border-radius: 10px;
      padding: 15px;
      margin-bottom: 15px;
    }
    .contact-section {
      background-color: #6f4e37;
      color: white;
      padding: 30px 0;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand text-white" href="#">Refana Cake</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link text-white" href="#home">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="#contact">Contact</a></li>
        <?php if(isset($_SESSION['admin_logged_in'])): ?>
          <li class="nav-item"><a class="nav-link text-white" href="admin_dashboard.php">Dashboard Admin</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout (Admin)</a></li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link text-white" href="admin_login.php">Dashboard Admin</a></li>
        <?php endif; ?>
        <?php if(isset($_SESSION['customer_logged_in'])): ?>
          <li class="nav-item"><a class="nav-link text-white" href="order_history.php">Cek Pesanan</a></li>
          <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
          <?php else: ?>
          <li class="nav-item"><a class="nav-link text-white" href="login.php">Sign In</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<section id="home" class="position-relative text-center" style="background: url('../assets/images/12.jpg') no-repeat center center; background-size: cover; height: 500px;">
  <div class="position-absolute top-50 start-50 translate-middle bg-white bg-opacity-75 p-4 rounded">
    <h1 class="mb-3">Nikmati Kelezatan Kue Pilihan Kami</h1>
    <a href="shop.php" class="btn btn-order">Order Now</a>
  </div>
</section>

<section id="order" class="container my-5">
  <h2 class="text-center mb-4">Favorite Cakes</h2>
  <div class="row favorite-cake g-4">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <img src="../assets/images/1.jpg" class="card-img-top" alt="Chocolate Cake" />
        <div class="card-body text-center">
          <h5 class="card-title">Chocolate Cake</h5>
          <p class="card-text"></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <img src="../assets/images/2.jpg" class="card-img-top" alt="Strawberry Cake" />
        <div class="card-body text-center">
          <h5 class="card-title">	Spider-Man Birthday Cake</h5>
          <p class="card-text"></p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm">
        <img src="../assets/images/3.jpg" class="card-img-top" alt="Cheesecake" />
        <div class="card-body text-center">
          <h5 class="card-title">Wedding Cake</h5>
          <p class="card-text"></p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="container my-5">
  <h2 class="text-center mb-4">Ulasan Pelanggan</h2>
  <div class="row justify-content-center">
    <div class="col-md-8">
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
            <div class="review">
                <p class="mb-1">
                    <?= htmlspecialchars($review['comment']) ?>
                </p>
                <div class="small text-muted mb-2">
                    <?php 
                        // Tampilkan rating bintang (★)
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<span style="color: gold;">' . ($i <= $review['rating'] ? '★' : '☆') . '</span>';
                        }
                    ?>
                    <span class="ms-2">tentang **<?= htmlspecialchars($review['cake_name']) ?>**</span>
                </div>
                <small class="fw-bold">- <?= htmlspecialchars($review['customer_name']) ?></small>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-info text-center">Belum ada ulasan dari pelanggan. Jadilah yang pertama!</div>
        <?php endif; ?>
    </div>
  </div>
</section>

<section id="contact" class="contact-section text-center">
  <div class="container">
    <h2>Contact & Location</h2>
    <p>Email: refanacake@gmail.com</p>
    <p>WhatsApp: +62 82217335514</p>
    <p>Address: Jl. Raya Buninagara, Buninagara, Malausma</p>
 </div>
</section>

<footer class="footer text-center py-3">
  <div class="container">
    © 2024 Refana Cake. All rights reserved.
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>