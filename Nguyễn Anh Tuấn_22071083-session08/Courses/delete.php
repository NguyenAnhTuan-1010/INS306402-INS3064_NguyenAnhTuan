<?php
/**
 * Delete Course Module
 * Handles the removal of courses using the Database singleton helper.
 */

require_once __DIR__ . '/../classes/Database.php';

// Check if a valid ID is provided via GET request
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    try {
        // Access the singleton Database instance
        $db = Database::getInstance();

        // Define the deletion criteria
        $table = 'courses';
        $where = 'id = ?';
        $params = [$_GET['id']];

        // Execute the delete operation through your helper method
        $db->delete($table, $where, $params);

    } catch (Exception $e) {
        // Log error silently and proceed with redirection
        error_log("Delete operation failed: " . $e->getMessage());
    }
}

/**
 * Redirection Phase
 * Always redirect back to the index page to refresh the course list.
 */
header("Location: index.php");
exit();