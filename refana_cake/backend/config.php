<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "refana_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
}

if (!function_exists('sanitize_input')) {
    function sanitize_input($data) {
        global $conn;
        if (!$conn) return $data;
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return mysqli_real_escape_string($conn, $data); 
    }
}
?>