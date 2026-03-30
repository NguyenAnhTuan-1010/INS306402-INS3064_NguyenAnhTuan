<?php
/**
 * Student Directory Dashboard
 * Lists all registered students using the Database singleton.
 */

require_once __DIR__ . '/../classes/Database.php';

try {
    $db = Database::getInstance();

    // Retrieve all students, sorting by most recent registration
    $students = $db->fetchAll('SELECT * FROM students ORDER BY created_at DESC');
} catch (Exception $e) {
    error_log("Failed to fetch student list: " . $e->getMessage());
    $students = [];
}

// User Notification Handling via Query String
$alertMessage = '';
$alertType = 'success';

if (isset($_GET['success'])) {
    $alertMessage = 'Student added successfully!';
} elseif (isset($_GET['updated'])) {
    $alertMessage = 'Student profile updated successfully!';
} elseif (isset($_GET['deleted'])) {
    $alertMessage = 'Student record removed successfully!';
} elseif (isset($_GET['error'])) {
    $alertMessage = 'An error occurred. Please try again.';
    $alertType = 'error';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management | School System</title>
    <style>
        :root {
            --primary: #10b981; /* Emerald Green */
            --secondary: #3b82f6; /* Blue */
            --danger: #ef4444; /* Red */
            --bg-light: #f3f4f6;
            --text-dark: #111827;
        }

        body { 
            font-family: 'Inter', system-ui, sans-serif; 
            margin: 40px; 
            background-color: var(--bg-light); 
            color: var(--text-dark);
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

        .top-nav { margin-bottom: 20px; }
        .top-nav a { text-decoration: none; color: var(--secondary); font-weight: 500; }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 15px;
        }

        h1 { margin: 0; font-size: 1.75rem; }

        .alert {
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-weight: 600;
            text-align: center;
        }
        .alert-success { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fee2e2; color: #991b1b; border: 1px solid #fecaca; }

        .btn {
            padding: 8px 14px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 0.875rem;
            font-weight: 600;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-add { background: var(--primary); color: white; }
        .btn-add:hover { background: #059669; }

        .btn-edit { color: var(--secondary); border: 1px solid var(--secondary); margin-right: 5px; }
        .btn-edit:hover { background: var(--secondary); color: white; }

        .btn-delete { color: var(--danger); border: 1px solid var(--danger); }
        .btn-delete:hover { background: var(--danger); color: white; }

        table { width: 100%; border-collapse: collapse; }
        th { 
            text-align: left; 
            padding: 12px 15px; 
            background: #f9fafb; 
            color: #6b7280; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 0.05em;
        }
        td { padding: 15px; border-bottom: 1px solid #f3f4f6; }
        tr:hover { background-color: #f9fafb; }

        .empty-row { text-align: center; padding: 40px; color: #9ca3af; }
    </style>
</head>
<body>

<div class="container">
    <div class="top-nav">
        <a href="../index.php">← Back to Dashboard</a>
    </div>

    <div class="header-section">
        <h1>Student Records</h1>
        <a href="create.php" class="btn btn-add">+ Register New Student</a>
    </div>

    <?php if ($alertMessage): ?>
        <div class="alert alert-<?= $alertType ?>">
            <?= htmlspecialchars($alertMessage) ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Email Address</th>
                <th>Joined Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($students)): ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td>#<?= $student['id'] ?></td>
                        <td><strong><?= htmlspecialchars($student['name']) ?></strong></td>
                        <td><?= htmlspecialchars($student['email']) ?></td>
                        <td><?= date("M d, Y", strtotime($student['created_at'])) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $student['id'] ?>" class="btn btn-edit">Edit</a>
                            <a href="delete.php?id=<?= $student['id'] ?>" 
                               class="btn btn-delete" 
                               onclick="return confirm('Delete this student profile?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty-row">No student records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>