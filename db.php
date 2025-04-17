<?php
header("Access-Control-Allow-Origin: *"); // Allow requests from any origin (for testing)
header("Content-Type: application/json");

$servername = "localhost";
$username = "root"; // Default XAMPP username
$password = ""; // Default XAMPP password
$dbname = "PlantPal";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['action'])) {
if ($data['action'] === 'signup') {
// Signup logic
$name = $data['name'];
$email = $data['email'];
$password = password_hash($data['password'], PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $password);

if ($stmt->execute()) {
echo json_encode(["success" => true, "message" => "Registration successful"]);
} else {
echo json_encode(["success" => false, "message" => "Email already exists"]);
}
$stmt->close();
}
elseif ($data['action'] === 'login') {
// Login logic
$email = $data['email'];
$password = $data['password'];

$stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
$user = $result->fetch_assoc();
if (password_verify($password, $user['password'])) {
unset($user['password']); // Remove password before sending back
echo json_encode(["success" => true, "user" => $user]);
} else {
echo json_encode(["success" => false, "message" => "Incorrect password"]);
}
} else {
echo json_encode(["success" => false, "message" => "User not found"]);
}
$stmt->close();
}
}
}

$conn->close();
?>