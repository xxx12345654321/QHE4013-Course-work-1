<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Search</title>
    <style>
        .car-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            margin: 15px;
            display: inline-block;
            width: 250px;
            text-align: center;
        }
        .car-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <form method="GET" action="search.php">
        <input type="text" name="model" placeholder="Car Model (e.g. BMW)">
        <input type="text" name="colour" placeholder="Colour (e.g. White)">
        <button type="submit">SEARCH</button>
    </form>

    <div>
        <?php
        // check connection
        if (!$conn) {
            echo "<p>数据库连接失败！</p>";
            exit;
        }

        // only execute query if user has submitted search
        if (isset($_GET['model']) || isset($_GET['colour'])) {
            $model = trim($_GET['model'] ?? '');
            $colour = trim($_GET['colour'] ?? '');

            $sql = "SELECT * FROM cars WHERE 1=1";
            if (!empty($model)) {
                $sql .= " AND model LIKE '%$model%'";
            }
            if (!empty($colour)) {
                $sql .= " AND colour LIKE '%$colour%'";
            }

            $result = mysqli_query($conn, $sql);

            if (!$result) {
                echo "<p>查询出错：" . mysqli_error($conn) . "</p>";
                exit;
            }

            if (mysqli_num_rows($result) > 0) {
                while ($car = mysqli_fetch_assoc($result)) {
                    echo "<div class='car-card'>";
                    echo "<img src='images/{$car['car_image']}' alt='{$car['model']}'>";
                    echo "<h3>{$car['colour']} {$car['model']}</h3>";
                    echo "<p>Price: $" . number_format($car['price'], 0) . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No cars found.</p>";
            }
        }
        ?>
    </div>
</body>
</html>