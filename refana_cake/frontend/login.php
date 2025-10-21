<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Sign In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { background-color: #fff8f0; color: #5d3a1a; }
        .login-container { max-width: 400px; margin-top: 100px; padding: 30px; background-color: #f5e9d4; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .btn-submit { background-color: #6f4e37; color: white; }
        .btn-submit:hover { background-color: #5d3a1a; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 login-container">
                <h2 class="text-center mb-4">Customer Sign In</h2>
                
                <?php 
                if (isset($_SESSION['login_error'])) {
                    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['login_error'] . '</div>';
                    unset($_SESSION['login_error']);
                }
                ?>

                <form action="../backend/auth.php" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="customer_login" class="btn btn-submit w-100">Sign In</button>
                </form>
                
                <div class="text-center mt-3 pt-3 border-top">
                    <p class="mb-1" style="color: #5d3a1a;">Belum punya akun?</p>
                    <a href="register.php" class="text-decoration-none fw-bold" style="color: #6f4e37;">Buat Akun Sekarang</a>
                </div>
                
                <div class="text-center mt-3">
                    <a href="index.php" class="text-decoration-none" style="color: #5d3a1a;">Kembali ke Home</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>