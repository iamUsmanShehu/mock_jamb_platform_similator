<?php
session_start();
if (!isset($_SESSION['student_id']) || !$_SESSION['payment_status']) {
    header("Location: login.php");
    exit();
}

$subject_id = $_GET['subject_id'];
$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
$questions = $conn->query("SELECT * FROM questions WHERE subject_id='$subject_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Test</title>
    <script>
        var timeLeft = 300; // Time in seconds (5 minutes)

        function countdown() {
            if (timeLeft <= 0) {
                document.getElementById("test_form").submit();
            } else {
                document.getElementById("timer").innerHTML = timeLeft + " seconds remaining";
                timeLeft--;
            }
        }

        setInterval(countdown, 1000);
    </script>
</head>
<body>
    <h2>Test</h2>
    <div id="timer"></div>

    <form id="test_form" action="submit_test.php" method="POST">
        <?php while ($row = $questions->fetch_assoc()) { ?>
            <p><?php echo $row['question_text']; ?></p>
            <input type="radio" name="question_<?php echo $row['id']; ?>" value="A"> A<br>
            <input type="radio" name="question_<?php echo $row['id']; ?>" value="B"> B<br>
            <input type="radio" name="question_<?php echo $row['id']; ?>" value="C"> C<br>
            <input type="radio" name="question_<?php echo $row['id']; ?>" value="D"> D<br>
        <?php } ?>
        <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
