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
    <style type="text/css">
        .form-control{
            padding: 16px 32px;
            width: 90%;
            margin-bottom: 15px;
            border: 1px solid #eee;
        }
    </style>
  </head>
  <body id="body">
    <div class="container">
    <?php include 'navbar.php';?>

      <main>
        <div class="main__container">
          <!-- MAIN TITLE STARTS HERE -->

          <div class="main__title">
            <img src="<?=$_SESSION['image']?>" alt="" />
            <div class="main__greeting">
              <h1>Admin Dashboard</h1>
              <p>Welcome <?=$_SESSION['username']?></p>
            </div>
          </div>

          <!-- MAIN TITLE ENDS HERE -->

          
          <!-- CHARTS STARTS HERE -->
        <div class="charts">
            <div class="charts__left">
              <div class="charts__left__title">
                <div>
                  <h1>Add New Question</h1><br>
                </div>
                <!-- <i class="fa fa-usd" aria-hidden="true"></i> -->
              </div>
              <div id="apex1"></div>
                <form method="POST">
                    <label for="category_id">Category:</label>
                    <select name="category_id" class="form-control">
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
                    <select name="subject_id" class="form-control">
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
                    <textarea name="question_text" required class="form-control"></textarea>
                    <br>
                    <label for="answer">Answer:</label>
                    <input type="text" name="answer" required class="form-control">
                    <br>
                    <button type="submit" class="form-control">Add Question</button>
                </form>
            </div>

            <div class="charts__right">
              <div class="charts__right__title">
                <div>
                  <h1>Stats Reports</h1>
                  <p>Cupertino, California, USA</p>
                </div>
                <i class="fa fa-usd" aria-hidden="true"></i>
              </div>

              <div class="charts__right__cards">
                <div class="card1">
                  <h1>Income</h1>
                  <p>$75,300</p>
                </div>

                <div class="card2">
                  <h1>Sales</h1>
                  <p>$124,200</p>
                </div>

                <div class="card3">
                  <h1>Users</h1>
                  <p>3900</p>
                </div>

                <div class="card4">
                  <h1>Orders</h1>
                  <p>1881</p>
                </div>
              </div>
            </div>
          </div>
          <!-- CHARTS ENDS HERE -->
        </div>
      </main>

   <?php include 'sidebar.php';?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
  </body>
</html>
