<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['payment_status']) {
    header("Location: login.php");
    exit();
}
$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
$categories = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
</head>
<body>
    <h2>Welcome to Your Dashboard</h2>

    <form action="take_test.php" method="GET">
        <label for="category_id">Select Category:</label>
        <select name="category_id">
            <?php while ($row = $categories->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
            <?php } ?>
        </select>
        <br>
        <label for="subject_id">Select Subject:</label>
        <select name="subject_id">
            <!-- You can use JavaScript to dynamically load subjects based on category selection -->
        </select>
        <br>
        <button type="submit">Start Test</button>
    </form>
</body>
</html>
