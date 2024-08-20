<?php
// Include the necessary files
include_once 'Database.php';
include_once 'Post.php';

// Instantiate the Database and get a connection
$database = new Database();
$db = $database->getConnection();

// Instantiate a Post object
$post = new Post($db);

$error = ""; // Initialize an empty error message

// Check if the form is submitted via POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Trim whitespace from the form inputs
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $author = trim($_POST['author']);

    // Validate the inputs using Validation trait in Post class
    $error = Post::validateTitle($title, $db) ?: 
            Post::validateContent($content) ?: 
            Post::validateAuthor($author);

    // If there's no validation error, proceed to create the post
    if ($error === null) {
        $post->title = $title;
        $post->content = $content;
        $post->author = $author;

        // Attempt to create the post and redirect on success
        if ($post->create()) {
            header("Location: list_posts.php");
            exit;
        } else {
            $error = "Failed to create post.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Create New Post</h1>
        
        <!-- Display any validation or creation error -->
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

        <!-- Form for creating a new post -->
        <form action="create_post.php" method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" required><br><br>
            
            <label for="content">Content:</label>
            <textarea name="content"   
            rows="10" cols="30" required></textarea><br><br>
            
            <label for="author">Author:</label>
            <input type="text" name="author" required><br><br>
            
            <button type="submit">Create Post</button>
        </form>
    </div>
</body>
</html>
