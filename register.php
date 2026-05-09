<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim($_POST['name']);
    $address  = trim($_POST['address']);
    $phone    = trim($_POST['phone']);
    $email    = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO sellers (name, address, phone, email, username, password)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $address, $phone, $email, $username, $hashed_pwd);

    if (mysqli_stmt_execute($stmt)) {
        // 改这里：login.html 不是 login.php
        echo "<script>alert('Registration successful!'); location.href='login.html';</script>";
    } else {
        echo "<script>alert('Registration failed'); history.back();</script>";
    }

    exit;
}
?>