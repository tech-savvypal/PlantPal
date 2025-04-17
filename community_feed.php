<?php
$conn = new mysqli("localhost", "root", "", "plantpal");
$result = $conn->query("SELECT * FROM community_posts ORDER BY timestamp DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Community Feed</title>
</head>
<body>
  <h2>🪴 Community Feed</h2>
  <a href="community.html">+ New Post</a><br><br>

  <?php while ($row = $result->fetch_assoc()): ?>
    <div style="border:1px solid #ccc; padding:10px; margin-bottom:15px;">
      <h3><?= $row['title'] ?> <small>by <?= $row['username'] ?></small></h3>
      <p><?= nl2br($row['content']) ?></p>
      <?php if ($row['image']): ?>
        <img src="<?= $row['image'] ?>" width="200"><br>
      <?php endif; ?>
      <small>Posted on <?= $row['timestamp'] ?></small>
    </div>
  <?php endwhile; ?>
</body>
</html>