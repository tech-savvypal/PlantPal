<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'plantpal';

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
  echo json_encode(['success' => false, 'error' => 'Database connection failed']);
  exit();
}

// Get the JSON input
$data = json_decode(file_get_contents("php://input"), true);

$title = $data['title'];
$start = $data['start'];
$end = $data['end'];

$sql = "INSERT INTO calendar_events (title, start, end) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $title, $start, $end);

if ($stmt->execute()) {
  echo json_encode(['success' => true]);
} else {
  echo json_encode(['success' => false, 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>