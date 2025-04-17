<?php
include 'db.php';

$title = $_POST['title'];
$content = $_POST['content'];
$category = $_POST['category'];

$sql = "INSERT INTO posts (title, content, category) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $title, $content, $category);

if ($stmt->execute()) {
    echo "<script>alert('Post shared successfully!'); window.location.href='community.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>