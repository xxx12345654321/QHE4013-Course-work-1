<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {// 接收前端传过来的表单数据
    
    $name     = trim($_POST['name']);
    $address  = trim($_POST['address']);
    $phone    = trim($_POST['phone']);
    $email    = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    //密码加密 效果是在数据库中看到的是加密过的密码，保护安全
    $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);

    //插入数据库
    $sql = "INSERT INTO sellers (name, address, phone, email, username, password)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $address, $phone, $email, $username, $hashed_pwd);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Registration successful!'); location.href='login.php';</script>";
    } else {
        echo "<script>alert('Registration failed: Username or Email already exists'); history.back();</script>";
   

    exit;
}
?>