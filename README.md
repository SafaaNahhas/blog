# Blog Project

This is a simple PHP-based blog project that demonstrates CRUD operations (Create, Read, Update, Delete) using Object-Oriented Programming (OOP) and MySQL.

## Installation

1. Clone or download the project files.
2. Import the SQL file `blog_db.sql` into your MySQL database:
   - Use a tool like phpMyAdmin or command line to import the SQL file and create the database and table.
3. Update the `Database.php` file with your MySQL credentials.

## Running the Project

1. Make sure your web server (e.g., Apache, Nginx) and MySQL are running.
2. Place the project files in your web server directory (e.g., `htdocs` for XAMPP).
3. Access the project via your web browser:
   - For example: `http://localhost/blog_project/list_posts.php`

## Files

- `.htaccess`:File Configuration Redirects any request to the root URL to the list_posts.php page.
- `Database.php`: A class that handles database connections and various utility functions for executing and fetching results from the database.
- `Post.php`: A class representing a blog post, with methods to create, read, update, and delete posts.
Uses a Validation trait for input validation.
- `create_post.php`: This script handles the creation of a new blog post.
It validates the input data using a Validation trait.
If validation passes, it saves the post to the database.
- `view_post.php`: Page for viewing a specific blog post.
- `edit_post.php`: Page for editing an existing blog post.
- `delete_post.php`: Page for deleting a blog post.
- `list_posts.php`: Lists all the blog posts in a tabular format.
Provides options to view, edit, or delete each post.
- `style.css`: Basic styling for the project.
- `blog_db.sql`: SQL script to create the database and posts table.
- ` Validation.php(Trait)`:
A trait containing static methods to validate the title, author, and content of the blog post.

## Notes
- Validation:
This code validates the title to be unique and between certain lengths, the author's name to be within a length range, and the content to have a minimum length.
- Security: Ensure that all inputs are sanitized to prevent SQL injection. While prepared statements are used, it's always good to enforce data sanitation.
- User Feedback: Provide more detailed feedback messages to users when actions succeed or fail, like creating or updating a post.
- Error Handling: You might want to enhance error handling in Database.php to give more detailed error logs or user feedback.
