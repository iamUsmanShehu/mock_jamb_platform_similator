<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$student_id = $_SESSION['user_id'];
$subject_id = $_POST['subject_id'];

$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
$questions = $conn->query("SELECT * FROM questions WHERE subject_id='$subject_id'");

$score = 0;
$total = $questions->num_rows;

// Loop through the questions and check answers
while ($row = $questions->fetch_assoc()) {
    $question_id = $row['id'];
    $correct_answer = $row['answer'];

    // Check if the student's answer is correct
    if (isset($_POST["question_$question_id"]) && $_POST["question_$question_id"] == $correct_answer) {
        $score++;

        // Insert individual question result into the `results` table
        $sql = "INSERT INTO results (user_id, subject_id, question_id, score) VALUES ('$student_id', '$subject_id', '$question_id', 1)";
    } else {
        // Insert incorrect answer into `results`
        $sql = "INSERT INTO results (user_id, subject_id, question_id, score) VALUES ('$student_id', '$subject_id', '$question_id', 0)";
    }

    // Execute the query to save each question's result
    $conn->query($sql);
}

// Redirect to dashboard with results
header("Location: view_results.php?subject_id=$subject_id");
?>
