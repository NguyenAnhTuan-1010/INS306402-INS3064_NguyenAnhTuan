<?php
/**
 * Create Course Module
 * Handles the creation of new courses with validation and secure DB insertion.
 */

require_once __DIR__ . '/../classes/Database.php';

$error_message = '';
$title = '';
$description = '';

// Handle Form Submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and capture input
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');

    // Validation Logic
    if (empty($title)) {
        $error_message = "Course title is required!";
    } elseif (mb_strlen($title) < 3) {
        $error_message = "Course title must be at least 3 characters long!";
    } else {
        try {
            // Utilize your Singleton Database class
            $db = Database::getInstance();
            
            // Using your helper insert method for cleaner code
            $data = [
                'title'       => $title,
                'description' => $description
            ];
            
            $db->insert('courses', $data);

            // Redirect on success
            header("Location: index.php");
            exit();
        } catch (Exception $e) {
            // Catch and display the user-friendly exception from your Database class
            $error_message = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course</title>
    <style>
        :root {
            --primary-success: #28a745;
            --error-red: #dc3545;
            --bg-light: #f8f9fa;
        }
        body { font-family: 'Segoe UI', Arial, sans-serif; margin: 40px; line-height: 1.6; background-color: var(--bg-light); }
        .container { max-width: 600px; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { color: #333; margin-top: 0; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        .error-box { background-color: #f8d7da; color: var(--error-red); padding: 15px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #f5c6cb; font-weight: bold; }
        .btn-submit { padding: 12px 20px; background: var(--primary-success); color: white; border: none; cursor: pointer; border-radius: 4px; font-size: 16px; font-weight: bold; transition: background 0.3s; }
        .btn-submit:hover { background: #218838; }
        .back-link { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #007bff; font-weight: 500; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="container">
        <h2>Add New Course</h2>
        <a href="index.php" class="back-link">← Back to Course List</a>

        <?php if(!empty($error_message)): ?>
            <div class="error-box"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="title">Course Title (*)</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" placeholder="e.g. IC Design Basics">
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" placeholder="Enter course details..."><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            
            <button type="submit" class="btn-submit">Save Course</button>
        </form>
    </div>

</body>
</html>