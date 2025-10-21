<?php
session_start();
include __DIR__ . '/config.php';

if (isset($_POST['admin_login'])) {
    
    if (!isset($conn)) {
        $_SESSION['login_error'] = "Koneksi database gagal. Cek file config.php.";
        header("Location: ../frontend/admin_login.php");
        exit();
    }
    
    $username = sanitize_input($_POST['username']);
    $password = $_POST['password']; 

    $sql = "SELECT id, username, password, full_name FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $_SESSION['login_error'] = "Terjadi kesalahan sistem saat login. (Prepared Statement Error)";
        header("Location: ../frontend/admin_login.php");
        exit();
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    
    $stmt->store_result();
    $stmt->bind_result($admin_id, $admin_username, $hashed_password, $full_name); 

    if ($stmt->num_rows === 1) {
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) { 

            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin_id; 
            $_SESSION['admin_username'] = $admin_username;
            
            $name_to_display = $full_name ?? $admin_username; 
            
            $_SESSION['message'] = "Selamat datang, Admin " . $name_to_display . "!";
            $_SESSION['message_type'] = "success";
            
            $stmt->close();
            header("Location: ../frontend/admin_dashboard.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Username atau Password Admin salah.";
        }
    } else {
        $_SESSION['login_error'] = "Username atau Password Admin salah.";
    }
    
    $stmt->close(); 
    header("Location: ../frontend/admin_login.php");
    exit();
}

if (isset($_POST['customer_login'])) {
    
    if (!isset($conn)) {
        $_SESSION['login_error'] = "Koneksi database gagal. Cek file config.php.";
        header("Location: ../frontend/login.php");
        exit();
    }
    
    $email = sanitize_input($_POST['email']);
    $password = sanitize_input($_POST['password']); 

    $sql = "SELECT id, name, email, password FROM customers WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        $customer = $result->fetch_assoc();
        
        if ($password === $customer['password']) { 
            
            $_SESSION['customer_logged_in'] = true;
            $_SESSION['customer_id'] = $customer['id'];
            $_SESSION['customer_name'] = $customer['name'];
            
            header("Location: ../frontend/index.php"); 
            exit();
        } else {
            $_SESSION['login_error'] = "Email atau Password Customer salah.";
        }
    } else {
        $_SESSION['login_error'] = "Email atau Password Customer salah.";
    }
    
    header("Location: ../frontend/login.php");
    exit();
}

if (!isset($_POST['admin_login']) && !isset($_POST['customer_login'])) {
    
    $redirect_page = '';
    $is_admin_logout = isset($_SESSION['admin_logged_in']);
    $is_customer_logout = isset($_SESSION['customer_logged_in']);
    
    if ($is_admin_logout) {
        unset($_SESSION['admin_logged_in']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_id']);
        unset($_SESSION['message']);
        $redirect_page = '../frontend/admin_login.php';
    }
    
    if ($is_customer_logout) {
        unset($_SESSION['customer_logged_in']);
        unset($_SESSION['customer_id']);
        unset($_SESSION['customer_name']);
        
        if (empty($redirect_page)) {
            $redirect_page = '../frontend/index.php';
        }
    }

    if (!empty($redirect_page)) {
        header("Location: " . $redirect_page);
        exit();
    }

    header("Location: ../frontend/index.php"); 
    exit();
}
?>