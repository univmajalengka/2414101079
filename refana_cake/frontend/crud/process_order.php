<?php
session_start();
include dirname(__DIR__, 2) . '/backend/config.php'; 
require_once dirname(__DIR__, 2) . '/backend/cakes.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['process_order']) || empty($_SESSION['cart'])) {
    $_SESSION['message'] = "Akses tidak valid atau keranjang kosong.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../shop.php");
    exit();
}

if (!isset($conn) || $conn->connect_error) {
    $_SESSION['message'] = "KONEKSI GAGAL! Pastikan file config.php sudah ada dan koneksinya benar.";
    $_SESSION['message_type'] = "danger";
    header("Location: ../checkout.php");
    exit();
}

$name = sanitize_input($_POST['customer_name']);
$email = sanitize_input($_POST['customer_email']);
$phone = sanitize_input($_POST['customer_phone']);
$address = sanitize_input($_POST['shipping_address']);
$payment_method = sanitize_input($_POST['payment_method']);
$total_amount = (float)$_POST['total_amount'];
$cart = $_SESSION['cart'];

$conn->begin_transaction(); 

try {
    $sql_check_customer = "SELECT id FROM customers WHERE email = '$email'";
    $result = $conn->query($sql_check_customer);
    
    $customer_id = 0;
    if ($result->num_rows > 0) {
        $customer_id = $result->fetch_assoc()['id'];
        $sql_update_customer = "UPDATE customers SET name='$name', phone='$phone', address='$address' WHERE id=$customer_id";
        if (!$conn->query($sql_update_customer)) {
             throw new Exception("Gagal update data pelanggan.");
        }
    } else {
        $sql_insert_customer = "INSERT INTO customers (name, email, phone, address, password) VALUES ('$name', '$email', '$phone', '$address', NULL)";
        if ($conn->query($sql_insert_customer)) {
            $customer_id = $conn->insert_id;
        } else {
            throw new Exception("Gagal membuat pelanggan baru. Kemungkinan kolom 'password' di tabel 'customers' tidak mengizinkan NULL. Error SQL: " . $conn->error);
        }
    }

    $status = 'Pending';
    $order_date = date('Y-m-d H:i:s');
    $sql_insert_order = "INSERT INTO orders (customer_id, order_date, total_amount, status, shipping_address, payment_method) 
                         VALUES ($customer_id, '$order_date', $total_amount, '$status', '$address', '$payment_method')";

    if ($conn->query($sql_insert_order)) {
        $order_id = $conn->insert_id;
    } else {
        throw new Exception("Gagal membuat pesanan utama. Error SQL: " . $conn->error);
    }
    
    foreach ($cart as $item) {
        $cake_id = $item['cake_id'];
        $quantity = $item['quantity'];
        $price_at_order = $item['price']; 

        $sql_insert_item = "INSERT INTO order_items (order_id, cake_id, quantity, price_at_order) 
                            VALUES ($order_id, $cake_id, $quantity, $price_at_order)";
        if (!$conn->query($sql_insert_item)) {
            throw new Exception("Gagal memasukkan item pesanan. Error SQL: " . $conn->error);
        }

        $sql_update_stock = "UPDATE cakes SET stock = stock - $quantity WHERE id = $cake_id";
        if (!$conn->query($sql_update_stock)) {
            throw new Exception("Gagal mengurangi stok. Error SQL: " . $conn->error);
        }
    }

    $conn->commit();

    unset($_SESSION['cart']);

    $_SESSION['message'] = "Pesanan Anda (**#$order_id**) berhasil dibuat! Kami akan segera memprosesnya.";
    $_SESSION['message_type'] = "success";
    header("Location: ../order_success.php?id=$order_id");
    exit();

} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['message'] = "TERJADI KEGAGALAN SISTEM: " . $e->getMessage();
    $_SESSION['message_type'] = "danger";
    header("Location: ../checkout.php");
    exit();
}
?>