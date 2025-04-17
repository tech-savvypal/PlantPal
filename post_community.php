<?php
session_start();
$conn = new mysqli("localhost", "root", "", "plantpal");

$title = $_POST['title'];
$content = $_POST['content'];
$username = $_SESSION['username'] ?? 'Anonymous';  // fallback if not logged in

$imagePath = "";
if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $imageName = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $imageName);
    $imagePath = "uploads/" . $imageName;
}

$sql = "INSERT INTO community_posts (username, title, content, image) 
        VALUES ('$username', '$title', '$content', '$imagePath')";

if ($conn->query($sql)) {
    header("Location: community_feed.php");
} else {
    echo "Error: " . $conn->error;
}
?>