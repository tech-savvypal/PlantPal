<?php
session_start();

$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'plantpal';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  http_response_code(401); // Unauthorized
  echo json_encode(['error' => 'User not logged in']);
  exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT id, title, start, end FROM calendar_events WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$result = $stmt->get_result();
$events = [];

while ($row = $result->fetch_assoc()) {
  $events[] = [
    'id' => $row['id'],
    'title' => $row['title'],
    'start' => $row['start'],
    'end' => $row['end']
  ];
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($events);
?>
