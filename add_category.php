<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $category_name = $conn->real_escape_string($_POST['category_name']);

    // Insert category into database
    $sql = "INSERT INTO categories (name) VALUES ('$category_name')";
    if ($conn->query($sql) === TRUE) {
        echo "Category added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
</head>
<body>
    <h2>Add New Category</h2>
    <form method="POST">
        <label for="category_name">Category Name:</label>
        <input type="text" name="category_name" required>
        <br>
        <button type="submit">Add Category</button>
    </form>
</body>
</html>
