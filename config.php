<?php
// 数据库连接配置
$host = 'localhost';
$user = 'root';
$password = 'xbkxbk0707'; // 你的MySQL密码
$dbname = 'car_sales';

// 创建连接
$conn = mysqli_connect($host, $user, $password, $dbname);

// 检查连接
if (!$conn) {
    die("连接失败: " . mysqli_connect_error());
}

// 设置字符集
mysqli_set_charset($conn, 'utf8');
?>