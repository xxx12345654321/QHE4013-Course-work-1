<?php
session_start();

if (!isset($_SESSION['seller_id'])) {
    header('HTTP/1.1 401 Unauthorized');
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Not authorized. Please login.']);
    exit();
}
?>