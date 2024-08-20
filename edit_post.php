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

// Check if a valid post ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the post data for the given ID
    if ($post->read($id)) {
        
        // Check if the form is submitted via POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Trim whitespace from the form inputs
            $title = trim($_POST['title']);
            $content = trim($_POST['content']);
            $author = trim($_POST['author']);

            // Validate the inputs using Validation trait in Post class
            $error = Post::validateContent($content) ?: 
                    Post::validateAuthor($author);

            // If there's no validation error, proceed to update the post
            if ($error === null) {
                // Check if title is provided, if not, don't update it
                if (!empty($title)) {
                    $post->title = $title;
                }

                $post->content = $content;
                $post->author = $author;

                // Attempt to update the post and redirect on success
                if ($post->update($id)) {
                    header("Location: list_posts.php");
                    exit;
                } else {
                    $error = "Failed to update post.";
                }
            }
        }
        // If the form is not submitted, the existing data will be shown in the form
    } else {
        $error = "Post not found!";
    }
} else {
    $error = "Invalid post ID!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Post</h1>
        
        <!-- Display any validation or update error -->
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>

        <!-- Form for editing the post -->
        <form action="edit_post.php?id=<?php echo $id; ?>" method="POST">
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo htmlspecialchars($post->title); ?>"><br><br>
            
            <label for="content">Content:</label>
            <textarea name="content" rows="10" cols="30" required><?php echo htmlspecialchars($post->content); ?></textarea><br><br>
            
            <label for="author">Author:</label>
            <input type="text" name="author" value="<?php echo htmlspecialchars($post->author); ?>" required><br><br>
            
            <button type="submit">Update Post</button>
        </form>
    </div>
</body>
</html>
