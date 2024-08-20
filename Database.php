<?php

/**
 * Database class to handle database connection and queries.
 */
class Database {
    // Database configuration parameters
    private $host = "localhost";      // Database host
    private $db_name = "blog_db";     // Database name
    private $username = "root";       // Database username
    private $password = "";           // Database password
    public $conn;                     // Database connection object

    /**
     * Establishes and returns a database connection.
     *
     * @return mysqli|null The database connection object or null if connection fails.
     */
    public function getConnection() {
        $this->conn = null; // Initialize connection to null

        try {
            // Create a new mysqli instance with the database configuration
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);

            // Check if there was an error connecting to the database
            if ($this->conn->connect_error) {
                // Connection failed, terminate script with an error message
                die("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            // Catch any exceptions and display an error message
            echo "Connection error: " . $e->getMessage();
        }

        // Return the database connection object
        return $this->conn;
    }

    /**
     * Executes an SQL query and returns the result.
     *
     * @param string $query The SQL query to execute.
     * @return bool|mysqli_result The result of the query or false on failure.
     */
    public function executeQuery($query) {
        // Execute the query using the database connection
        return $this->conn->query($query);
    }

    /**
     * Fetches a single row from the database based on a query.
     *
     * @param string $query The SQL query to fetch the row.
     * @return array|null The fetched row as an associative array or null if no row found.
     */
    public function fetchSingleRow($query) {
        // Execute the query
        $result = $this->executeQuery($query);

        // Fetch and return a single row as an associative array
        return $result ? $result->fetch_assoc() : null;
    }

    /**
     * Fetches all rows from the database based on a query.
     *
     * @param string $query The SQL query to fetch the rows.
     * @return array The fetched rows as an array of associative arrays.
     */
    public function fetchAllRows($query) {
        // Execute the query
        $result = $this->executeQuery($query);

        // Initialize an empty array to hold the rows
        $rows = [];

        // Fetch all rows and add them to the array
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        // Return the array of rows
        return $rows;
    }

    /**
     * Prepares and executes a parameterized SQL statement.
     *
     * @param string $query The SQL query with placeholders.
     * @param string $types The types of the parameters (e.g., 'ssi' for two strings and an integer).
     * @param array $params The parameters to bind to the query.
     * @return bool|mysqli_stmt The prepared statement or false on failure.
     */
    public function executePreparedQuery($query, $types, $params) {
        // Prepare the SQL statement
        $stmt = $this->conn->prepare($query);

        // Check if preparation was successful
        if ($stmt === false) {
            return false;
        }

        // Bind the parameters to the statement
        $stmt->bind_param($types, ...$params);

        // Execute the statement
        $stmt->execute();

        // Return the statement object for further handling
        return $stmt;
    }

    /**
     * Fetches a single row from a parameterized query.
     *
     * @param string $query The SQL query with placeholders.
     * @param string $types The types of the parameters.
     * @param array $params The parameters to bind.
     * @return array|null The fetched row as an associative array or null if no row found.
     */
    public function fetchSinglePreparedRow($query, $types, $params) {
        // Execute the prepared query
        $stmt = $this->executePreparedQuery($query, $types, $params);

        // Fetch the result
        $result = $stmt->get_result();

        // Fetch and return a single row as an associative array
        return $result ? $result->fetch_assoc() : null;
    }

    /**
     * Fetches all rows from a parameterized query.
     *
     * @param string $query The SQL query with placeholders.
     * @param string $types The types of the parameters.
     * @param array $params The parameters to bind.
     * @return array The fetched rows as an array of associative arrays.
     */
    public function fetchAllPreparedRows($query, $types, $params) {
        // Execute the prepared query
        $stmt = $this->executePreparedQuery($query, $types, $params);

        // Fetch the result
        $result = $stmt->get_result();

        // Initialize an empty array to hold the rows
        $rows = [];

        // Fetch all rows and add them to the array
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        // Return the array of rows
        return $rows;
    }
}

?>
