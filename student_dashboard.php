<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['payment_status'] != 'Paid') {
    header("Location: login.php");
    exit();
}
$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');

// Fetch categories
$categories = $conn->query("SELECT * FROM categories");



$user_id = $_SESSION['user_id']; 

$sql = "
    SELECT 
        s.category_id AS subject_category, 
        s.name AS subject_name, 
        SUM(r.score) AS total_score,
        s.id AS subject_id
    FROM 
        results r
    JOIN 
        subjects s ON r.subject_id = s.id
    WHERE 
        r.user_id = $user_id
    GROUP BY 
        s.category_id
    ORDER BY 
        s.category_id;
";

// Execute the query
$result = $conn->query($sql);

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
              <div class="charts__left__title">
                <div>
                  <h1>Test Training</h1>
                  <p>Select and Test Your Knowledge based on spacific subject available</p><br>
                </div>
              </div>
              <!-- <div id="apex1"></div> -->
              <form action="take_test.php" method="GET">
                <!-- Category Dropdown -->
                <label for="category_id">Select Category:</label>
                <select name="category_id" id="category_id" required class="form-control">
                    <option value="">Select Category</option>
                    <?php while ($row = $categories->fetch_assoc()) { ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select>
                <br>

                <!-- Subject Dropdown -->
                <label for="subject_id">Select Subject:</label>
                <select name="subject_id" id="subject_id" required class="form-control">
                    <option value="">Select Subject</option>
                </select>
                <br>

                <button type="submit" class="form-control">Start Test</button>
            </form>

            </div>

            <div class="charts__right">
              <div class="charts__right__title">
                 <div>
                  <h1>My Results</h1>
                  <p>Activities</p>
                </div>
              </div>

              <div class="charts__right__cards">


                <table style="width: 100%;">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Category</th>
                            <th>Total Score</th>
                            <th>View</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Check if results exist
                        if ($result->num_rows > 0) {
                            $sn = 1;  // Initialize serial number
                            // Output data of each row
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $sn . "</td>
                                        <td>" . $row['subject_name'] . "</td>
                                        <td>" . $row['total_score'] . "</td>
                                        <td>
                                            <form action='view_category.php' method='GET'>
                                                <input type='hidden' name='category_id' value='" . $row['subject_id'] . "' />
                                                <input type='submit' value='View' />
                                            </form>
                                        </td>
                                    </tr>";
                                $sn++;
                            }
                        } else {
                            echo "<tr><td colspan='4'>No results found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>

                <?php
                // Close connection
                $conn->close();
                ?>

              </div>
            </div>
          </div>
          <!-- CHARTS ENDS HERE -->
        </div>
      </main>

   <?php include 'sidebar_student.php';?>
    <script>
        // Fetch subjects based on selected category
        $(document).ready(function() {
            $('#category_id').change(function() {
                var categoryId = $(this).val();

                if (categoryId) {
                    $.ajax({
                        type: 'POST',
                        url: 'fetch_subjects.php',
                        data: {category_id: categoryId},
                        success: function(response) {
                            var subjects = JSON.parse(response);
                            var subjectOptions = '<option value="">Select Subject</option>';

                            // Populate the subjects dropdown
                            subjects.forEach(function(subject) {
                                subjectOptions += '<option value="' + subject.id + '">' + subject.name + '</option>';
                            });
                            $('#subject_id').html(subjectOptions);
                        }
                    });
                } else {
                    $('#subject_id').html('<option value="">Select Subject</option>');
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="script.js"></script>
  </body>
</html>
