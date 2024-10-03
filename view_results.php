<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$subject_id = $_GET['subject_id'];

$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
$result = $conn->query("SELECT * FROM results WHERE student_id='$student_id' AND subject_id='$subject_id'")->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Results</title>
</head>
<body>
    <h2>Your Results</h2>
    <p>Subject ID: <?php echo $subject_id; ?></p>
    <p>Your Score: <?php echo $result['score']; ?> out of <?php echo $total; ?></p>
    <a href="student_dashboard.php">Back to Dashboard</a>
</body>
</html>
