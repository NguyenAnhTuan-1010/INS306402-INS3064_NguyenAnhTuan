<?php
/**
 * Edit Student Module
 * Facilitates updating student information with validation and email uniqueness checks.
 */

require_once __DIR__ . '/../classes/Database.php';

$db = Database::getInstance();

// Capture and validate Student ID from the URL
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($id <= 0) {
    header('Location: index.php');
    exit;
}

$errors = [];

// Retrieve current student data for form pre-filling
try {
    $student = $db->fetch('SELECT * FROM students WHERE id = ?', [$id]);
    if (!$student) {
        header('Location: index.php');
        exit;
    }
} catch (Exception $e) {
    error_log("Failed to load student data for ID {$id}: " . $e->getMessage());
    die('Critical Error: Could not retrieve student details.');
}

$name  = $student['name'];
$email = $student['email'];

// Handle the update request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']  ?? '');
    $email = trim($_POST['email'] ?? '');

    // Server-side Validation
    if ($name === '') {
        $errors['name'] = 'Full name is required.';
    }

    if ($email === '') {
        $errors['email'] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email format.';
    }

    if (empty($errors)) {
        try {
            /** * Email Uniqueness Check
             * Ensures the new email doesn't belong to another student (excluding current record).
             */
            $existing = $db->fetch(
                'SELECT id FROM students WHERE email = ? AND id <> ?',
                [$email, $id]
            );

            if ($existing) {
                $errors['email'] = 'This email is already associated with another student.';
            } else {
                // Execute the update via your Database helper
                $db->update('students', [
                    'name'  => $name,
                    'email' => $email,
                ], 'id = ?', [$id]);

                header('Location: index.php?updated=1');
                exit;
            }
        } catch (Exception $e) {
            error_log("Update failed for student ID {$id}: " . $e->getMessage());
            $errors['general'] = 'An internal error occurred. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Information</title>
    <style>
        :root {
            --primary: #4f46e5;
            --error: #ef4444;
            --bg-page: #f8fafc;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-page); padding: 40px; margin: 0; }
        .edit-card { max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        h1 { font-size: 1.5rem; color: #1e293b; margin-bottom: 25px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #475569; }
        input { width: 100%; padding: 12px; border: 1px solid #e2e8f0; border-radius: 8px; box-sizing: border-box; font-size: 1rem; }
        input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1); }
        .error-text { color: var(--error); font-size: 0.85rem; margin-top: 5px; display: block; font-weight: 500; }
        .alert-error { background: #fff1f2; color: #9f1239; padding: 12px; border-radius: 8px; border: 1px solid #fecdd3; margin-bottom: 20px; text-align: center; }
        .actions { display: flex; gap: 10px; margin-top: 30px; }
        button { flex: 2; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: opacity 0.2s; }
        button:hover { opacity: 0.9; }
        .btn-cancel { flex: 1; padding: 12px; background: #f1f5f9; color: #64748b; text-decoration: none; text-align: center; border-radius: 8px; font-size: 0.9rem; font-weight: 600; }
        .btn-cancel:hover { background: #e2e8f0; }
    </style>
</head>
<body>

<div class="edit-card">
    <h1>Update Student</h1>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert-error"><?= htmlspecialchars($errors['general']) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF'] . '?id=' . $id) ?>">
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
            <?php if (!empty($errors['name'])): ?>
                <span class="error-text"><?= $errors['name'] ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
            <?php if (!empty($errors['email'])): ?>
                <span class="error-text"><?= $errors['email'] ?></span>
            <?php endif; ?>
        </div>

        <div class="actions">
            <button type="submit">Update Details</button>
            <a href="index.php" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>