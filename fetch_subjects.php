<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'mock_jamb_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$category = $_POST['category'];

// Fetch subjects based on the selected category
$query = "SELECT * FROM subjects WHERE category = '$category'";
$result = $conn->query($query);

$subjects = array();
while ($row = $result->fetch_assoc()) {
    $subjects[] = $row;
}
echo json_encode($subjects);

$conn->close();
?>

