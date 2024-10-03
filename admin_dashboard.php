<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

echo "Welcome, " . $_SESSION['username'] . "!";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Admin Dashboard</h2>
    <a href="add_subject.php">Add Subject</a> | 
    <a href="add_category.php">Add Category</a> | 
    <a href="add_question.php">Add Question</a> |
    <a href="manage_students.php">Manage Students</a>
</body>
</html>
