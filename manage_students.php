<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch students
$students = $conn->query("SELECT * FROM users WHERE role = 'Student'");

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
        table{border: 1px solid #eee;}
        .charts {
            display: flex;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 50px;
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
            <div class="charts__left"style='width: 100%!important;'>
              <div class="charts__left__title">
                <div>
                  <h1>Manage Students payment</h1><br>
                </div>
              </div>
                <?php 
                    echo "<table border='1'>
                    <tr>
                        <th>S/N</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>";
                    $i = 1;
                    while ($row = $students->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $i++ . "</td>
                            <td>" . $row['username'] . "</td>
                            <td>" . $row['email'] . "</td>
                            <td>" . ($row['payment_status'] ? 'Paid' : 'Pending') . "</td>
                            <td><a href='update_payment.php?id=" . $row['id'] . "'>Update Payment Status</a></td>
                        </tr>";
                    }
                    echo "</table>";

                    $conn->close();

                ?>
            
              </div>
              <!-- <div id="apex1"></div> -->

                </div>

           
          <!-- CHARTS ENDS HERE -->
        </div>
      </main>

   <?php include 'sidebar.php';?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
  </body>
</html>
