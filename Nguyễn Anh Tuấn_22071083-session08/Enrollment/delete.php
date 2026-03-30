<?php
/**
 * Delete Enrollment Module
 * Safely removes an enrollment record using the Database singleton.
 */

require_once __DIR__ . '/../classes/Database.php';

// Validate the ID from the GET request
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    try {
        $db = Database::getInstance();
        
        // Execute the deletion using your custom helper method
        $db->delete('enrollments', 'id = ?', [$id]);
        
        // Redirect with a success flag
        header('Location: index.php?deleted=1');
        exit;
        
    } catch (Exception $e) {
        // Log the technical error for debugging
        error_log("Enrollment deletion failed: " . $e->getMessage());
        
        // Redirect with an error flag if something went wrong
        header('Location: index.php?error=delete_failed');
        exit;
    }
}

// Default redirect if ID is invalid
header('Location: index.php');
exit;