<?php
// Include necessary files for database connection and Post class
include_once 'Database.php';
include_once 'Post.php';

// Instantiate the Database class and establish a connection
$database = new Database();
$conn = $database->getConnection();

// Create a Post object with the database connection
$post = new Post($conn);

// Retrieve all posts from the database
$posts = $post->listAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
    <style>
        /* Basic styling for the body and table */
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        a { text-decoration: none; color: #007bff; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>List of Posts</h1>
    <table>
        <thead>
            <tr>
                <th>#</th> <!-- Changed ID to # -->
                <th>Title</th>
                <th>Content</th>
                <th>Author</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <!-- Check if there are posts to display -->
            <?php if ($posts->num_rows > 0): ?>
                <!-- Initialize a counter variable -->
                <?php $counter = 1; ?>
                <!-- Loop through each post and display it in a table row -->
                <?php while ($row = $posts->fetch_assoc()): ?>
                    <tr>
                        <!-- Display the counter value instead of the post ID -->
                        <td><?php echo htmlspecialchars($counter); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['content']); ?></td>
                        <td><?php echo htmlspecialchars($row['author']); ?></td>
                        <td>
                            <!-- Action links for viewing, editing, and deleting posts -->
                            <a href="view_post.php?id=<?php echo $row['id']; ?>">View</a> |
                            <a href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a> |
                            <a href="delete_post.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                    <!-- Increment the counter for the next row -->
                    <?php $counter++; ?>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Display a message if no posts are found -->
                <tr>
                    <td colspan="5">No posts found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <!-- Link to create a new post -->
    <a href="create_post.php">Create New Post</a>   
</body>
</html>
