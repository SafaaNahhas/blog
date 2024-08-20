<?php
// Include necessary files for database connection and Post class
include_once 'Database.php';
include_once 'Post.php';

// Instantiate the Database and establish a connection
$database = new Database();
$db = $database->getConnection();

// Instantiate a Post object with the database connection
$post = new Post($db);

// Check if a valid post ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Attempt to retrieve the post data for the given ID
    if ($post->read($id)) {
        // If the post is found, display it
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>View Post</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="container">
                <h1><?php echo htmlspecialchars($post->title); ?></h1>
                <p><?php echo nl2br(htmlspecialchars($post->content)); ?></p>
                <p><strong>Author:</strong> <?php echo htmlspecialchars($post->author); ?></p>
                <p><strong>Created At:</strong> <?php echo htmlspecialchars($post->created_at); ?></p>
                <a href="list_posts.php">Back to List</a>
            </div>
        </body>
        </html>
        <?php
    } else {
        // Display a message if the post is not found
        echo "Post not found!";
    }
} else {
    // Display a message if the provided post ID is invalid
    echo "Invalid post ID!";
}
?>
