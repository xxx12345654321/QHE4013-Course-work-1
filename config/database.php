<?php
$host = 'localhost';
$user = 'root';
$password = 'wxzql5817';
$dbname = 'car_sales';

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$conn->set_charset('utf8');
?>
