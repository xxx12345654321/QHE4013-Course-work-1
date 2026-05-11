<?php
session_start();

if (!isset($_SESSION['seller_id'])) {
    header('Location: test_login.php');
    exit();
}

require_once dirname(__FILE__) . '/config/database.php';

$seller_id = $_SESSION['seller_id'];
$make = $_POST['make'] ?? '';
$model = $_POST['model'] ?? '';
$year = (int)($_POST['year'] ?? 0);
$price = (float)($_POST['price'] ?? 0.00);
$description = $_POST['description'] ?? '';

$errors = [];

if (empty($make)) {
    $errors[] = "Car brand (make) is required.";
}
if (empty($model)) {
    $errors[] = "Car model is required.";
}
if ($year < 1990 || $year > 2026) {
    $errors[] = "Please enter a valid year between 1990 and 2026.";
}
if ($price <= 0) {
    $errors[] = "Price must be greater than 0.";
}

if (!empty($errors)) {
    echo json_encode(['success' => false, 'errors' => $errors]);
    exit();
}

$image_path = NULL;

if (isset($_FILES['car_image']) && $_FILES['car_image']['error'] == 0) {
    $file_name = $_FILES['car_image']['name'];
    $file_tmp = $_FILES['car_image']['tmp_name'];
    $file_size = $_FILES['car_image']['size'];

    $allowed_types = ['image/jpeg', 'image/png', 'image/webp', 'image/jpg'];
    $file_type = mime_content_type($file_tmp);

    if (!in_array($file_type, $allowed_types)) {
        echo json_encode(['success' => false, 'errors' => ['Invalid file type. Please upload JPG, PNG, or WebP images.']]);
        exit();
    }

    if ($file_size > 5 * 1024 * 1024) {
        echo json_encode(['success' => false, 'errors' => ['File size must be less than 5MB.']]);
        exit();
    }

    $upload_dir = dirname(__FILE__) . '/uploads/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $new_file_name = 'car_' . $seller_id . '_' . time() . '.' . $file_ext;
    $destination = $upload_dir . $new_file_name;

    if (move_uploaded_file($file_tmp, $destination)) {
        $image_path = 'uploads/' . $new_file_name;
    }
}

try {
    $sql = "INSERT INTO cars (seller_id, make, model, year, price, description, car_image)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        throw new Exception("Failed to prepare SQL statement: " . $conn->error);
    }

    $stmt->bind_param("issiiss",
        $seller_id,
        $make,
        $model,
        $year,
        $price,
        $description,
        $image_path
    );

    if ($stmt->execute()) {
        $car_id = $stmt->insert_id;
        echo json_encode([
            'success' => true,
            'car_id' => $car_id,
            'message' => 'Car added successfully!'
        ]);
    } else {
        throw new Exception("Failed to execute SQL: " . $stmt->error);
    }

    $stmt->close();

} catch (Exception $e) {
    echo json_encode(['success' => false, 'errors' => [$e->getMessage()]]);
}

$conn->close();
?>