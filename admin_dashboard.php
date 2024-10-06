<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

           // $username = $_SESSION['username'];
           // $email = $_SESSION['email'];
           // $image = $_SESSION['image'];

  $total_categories_id = "SELECT COUNT(id) AS 'Total' FROM `categories`";
  $categories_id_stmt = $conn->prepare($total_categories_id);
  $categories_id_stmt->execute();
  $categories_id_result = $categories_id_stmt->get_result();
  
  if ($categories_id_result->num_rows > 0) {
      $total = $categories_id_result->fetch_assoc();
      $categories_id_total = $total['Total'];
  }

  $total_subjects_id = "SELECT COUNT(id) AS 'Total' FROM `subjects`";
  $subjects_id_stmt = $conn->prepare($total_subjects_id);
  $subjects_id_stmt->execute();
  $subjects_id_result = $subjects_id_stmt->get_result();
  
  if ($subjects_id_result->num_rows > 0) {
      $total = $subjects_id_result->fetch_assoc();
      $subjects_id_total = $total['Total'];
  }


  $total_questions_id = "SELECT COUNT(id) AS 'Total' FROM `questions`";
  $questions_id_stmt = $conn->prepare($total_questions_id);
  $questions_id_stmt->execute();
  $questions_id_result = $questions_id_stmt->get_result();
  
  if ($questions_id_result->num_rows > 0) {
      $total = $questions_id_result->fetch_assoc();
      $questions_id_total = $total['Total'];
  }


  $total_users_id = "SELECT COUNT(id) AS 'Total' FROM `users` WHERE role = 'Student'";
  $users_id_stmt = $conn->prepare($total_users_id);
  $users_id_stmt->execute();
  $users_id_result = $users_id_stmt->get_result();
  
  if ($users_id_result->num_rows > 0) {
      $total = $users_id_result->fetch_assoc();
      $users_id_total = $total['Total'];
  }

 $total_pay_id = "SELECT COUNT(id) AS 'Total' FROM `users` WHERE role = 'Student' AND payment_status = 'Paid'";
  $pay_id_stmt = $conn->prepare($total_pay_id);
  $pay_id_stmt->execute();
  $pay_id_result = $pay_id_stmt->get_result();
  
  if ($pay_id_result->num_rows > 0) {
      $total = $pay_id_result->fetch_assoc();
      $pay_id_total = $total['Total'];
  }

  $total_unpay_id = "SELECT COUNT(id) AS 'Total' FROM `users` WHERE role = 'Student' AND payment_status = 'Unpaid'";
  $unpay_id_stmt = $conn->prepare($total_unpay_id);
  $unpay_id_stmt->execute();
  $unpay_id_result = $unpay_id_stmt->get_result();
  
  if ($unpay_id_result->num_rows > 0) {
      $total = $unpay_id_result->fetch_assoc();
      $unpay_id_total = $total['Total'];
  }

$unpay_id_total = number_format($unpay_id_total, 2);
  $income = 10000 * $pay_id_total;
  $income = number_format($income, 2); 
// Fetch students
$students = $conn->query("SELECT * FROM users WHERE role = 'Student' AND payment_status = 'Paid'");
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

          <!-- MAIN CARDS STARTS HERE -->
          <div class="main__cards">
            <div class="card">
              <i
                class="fa fa-user-o fa-2x text-lightblue"
                aria-hidden="true"
              ></i>
              <div class="card_inner">
                <p class="text-primary-p">Total Categories</p>
                <span class="font-bold text-title"><?=$categories_id_total?></span>
              </div>
            </div>

            <div class="card">
              <i class="fa fa-calendar fa-2x text-red" aria-hidden="true"></i>
              <div class="card_inner">
                <p class="text-primary-p">Total Subjects</p>
                <span class="font-bold text-title"><?=$subjects_id_total?></span>
              </div>
            </div>

            <div class="card">
              <i
                class="fa fa-video-camera fa-2x text-yellow"
                aria-hidden="true"
              ></i>
              <div class="card_inner">
                <p class="text-primary-p">Total Questions</p>
                <span class="font-bold text-title"><?=$questions_id_total?></span>
              </div>
            </div>

            <div class="card">
              <i
                class="fa fa-thumbs-up fa-2x text-green"
                aria-hidden="true"
              ></i>
              <div class="card_inner">
                <p class="text-primary-p">Total Students</p>
                <span class="font-bold text-title"><?=$users_id_total?></span>
              </div>
            </div>
          </div>
          <!-- MAIN CARDS ENDS HERE -->

          <!-- CHARTS STARTS HERE -->
        <div class="charts">
            <div class="charts__left">
              <div class="charts__left__title">
                <div>
                  <h1>Payments</h1>
                  <p>Recent Payments</p><br>
                </div>
              </div>
              <?php 
                    echo "<table border='1' style='width:100%;'>
                    <tr>
                        <th>S/N</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Payment Status</th>
                    </tr>";
                    $i = 1;
                    while ($row = $students->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $i++ . "</td>
                            <td>" . $row['username'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . ($row['payment_status'] ? 'Paid' : 'Pending') . "</td>
                        </tr>";
                    }
                    echo "</table>";

                    $conn->close();

                ?>
            </div>

            <div class="charts__right">
              <div class="charts__right__title">
                 <div>
                  <h1>Reports</h1>
                  <p>Mock Jamb Revenue Report</p>
                </div>
              </div>

              <div class="charts__right__cards">
                <div class="card1">
                  <h1>Income</h1>
                  <p>#<?=$income?></p>
                </div>

                <div class="card2">
                  <h1>Pending</h1>
                  <p>#<?=$unpay_id_total?></p>
                </div>

                <div class="card3">
                  <h1>Students</h1>
                  <p><?=$users_id_total?></p>
                </div>

                <div class="card4">
                  <h1>Paid Students</h1>
                  <p><?=$pay_id_total?></p>
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
