<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$subject_id = $_GET['subject_id'];

// Database connection
$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the total score for the user in the subject
$total_score_query = $conn->query("SELECT SUM(score) AS total_score FROM results WHERE user_id='$user_id' AND subject_id='$subject_id'");
$total_score_row = $total_score_query->fetch_assoc();
$total_score = $total_score_row['total_score'];

// Fetch the latest result for the subject (optional, if you want to show the last attempt)
$result = $conn->query("SELECT * FROM results WHERE user_id='$user_id' AND subject_id='$subject_id' ORDER BY completed_at DESC LIMIT 1")->fetch_assoc();
$score = $result['score']; // Get the score saved in the latest results table

// Fetch total number of questions for the subject
$total_questions_query = $conn->query("SELECT COUNT(*) AS total FROM questions WHERE subject_id='$subject_id'");
$total_row = $total_questions_query->fetch_assoc();
$total_questions = $total_row['total'];

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
    <!-- <p>Your Latest Score: <?php echo $score; ?> out of <?php echo $total_questions; ?></p> -->
    <p>Total Score for all attempts: <?php echo $total_score ? $total_score : 0; ?></p> <!-- Display total score -->
    <a href="student_dashboard.php">Back to Dashboard</a>
</body>
</html>
