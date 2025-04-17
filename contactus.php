<?php
// Connect to 'plantpal' database
$conn = new mysqli("localhost", "root", "", "plantpal");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data safely
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$number = $_POST['number'] ?? '';
$date = $_POST['date'] ?? '';
$address = $_POST['address'] ?? '';
$plan = $_POST['plan'] ?? '';
$message = $_POST['message'] ?? '';

// Prepare SQL
$sql = "INSERT INTO bookings (name, email, number, date, address, plan, message) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $name, $email, $number, $date, $address, $plan, $message);

if ($stmt->execute()) {
    echo "<script>alert('Booking saved to plantpal!'); window.location.href='index.html';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
