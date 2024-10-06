<?php
session_start();  // Start session
$user_id = $_SESSION['user_id'];  // Get the user ID from session
$category_id = $_GET['category_id'];  // Get the category ID from the form

// Database connection
$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch results for the selected category
$sql = "
    SELECT 
        r.score, 
        q.question_text, 
        r.completed_at 
    FROM 
        results r
    JOIN 
        questions q ON r.question_id = q.id
    WHERE 
        r.user_id = $user_id 
    AND 
        r.subject_id = $category_id;
";

// Execute the query
$result = $conn->query($sql);

// Display the detailed results for the selected category
?>



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
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .charts {
    display: flex;
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

         

          <!-- CHARTS STARTS HERE -->
        <div class="charts">
            <div class="charts__left">
              <div class="charts">
                <div>
                  <h1>Test Training Result</h1>
                  <p>Select and Test Your Knowledge based on spacific subject available</p><br>
                </div>
            
                <table>
                <thead>
                    <tr>
                        <th>Score</th>
                        <th>Question</th>
                        <th>Completed At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row['score'] . "</td>
                                    <td>" . $row['question_text'] . "</td>
                                    <td>" . $row['completed_at'] . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No details found for this category</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

              </div>
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
