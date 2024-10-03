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

    $category_id = $conn->real_escape_string($_POST['category_id']);
    $subject_id = $conn->real_escape_string($_POST['subject_id']);
    $question_text = $conn->real_escape_string($_POST['question_text']);
    $answer = $conn->real_escape_string($_POST['answer']);

    // Insert question into database
    $sql = "INSERT INTO questions (category_id, subject_id, question_text, answer) VALUES ('$category_id', '$subject_id', '$question_text', '$answer')";
    if ($conn->query($sql) === TRUE) {
        echo "Question added successfully.";
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
    <title>Add Question</title>
</head>
<body>
    <h2>Add New Question</h2>
    <form method="POST">
        <label for="category_id">Category:</label>
        <select name="category_id">
            <!-- Fetch categories dynamically -->
            <?php
            $conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
            $categories = $conn->query("SELECT * FROM categories");
            while ($row = $categories->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="subject_id">Subject:</label>
        <select name="subject_id">
            <!-- Fetch subjects dynamically -->
            <?php
            $subjects = $conn->query("SELECT * FROM subjects");
            while ($row = $subjects->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select>
        <br>
        <label for="question_text">Question Text:</label>
        <textarea name="question_text" required></textarea>
        <br>
        <label for="answer">Answer:</label>
        <input type="text" name="answer" required>
        <br>
        <button type="submit">Add Question</button>
    </form>
</body>
</html>
