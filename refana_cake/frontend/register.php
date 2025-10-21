<?php 
session_start(); 
include '../backend/config.php'; 

$register_message = '';

if (isset($_POST['customer_register'])) {
    $name = sanitize_input($_POST['name']);
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']);
    
    $check_sql = "SELECT id FROM customers WHERE email = '$email'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        $register_message = '<div class="alert alert-warning" role="alert">Email sudah terdaftar. Silakan login.</div>';
    } else {
        $insert_sql = "INSERT INTO customers (name, email, password) VALUES ('$name', '$email', '$password')";
        
        if ($conn->query($insert_sql) === TRUE) {
            $_SESSION['login_success_msg'] = "Pendaftaran berhasil! Silakan login menggunakan email Anda.";
            header("Location: login.php");
            exit();
        } else {
            $register_message = '<div class="alert alert-danger" role="alert">Gagal mendaftar: ' . $conn->error . '</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { background-color: #fff8f0; color: #5d3a1a; }
        .register-container { max-width: 450px; margin-top: 50px; padding: 30px; background-color: #f5e9d4; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .btn-submit { background-color: #6f4e37; color: white; }
        .btn-submit:hover { background-color: #5d3a1a; color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 register-container">
                <h2 class="text-center mb-4">Buat Akun Pelanggan</h2>
                
                <?= $register_message ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" name="customer_register" class="btn btn-submit w-100">Daftar</button>
                </form>
                
                <div class="text-center mt-3 pt-3 border-top">
                    <a href="login.php" class="text-decoration-none fw-bold" style="color: #6f4e37;">Sudah punya akun? Login di sini.</a>
                </div>
                <div class="text-center mt-2">
                    <a href="index.php" class="text-decoration-none" style="color: #5d3a1a;">Kembali ke Home</a>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>