<?php
// test_login.php - 临时登录页面用于测试
session_start();

// 如果有登录请求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username && $password) {
        // 临时测试：固定卖家ID
        $_SESSION['seller_id'] = 1;  // 假设数据库中有ID为1的卖家
        $_SESSION['username'] = $username;
        
        // 重定向到添加车辆页面
        header('Location: add-car.html');
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>测试登录</title>
    <style>
        body { font-family: Arial; padding: 20px; }
        form { max-width: 300px; margin: 50px auto; }
        input, button { width: 100%; padding: 10px; margin: 5px 0; }
    </style>
</head>
<body>
    <h2>测试登录页面</h2>
    <p>（仅用于测试Add Car功能）</p>
    <form method="POST">
        <input type="text" name="username" placeholder="用户名" required>
        <input type="password" name="password" placeholder="密码" value="test23" required>
        <button type="submit">登录</button>
    </form>
    <p><strong>提示：</strong>需要先向数据库中插入卖家数据，或手动创建</p>
</body>
</html>