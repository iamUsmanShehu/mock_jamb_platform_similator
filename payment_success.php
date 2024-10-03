<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$reference = $_GET['reference'];
$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Verify the payment using Paystack API (optional)

// Update payment status
$sql = "UPDATE users SET payment_status = 'Paid' WHERE id = '" . $_SESSION['user_id'] . "'";
if ($conn->query($sql) === TRUE) {
    echo "Payment successful!";
    $_SESSION['payment_status'] = "Paid";
    header("Location: student_dashboard.php");
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();
?>
