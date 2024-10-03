<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch categories from the database
$category_query = "SELECT id, name FROM categories";
$category_result = $conn->query($category_query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $subject_name = $conn->real_escape_string($_POST['subject_name']);
    $category_id = $conn->real_escape_string($_POST['category_id']);

    // Insert subject with category into database
    $sql = "INSERT INTO subjects (name, category_id) VALUES ('$subject_name', '$category_id')";
    if ($conn->query($sql) === TRUE) {
        echo "Subject added successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Subject</title>
</head>
<body>
    <h2>Add New Subject</h2>
    <form method="POST">
        <label for="subject_name">Subject Name:</label>
        <input type="text" name="subject_name" required>
        <br>

        <label for="category">Select Category:</label>
        <select name="category_id" required>
            <option value="">Select a Category</option>
            <?php
            // Populate the dropdown with categories
            if ($category_result->num_rows > 0) {
                while ($row = $category_result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }
            } else {
                echo "<option value=''>No Categories Available</option>";
            }
            ?>
        </select>
        <br>
        
        <button type="submit">Add Subject</button>
    </form>
</body>
</html>
