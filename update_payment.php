<?php
// Start the session
session_start();

// Check if the admin is logged in (you can modify this to fit your login system)
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if the student ID is provided in the URL
if (isset($_GET['id'])) {
    // Get the student ID from the URL
    $student_id = $_GET['id'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the student's payment status to 'Paid'
    $sql = "UPDATE users SET payment_status = 'Paid' WHERE id = $student_id";

    if ($conn->query($sql) === TRUE) {
        echo "Payment status updated successfully.";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "No student ID provided.";
}
?>
