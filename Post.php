<?php
include_once 'Validation.php'; // Include the trait containing validation methods

class Post {
    use Validation; // Use the Validation trait for input validation

    private $conn; // Database connection
    private $table_name = "posts"; // Table name

    public $id;
    public $title;
    public $content;
    public $author;
    public $created_at;
    public $updated_at;

    // Constructor to initialize the database connection
    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a new post
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (title, content, author) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query); // Prepare the SQL query

        // Bind parameters to the SQL query
        $stmt->bind_param("sss", $this->title, $this->content, $this->author);

        // Execute the query and return true if successful
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Read a single post by ID
    public function read($id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query); // Prepare the SQL query
        $stmt->bind_param("i", $id); // Bind the ID parameter
        $stmt->execute(); // Execute the query
        $result = $stmt->get_result(); // Get the result set
        $row = $result->fetch_assoc(); // Fetch the associative array

        // If a row is found, populate the object properties and return true
        if ($row) {
            $this->id = $row['id'];
            $this->title = $row['title'];
            $this->content = $row['content'];
            $this->author = $row['author'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            return true;
        }
        return false;
    }

    // Update an existing post by ID
    public function update($id) {
        $query = "UPDATE " . $this->table_name . " SET title = ?, content = ?, author = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query); // Prepare the SQL query
        $stmt->bind_param("sssi", $this->title, $this->content, $this->author, $id); // Bind parameters

        // Execute the query and return true if successful
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Delete a post by ID
    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query); // Prepare the SQL query
        $stmt->bind_param("i", $id); // Bind the ID parameter

        // Execute the query and return true if successful
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // List all posts, ordered by creation date in descending order
    public function listAll() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY created_at DESC";
        $result = $this->conn->query($query); // Execute the query
        return $result; // Return the result set
    }
}
?>
