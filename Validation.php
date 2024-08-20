<?php

trait Validation {
    // Validate the title length and uniqueness
    public static function validateTitle($title, $conn, $postId = null) {
        if (strlen($title) < 1 || strlen($title) > 255) {
            return "Title must be between 20 and 255 characters.";
        }

        if ($postId) {
            $query = "SELECT id FROM posts WHERE title = ? AND id != ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $title, $postId);
        } else {
            $query = "SELECT id FROM posts WHERE title = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $title);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return "Title already exists.";
        }

        return null;
    }

    // Validate the author's name length
    public static function validateAuthor($author) {
        if (strlen($author) < 2 || strlen($author) > 100) {
            return "Author must be between 2 and 100 characters.";
        }
        return null;
    }

    // Validate content with a minimum word count
    public static function validateContent($content) {
        if (strlen($content) < 10 || strlen($content) > 255) {
            return "Content must be at least 10 characters.";
        }
        return null;
    }
}
?>
