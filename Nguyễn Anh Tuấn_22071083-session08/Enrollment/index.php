<?php
/**
 * Enrollment Dashboard
 * Displays an aggregated list of students and their registered courses using SQL JOINs.
 */

require_once __DIR__ . '/../classes/Database.php';

try {
    $db = Database::getInstance();

    // Aggregating data from enrollments, students, and courses
    $sql = 'SELECT e.id,
                   s.name  AS student_name,
                   s.email,
                   c.title AS course_title,
                   e.enrolled_at
            FROM enrollments e
            JOIN students s ON e.student_id = s.id
            JOIN courses  c ON e.course_id  = c.id
            ORDER BY e.enrolled_at DESC';

    $enrollments = $db->fetchAll($sql);
} catch (Exception $e) {
    error_log("Failed to retrieve enrollment list: " . $e->getMessage());
    $enrollments = [];
}

// Success message handling
$success = isset($_GET['success']) ? "Enrollment completed successfully!" : "";
$deleted = isset($_GET['deleted']) ? "Enrollment has been removed." : "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollment Management</title>
    <style>
        :root {
            --primary: #4f46e5;
            --secondary: #6366f1;
            --success-bg: #ecfdf5;
            --success-text: #065f46;
            --danger-text: #b91c1c;
            --bg-page: #f8fafc;
        }

        body { 
            font-family: 'Inter', system-ui, -apple-system, sans-serif; 
            background-color: var(--bg-page); 
            margin: 0; 
            padding: 40px; 
            color: #1e293b;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .nav-link { text-decoration: none; color: var(--primary); font-weight: 600; margin-bottom: 20px; display: inline-block; }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        h1 { margin: 0; font-size: 1.75rem; color: #0f172a; }

        .alert { padding: 12px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; text-align: center; }
        .alert-success { background: var(--success-bg); color: var(--success-text); border: 1px solid #d1fae5; }

        .btn { 
            padding: 10px 20px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-weight: 600; 
            transition: all 0.2s;
        }

        .btn-create { background: var(--primary); color: white; }
        .btn-create:hover { background: var(--secondary); transform: translateY(-1px); }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        
        th { 
            text-align: left; 
            padding: 15px; 
            background: #f1f5f9; 
            color: #475569; 
            font-size: 0.85rem; 
            text-transform: uppercase; 
            letter-spacing: 0.05em;
        }

        td { padding: 15px; border-bottom: 1px solid #f1f5f9; font-size: 0.95rem; }
        
        tr:hover { background: #f8fafc; }

        .badge-course { 
            background: #e0e7ff; 
            color: #4338ca; 
            padding: 4px 10px; 
            border-radius: 9999px; 
            font-size: 0.8rem; 
            font-weight: 600; 
        }

        .delete-link { color: var(--danger-text); text-decoration: none; font-weight: 600; }
        .delete-link:hover { text-decoration: underline; }

        .empty-state { text-align: center; padding: 50px; color: #94a3b8; }
    </style>
</head>
<body>

<div class="container">
    <a href="../index.php" class="nav-link">← Dashboard Home</a>

    <div class="header">
        <h1>Course Enrollments</h1>
        <a href="create.php" class="btn btn-create">+ New Registration</a>
    </div>

    <?php if ($success || $deleted): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success ?: $deleted) ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Student Details</th>
                <th>Course Name</th>
                <th>Enrollment Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($enrollments)): ?>
                <?php foreach ($enrollments as $enroll): ?>
                    <tr>
                        <td>#<?= $enroll['id'] ?></td>
                        <td>
                            <div style="font-weight: 700;"><?= htmlspecialchars($enroll['student_name']) ?></div>
                            <div style="font-size: 0.8rem; color: #64748b;"><?= htmlspecialchars($enroll['email']) ?></div>
                        </td>
                        <td><span class="badge-course"><?= htmlspecialchars($enroll['course_title']) ?></span></td>
                        <td><?= date("M d, Y - H:i", strtotime($enroll['enrolled_at'])) ?></td>
                        <td>
                            <a href="delete.php?id=<?= $enroll['id'] ?>" 
                               class="delete-link"
                               onclick="return confirm('Are you sure you want to cancel this enrollment?');">Remove</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty-state">No student registrations found yet.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>