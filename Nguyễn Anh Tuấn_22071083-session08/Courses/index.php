<?php
/**
 * Course Management Dashboard
 * Displays a list of all courses retrieved via the Database singleton.
 */

require_once __DIR__ . '/../classes/Database.php';

try {
    // Access the singleton Database instance
    $db = Database::getInstance();

    // Fetch all courses ordered by most recent
    $courses = $db->fetchAll("SELECT id, title, description, created_at FROM courses ORDER BY id DESC");
} catch (Exception $e) {
    error_log("Failed to fetch courses: " . $e->getMessage());
    $courses = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management System</title>
    <style>
        :root {
            --primary: #4f46e5;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --text-main: #1f2937;
            --bg-body: #f3f4f6;
        }

        body { 
            font-family: 'Inter', system-ui, -apple-system, sans-serif; 
            margin: 40px; 
            background-color: var(--bg-body); 
            color: var(--text-main);
            line-height: 1.5;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .nav-back { text-decoration: none; color: var(--primary); font-weight: 500; display: inline-block; margin-bottom: 20px; }
        
        .header-actions { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }

        h1 { margin: 0; font-size: 1.875rem; color: #111827; }

        table { width: 100%; border-collapse: collapse; background: white; }
        
        th { 
            background-color: #f9fafb; 
            color: #6b7280; 
            font-weight: 600; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 0.05em; 
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        td { padding: 16px; border-bottom: 1px solid #f3f4f6; vertical-align: top; }

        tr:hover { background-color: #f9fafb; }

        .btn { 
            padding: 8px 12px; 
            text-decoration: none; 
            border-radius: 6px; 
            font-size: 0.875rem; 
            font-weight: 600; 
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-add { background-color: var(--primary); color: white; }
        .btn-add:hover { background-color: #4338ca; }

        .btn-edit { color: var(--warning); border: 1px solid var(--warning); margin-right: 8px; }
        .btn-edit:hover { background-color: var(--warning); color: white; }

        .btn-delete { color: var(--danger); border: 1px solid var(--danger); }
        .btn-delete:hover { background-color: var(--danger); color: white; }

        .empty-state { text-align: center; padding: 40px; color: #9ca3af; }
    </style>
</head>
<body>

    <div class="container">
        <a href="../index.php" class="nav-back">← Back to Dashboard</a>
        
        <div class="header-actions">
            <h1>Course List</h1>
            <a href="create.php" class="btn btn-add">+ Add New Course</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Course Title</th>
                    <th>Description</th>
                    <th>Date Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($courses)): ?>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td>#<?php echo htmlspecialchars($course['id']); ?></td>
                            <td><strong><?php echo htmlspecialchars($course['title']); ?></strong></td>
                            <td><?php echo nl2br(htmlspecialchars($course['description'])); ?></td>
                            <td><?php echo date("M d, Y", strtotime($course['created_at'])); ?></td>
                            <td>
                                <div style="display: flex;">
                                    <a href="edit.php?id=<?php echo $course['id']; ?>" class="btn btn-edit">Edit</a>
                                    <a href="delete.php?id=<?php echo $course['id']; ?>" 
                                       class="btn btn-delete" 
                                       onclick="return confirm('Are you sure you want to delete this course?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="empty-state">No courses found. Start by adding a new one!</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>