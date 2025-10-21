<?php
require_once __DIR__ . '/config.php';

function getAllCakes() {
    global $conn;
    if (!$conn) return [];
    $result = $conn->query("SELECT * FROM cakes ORDER BY id DESC");
    $cakes = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cakes[] = $row;
        }
    }
    return $cakes;
}

function getCakeById($id) {
    global $conn;
    if (!$conn) return null;
    $id = (int)$id;
    $result = $conn->query("SELECT * FROM cakes WHERE id = $id");
    if ($result && $result->num_rows === 1) {
        return $result->fetch_assoc();
    }
    return null;
}

function addCake($name, $description, $price, $image_path, $stock) {
    global $conn;
    if (!$conn) return false;
    $name = sanitize_input($name);
    $description = sanitize_input($description);
    $price = (int)$price;
    $stock = (int)$stock;
    $image_path = sanitize_input($image_path);

    $sql = "INSERT INTO cakes (name, description, price, image_path, stock) 
            VALUES ('$name', '$description', $price, '$image_path', $stock)";
    return $conn->query($sql);
}

function updateCake($id, $name, $description, $price, $image_path, $stock) {
    global $conn;
    if (!$conn) return false;
    $id = (int)$id;
    $name = sanitize_input($name);
    $description = sanitize_input($description);
    $price = (int)$price;
    $stock = (int)$stock;
    $image_path = sanitize_input($image_path);

    $sql = "UPDATE cakes SET 
            name = '$name', description = '$description', price = $price, 
            image_path = '$image_path', stock = $stock 
            WHERE id = $id";
    return $conn->query($sql);
}

function deleteCake($id) {
    global $conn;
    if (!$conn) return false;
    $id = (int)$id;
    return $conn->query("DELETE FROM cakes WHERE id = $id");
}

function getOrders() {
    global $conn;
    if (!$conn) return [];
    
    $sql = "SELECT 
                o.id, 
                c.name AS customer, 
                o.order_date AS date, 
                o.total_amount AS total, 
                o.status, 
                o.shipping_address AS address
            FROM orders o
            JOIN customers c ON o.customer_id = c.id
            ORDER BY o.order_date DESC";
            
    $result = $conn->query($sql);
    $orders = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $items_sql = "SELECT 
                            ca.name, 
                            oi.quantity 
                          FROM order_items oi
                          JOIN cakes ca ON oi.cake_id = ca.id
                          WHERE oi.order_id = " . $row['id'];
            
            $items_result = $conn->query($items_sql);
            $items_string = [];
            if ($items_result && $items_result->num_rows > 0) {
                while ($item = $items_result->fetch_assoc()) {
                    $items_string[] = $item['name'] . " (" . $item['quantity'] . ")";
                }
            }
            
            $row['items'] = implode(', ', $items_string);
            $orders[$row['id']] = $row;
        }
    }
    return $orders;
}

function getAllOrders() {
    global $conn;
    if (!$conn) return [];
    
    $sql = "SELECT 
                o.id AS order_id,
                o.order_date,
                o.total_amount,
                o.status,
                o.shipping_address,
                o.payment_method,
                c.name AS customer_name,
                c.phone AS customer_phone
            FROM orders o
            JOIN customers c ON o.customer_id = c.id
            ORDER BY o.order_date DESC";
            
    $result = $conn->query($sql);
    $orders = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $item_sql = "SELECT ci.quantity, ca.name FROM order_items ci JOIN cakes ca ON ci.cake_id = ca.id WHERE ci.order_id = " . $row['order_id'];
            $item_result = $conn->query($item_sql);
            $items_list = [];
            if ($item_result) {
                while ($item = $item_result->fetch_assoc()) {
                    $items_list[] = $item['name'] . " (" . $item['quantity'] . ")";
                }
            }
            $row['items_list'] = implode(', ', $items_list);
            $orders[] = $row;
        }
    }
    return $orders;
}

function updateOrderStatus($order_id, $new_status) {
    global $conn;
    if (!$conn) return false;
    
    $order_id = (int)$order_id;
    $new_status = sanitize_input($new_status);
    
    $sql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_status, $order_id);
    
    return $stmt->execute();
}

function getOrdersByCustomerId($customer_id) {
    global $conn;
    if (!$conn) return [];
    
    $customer_id = (int)$customer_id;
    
    $sql = "SELECT 
                o.id AS order_id,
                o.order_date,
                o.total_amount,
                o.status
            FROM orders o
            WHERE o.customer_id = $customer_id
            ORDER BY o.order_date DESC";
            
    $result = $conn->query($sql);
    $orders = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $item_sql = "SELECT ci.quantity, ca.name FROM order_items ci JOIN cakes ca ON ci.cake_id = ca.id WHERE ci.order_id = " . $row['order_id'];
            $item_result = $conn->query($item_sql);
            $items_list = [];
            if ($item_result) {
                while ($item = $item_result->fetch_assoc()) {
                    $items_list[] = $item['name'] . " (" . $item['quantity'] . "x)";
                }
            }
            $row['items_list'] = implode(', ', $items_list); 
            $orders[] = $row;
        }
    }
    return $orders;
}

function addReview($customer_id, $cake_id, $order_id, $rating, $comment) {
    global $conn;
    if (!$conn) return false;
    
    $customer_id = (int)$customer_id;
    $cake_id = (int)$cake_id;
    $order_id = (int)$order_id;
    $rating = (int)$rating;
    $comment = sanitize_input($comment);
    
    $check_sql = "SELECT id FROM reviews WHERE order_id = $order_id AND cake_id = $cake_id";
    $check_result = $conn->query($check_sql);
    if ($check_result && $check_result->num_rows > 0) {
        return false; 
    }

    $sql = "INSERT INTO reviews (customer_id, cake_id, order_id, rating, comment) 
            VALUES ($customer_id, $cake_id, $order_id, $rating, '$comment')";
            
    return $conn->query($sql);
}

function getPublishedReviews() {
    global $conn;
    if (!$conn) return [];
    
    $sql = "SELECT 
                r.rating, 
                r.comment, 
                c.name AS customer_name,
                ca.name AS cake_name
            FROM reviews r
            JOIN customers c ON r.customer_id = c.id
            JOIN cakes ca ON r.cake_id = ca.id
            ORDER BY r.review_date DESC
            LIMIT 5"; 
            
    $result = $conn->query($sql);
    $reviews = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reviews[] = $row;
        }
    }
    return $reviews;
}

function getTotalSalesThisMonth() {
    global $conn; 
    $start_of_month = date('Y-m-01 00:00:00'); 
    
    $sql = "SELECT SUM(total_amount) AS total_sales 
            FROM orders 
            WHERE status IN ('Delivered', 'Ready for Pickup/Delivery') 
            AND order_date >= '$start_of_month'";
            
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return (int)$row['total_sales'];
    }
    return 0;
}

function countNewOrders() {
    global $conn;
    $sql = "SELECT COUNT(id) AS total_pending FROM orders WHERE status = 'Pending'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return (int)$result->fetch_assoc()['total_pending'];
    }
    return 0;
}

function countTotalCustomers() {
    global $conn;
    $sql = "SELECT COUNT(id) AS total_customers FROM customers";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        return (int)$result->fetch_assoc()['total_customers'];
    }
    return 0;
}
?>