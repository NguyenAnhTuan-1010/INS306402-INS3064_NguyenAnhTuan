<?php
/**
 * Delete Student Module
 * Safely removes a student record from the database.
 */

require_once __DIR__ . '/../classes/Database.php';

// Capture and validate the Student ID from the URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// If ID is invalid, redirect back to the index immediately
if ($id <= 0) {
    header('Location: index.php');
    exit;
}

try {
    // Access the singleton Database instance
    $db = Database::getInstance();
    
    /**
     * Execute deletion
     * Note: If you have foreign key constraints (like in Enrollments), 
     * this might fail unless 'ON DELETE CASCADE' is set in MySQL.
     */
    $db->delete('students', 'id = ?', [$id]);
    
    // Redirect with a success flag for the UI
    header('Location: index.php?deleted=1');
    exit;

} catch (Exception $e) {
    // Log the error for the developer (Tuấn)
    error_log("Failed to delete student ID {$id}: " . $e->getMessage());
    
    // Redirect with an error flag so the index page can show a warning
    header('Location: index.php?error=delete_failed');
    exit;
}