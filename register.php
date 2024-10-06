<?php
// Start the session
session_start();

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get form inputs and escape them to prevent SQL injection
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $conn->real_escape_string($_POST['password']);

    // Check if the username or email already exists
    $checkUserQuery = "SELECT * FROM users WHERE username='$username' OR email='$email'";
    $result = $conn->query($checkUserQuery);
    
    if ($result->num_rows > 0) {
        $message = "<span style='color:red;'>Username or email already exists. Please try a different one.</span>";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new student into the users table with role 'Student' and default payment_status 'Unpaid'
        $sql = "INSERT INTO users (username, email, password, role, payment_status) 
                VALUES ('$username', '$email', '$hashed_password', 'Student', 'Unpaid')";

        if ($conn->query($sql) === TRUE) {
            $message = "<span style='color:red;'>Registration successful! You can now <a href='login.php'>login</a>.</span>";
        } else {
            $message = "<span style='color:red;'>Error: " . $sql . "<br>" . $conn->error . '</span>';
        }
    }

    // Close the connection
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>MOCK JAMB</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
<style type="text/css">
  .service-item img{width: 100%!important;}
</style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">MOCK JAMB</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html" class="active">Home<br></a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#class">Classes</a></li>
          <li><a href="#footer">Contact</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <img src="assets/img/hero-bg.jpeg" alt="" data-aos="fade-in">

      <div class="container">
        <div class="row">
          <div class="col-xl-4">
            <h1 data-aos="fade-up">Student Registration</h1><hr>
            <?php if (isset($message)) { echo $message;}?>
            <form method="POST">
                <label for="username">Username:</label>
                <input type="text" name="username" required class="form-control">
                <br>
                <label for="email">Email:</label>
                <input type="email" name="email" required class="form-control">
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" required class="form-control">
                <br>
            <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                <button type="submit" class="btn-get-started"><i class="bi bi-person-plus"> </i>Register</button>
            </div>
            </form>
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->



  </main>

<footer id="footer" class="footer light-background">

</footer>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>