<?php
$password = 'refana123';
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo "Hash untuk refana123 adalah: " . $hashed_password;
?>