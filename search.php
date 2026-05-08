<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Car Search</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>

<div class="search-box">
    <h1>Search for Cars</h1>
    <form method="GET" action="search.php">
        <input type="text" name="model" placeholder="Car Model (e.g. BMW)">
        <input type="text" name="colour" placeholder="Colour (e.g. Black)">
        <button type="submit">SEARCH</button>
    </form>
</div>

<div class="result-box">
<?php
if (isset($_GET['model']) || isset($_GET['colour'])) {
    $model = $_GET['model'] ?? '';
    $colour = $_GET['colour'] ?? '';

    $sql = "SELECT * FROM cars WHERE 1=1";
    if (!empty($model)) $sql .= " AND model LIKE '%$model%'";
    if (!empty($colour)) $sql .= " AND colour LIKE '%$colour%'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='car-item'>";
            echo "<h3>".$row['colour']." ".$row['model']."</h3>";
            echo "<p>Price: $".$row['price']."</p>";
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