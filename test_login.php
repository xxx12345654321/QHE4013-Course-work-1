<?php
session_start();

require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = "Username and password are required";
    } else {
        $sql = "SELECT seller_id, username, password FROM sellers WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                $_SESSION['seller_id'] = $user['seller_id'];
                $_SESSION['username'] = $user['username'];
                header('Location: add-car.html');
                exit;
            } else {
                $error = "Invalid username or password";
            }
        } else {
            $error = "Invalid username or password";
        }
        $stmt->close();
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>AutoMall - Login</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f5f5f5; }
        .login-container { max-width: 300px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; }
        form { display: flex; flex-direction: column; }
        input, button { width: 100%; padding: 10px; margin: 5px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { background: #3498db; color: white; border: none; cursor: pointer; font-size: 16px; }
        button:hover { background: #2980b9; }
        .error { color: red; text-align: center; margin: 10px 0; }
        .back-link { text-align: center; margin-top: 15px; }
        .back-link a { color: #3498db; text-decoration: none; }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Seller Login</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required value="<?php echo htmlspecialchars($username ?? ''); ?>">
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div class="back-link">
            <a href="index.html">← Back to Home</a>
        </div>
    </div>
</body>
</html>