<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // 查询数据库
    $sql = "SELECT * FROM sellers WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);

    // 验证密码
    if ($row && password_verify($password, $row['password'])) {
        $_SESSION['seller_id'] = $row['seller_id'];
        $_SESSION['username'] = $row['username'];
        echo "<script>alert('Login successful');location.href='add-car.html';</script>";
    } else {
        echo "<script>alert('Wrong username or password');history.back();</script>";
    }
    exit;
}
?>