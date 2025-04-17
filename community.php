<?php
$conn = new mysqli("localhost", "root", "", "plantpal");
if ($conn->connect_error) die("DB error: " . $conn->connect_error);

// Hardcoded user
$user_id = 1;

// Handle new post
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!empty($_POST["content"]) && isset($_POST["is_post"])) {
        $content = $conn->real_escape_string($_POST["content"]);
        $category = $conn->real_escape_string($_POST["category"] ?? 'General');
        $conn->query("INSERT INTO posts (user_id, content, category) VALUES ($user_id, '$content', '$category')");
    }

    // Handle new comment
    if (!empty($_POST["comment"]) && isset($_POST["post_id"])) {
        $comment = $conn->real_escape_string($_POST["comment"]);
        $post_id = intval($_POST["post_id"]);
        $conn->query("INSERT INTO comments (post_id, user_id, content) VALUES ($post_id, $user_id, '$comment')");
    }
}

// Handle likes
if (isset($_POST['like_post_id'])) {
    $post_id = intval($_POST['like_post_id']);
    $conn->query("INSERT INTO likes (user_id, post_id) VALUES ($user_id, $post_id)");
}

// Handle follows
if (isset($_POST['follow_user_id'])) {
    $followed_id = intval($_POST['follow_user_id']);
    $check = $conn->query("SELECT * FROM follows WHERE follower_id = $user_id AND followed_id = $followed_id");
    if ($check->num_rows == 0 && $user_id != $followed_id) {
        $conn->query("INSERT INTO follows (follower_id, followed_id) VALUES ($user_id, $followed_id)");
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PlantPal Community</title>
    <style>
        body { font-family: Arial; background: #f7f0ed; padding: 20px; position: relative; }
        h1 { text-align: center; color: #2e7d32; }

        .top-left {
            position: absolute;
            top: 20px;
            left: 20px;
        }

        .dashboard-btn {
            background-color: #0b3d0b;
            color: white;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            font-size: 14px;
            transition: background 0.3s;
        }

        .dashboard-btn:hover {
            background-color: #145c14;
        }

        .post-form textarea { width: 100%; height: 100px; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        .post-form select, .post-form button {
            padding: 10px;
            margin-top: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .post-form button {
            background: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .post {
            background: white;
            padding: 15px;
            margin-top: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .post strong { font-size: 18px; }
        .post em {
            display: inline-block;
            background-color: #dcedc8;
            color: #33691e;
            padding: 3px 8px;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 5px;
        }
        .post small { color: gray; display: block; margin-top: 8px; }
    </style>
</head>
<body>

<div class="top-left">
    <a href="welcome.html" class="dashboard-btn">← Back to Dashboard</a>
</div>

<h1>🌱 PlantPal Community</h1>

<div class="post-form">
    <!-- Post creation -->
    <form method="POST">
        <textarea name="content" placeholder="Share a tip, ask a question, post a swap..."></textarea><br>
        <select name="category">
            <option value="Tips">Tips</option>
            <option value="Swap">Plant Swap</option>
            <option value="Progress">Progress</option>
            <option value="Q&A">Q&A</option>
        </select><br>
        <input type="hidden" name="is_post" value="1">
        <button type="submit">Post</button>
    </form>
</div>

<?php
// Show posts
$posts = $conn->query("SELECT posts.*, users.name FROM posts JOIN users ON posts.user_id = users.id ORDER BY posts.created_at DESC");

while ($post = $posts->fetch_assoc()) {
    echo "<div class='post'>";
    echo "<strong>" . htmlspecialchars($post['name']) . "</strong><br>";
    echo "<em>" . htmlspecialchars($post['category']) . "</em><br>";
    echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";
    echo "<small>Posted on " . $post['created_at'] . "</small><br><br>";

    // Like feature
    $post_id = $post['id'];
    $like_result = $conn->query("SELECT COUNT(*) AS count FROM likes WHERE post_id = $post_id");
    $like_count = $like_result ? $like_result->fetch_assoc()['count'] : 0;

    echo "
        <form method='POST' style='display:inline;'>
            <input type='hidden' name='like_post_id' value='$post_id'>
            <button type='submit' style='background:#e0f7fa; border:none; padding:5px 10px; border-radius:5px; cursor:pointer;'>👍 Like ($like_count)</button>
        </form>
    ";

    // Show comments
    $comments = $conn->query("SELECT comments.*, users.name FROM comments JOIN users ON comments.user_id = users.id WHERE post_id = $post_id ORDER BY created_at ASC");
    echo "<div style='margin-left:20px; margin-top:10px;'>";
    while ($comment = $comments->fetch_assoc()) {
        echo "<p><strong>" . htmlspecialchars($comment['name']) . "</strong>: " . htmlspecialchars($comment['content']) . " <small>(" . $comment['created_at'] . ")</small></p>";
    }

    // Add comment form
    echo "
        <form method='POST' style='margin-top:10px;'>
            <input type='hidden' name='post_id' value='$post_id'>
            <input type='text' name='comment' placeholder='Write a comment...' required style='width:80%; padding:5px;'>
            <button type='submit' style='padding:5px;'>Comment</button>
        </form>
    </div>";

    echo "</div>";
}

$conn->close();
?>

</body>
</html>
