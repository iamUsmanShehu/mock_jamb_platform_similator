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

echo "<h2>Manage Students</h2>";
echo "<table border='1'>
<tr>
    <th>Student ID</th>
    <th>User Name</th>
    <th>Email</th>
    <th>Payment Status</th>
    <th>Action</th>
</tr>";

while ($row = $students->fetch_assoc()) {
    echo "<tr>
        <td>" . $row['id'] . "</td>
        <td>" . $row['username'] . "</td>
        <td>" . $row['email'] . "</td>
        <td>" . ($row['payment_status'] ? 'Paid' : 'Pending') . "</td>
        <td><a href='update_payment.php?id=" . $row['id'] . "'>Update Payment Status</a></td>
    </tr>";
}
echo "</table>";

$conn->close();
?>
