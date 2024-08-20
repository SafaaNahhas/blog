<?php
// Include the necessary files
include_once 'Database.php';
include_once 'Post.php';

// Instantiate the Database and get a connection
$database = new Database();
$db = $database->getConnection();

// Instantiate a Post object
$post = new Post($db);

// Check if a valid post ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Attempt to delete the post with the given ID
    if ($post->delete($id)) {
        // Redirect to the list of posts if deletion is successful
        header("Location: list_posts.php");
        exit;
    } else {
        // Display an error if deletion fails
        echo "Failed to delete post.";
    }
} else {
    // Display an error if the post ID is invalid
    echo "Invalid post ID!";
}
?>
