<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create a Post</title>
    <style>
        body { font-family: Arial; background: #f4f4f4; padding: 20px; }
        form { background: white; padding: 20px; border-radius: 10px; max-width: 600px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        input, textarea, select { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px 20px; background-color: #4CAF50; color: white; border: none; }
    </style>
</head>
<body>

<h2 style="text-align:center;">Share a Post with the Community 🌿</h2>

<form action="insert_post.php" method="POST">
    <input type="text" name="title" placeholder="Post Title" required>
    <textarea name="content" rows="5" placeholder="Share your thoughts..." required></textarea>
    <select name="category" required>
        <option value="">-- Select Category --</option>
        <option value="Tip">🌱 Tip</option>
        <option value="Swap">🔁 Swap</option>
        <option value="Progress">📈 Progress</option>
    </select>
    <button type="submit">Post</button>
</form>

</body>
</html>