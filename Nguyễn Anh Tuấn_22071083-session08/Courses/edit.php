<?php
/**
 * Edit Course Module
 * Handles fetching existing data and updating course records.
 */

require_once __DIR__ . '/../classes/Database.php';

$error_message = '';
$title = '';
$description = '';

// Get ID from URL and validate
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : die('Error: Invalid Course ID.');

try {
    $db = Database::getInstance();

    // Handle Form Submission (Update logic)
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        // Validation
        if (empty($title)) {
            $error_message = "Course title cannot be empty!";
        } elseif (mb_strlen($title) < 3) {
            $error_message = "Course title must be at least 3 characters long!";
        } else {
            // Use your helper update method: update($table, $data, $where, $whereParams)
            $db->update(
                'courses', 
                ['title' => $title, 'description' => $description], 
                'id = ?', 
                [$id]
            );
            
            header("Location: index.php");
            exit();
        }
    } else {
        // Initial Fetch: Load current data into the form
        $course = $db->fetch("SELECT title, description FROM courses WHERE id = ?", [$id]);
        
        if ($course) {
            $title = $course['title'];
            $description = $course['description'];
        } else {
            die("Error: Course not found.");
        }
    }
} catch (Exception $e) {
    error_log("Edit operation error: " . $e->getMessage());
    $error_message = "A database error occurred. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Course</title>
    <style>
        :root {
            --primary-warning: #ffc107;
            --text-dark: #333;
            --bg-light: #f4f7f6;
        }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; margin: 40px; background-color: var(--bg-light); line-height: 1.6; }
        .card { max-width: 600px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { color: var(--text-dark); margin-top: 0; border-bottom: 2px solid var(--primary-warning); padding-bottom: 10px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; font-size: 14px; }
        .error-msg { color: #d9534f; background: #f2dede; padding: 10px; border-radius: 4px; margin-bottom: 20px; border: 1px solid #ebccd1; font-weight: bold; }
        .btn-update { width: 100%; padding: 12px; background: var(--primary-warning); color: #212529; border: none; cursor: pointer; border-radius: 5px; font-size: 16px; font-weight: bold; transition: opacity 0.2s; }
        .btn-update:hover { opacity: 0.85; }
        .nav-link { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; font-weight: 500; }
        .nav-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Update Course Information</h2>
        <a href="index.php" class="nav-link">⬅ Back to List</a>

        <?php if(!empty($error_message)): ?>
            <div class="error-msg"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <form action="edit.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
            <div class="form-group">
                <label for="title">Course Title (*)</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="6"><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            
            <button type="submit" class="btn-update">Update Course</button>
        </form>
    </div>

</body>
</html>