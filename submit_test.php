<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['student_id'];
$subject_id = $_POST['subject_id'];

$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
$questions = $conn->query("SELECT * FROM questions WHERE subject_id='$subject_id'");

$score = 0;
$total = $questions->num_rows;

// Calculate score
while ($row = $questions->fetch_assoc()) {
    $question_id = $row['id'];
    $correct_answer = $row['answer'];
    
    if (isset($_POST["question_$question_id"]) && $_POST["question_$question_id"] == $correct_answer) {
        $score++;
    }
}

// Save results
$sql = "INSERT INTO results (student_id, subject_id, score) VALUES ('$student_id', '$subject_id', '$score')";
$conn->query($sql);

// Redirect to dashboard with results
header("Location: view_results.php?subject_id=$subject_id");
?>
