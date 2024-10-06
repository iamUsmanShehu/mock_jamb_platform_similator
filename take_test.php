<?php
session_start();
if (!isset($_SESSION['user_id']) || !$_SESSION['payment_status']) {
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
    
</body>
</html>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
      integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="styles.css" />
    <title>MOCK JAMB</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style type="text/css">
        .form-control{
            padding: 16px 32px;
            width: 90%;
            margin-bottom: 15px;
            border: 1px solid #eee;
        }
        .finish_btn{
            margin-top: 15px;
            background: green;
            padding: 16px 32px;
            border-radius: 32px;
            color:white;
        }
    </style>
  </head>
  <body id="body">
    <div class="container">
    <?php include 'navbar_student.php';?>

      <main>
        <div class="main__container">
          <!-- MAIN TITLE STARTS HERE -->

          <div class="main__title">
            <div class="main__greeting">
              <h1>Student Dashboard</h1>
              <p>Welcome <?=$_SESSION['username']?></p>
            </div>
          </div>

          <!-- MAIN TITLE ENDS HERE -->

         
          <!-- CHARTS STARTS HERE -->
        <div class="charts">
            <div class="charts__left">
              <div class="charts__left__title">
                <div>
                  <h1><div id="timer"></div></h1>
                </div>
              </div>
                

                <form id="test_form" action="submit_test.php" method="POST">
                    <?php while ($row = $questions->fetch_assoc()) { ?>
                        <p><?php echo $row['question_text']; ?></p>
                        <input type="radio" name="question_<?php echo $row['id']; ?>" value="A"> A<br>
                        <input type="radio" name="question_<?php echo $row['id']; ?>" value="B"> B<br>
                        <input type="radio" name="question_<?php echo $row['id']; ?>" value="C"> C<br>
                        <input type="radio" name="question_<?php echo $row['id']; ?>" value="D"> D<br>
                    <?php } ?>
                    <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>">
                    <br><hr>
                    <button type="submit" class="finish_btn">Finish</button>
                </form>

            </div>

            
          </div>
          <!-- CHARTS ENDS HERE -->
        </div>
      </main>

   <?php include 'sidebar_student.php';?>
    
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
  </body>
</html>
