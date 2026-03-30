<?php
/**
 * Database Configuration Factory
 * This file returns a central configuration array for the Database class.
 */

return [
    // Database server host (typically 'localhost' for XAMPP environments)
    'host'     => 'localhost',
    
    // The target database name as created in phpMyAdmin
    'dbname'   => 'school_db',
    
    // Default XAMPP credentials (username: root, password: empty)
    'username' => 'root',
    'password' => '',
    
    // Character set for full Unicode support (including Vietnamese and emojis)
    'charset'  => 'utf8mb4',
    
    // Additional options for higher environment flexibility (Optional)
    'port'     => '3306',
];