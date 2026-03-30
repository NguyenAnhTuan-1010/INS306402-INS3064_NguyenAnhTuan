<?php
/**
 * Create Student Module
 * Handles student registration with server-side validation and duplicate email checks.
 */

require_once __DIR__ . '/../classes/Database.php';

$errors = [];
$name   = '';
$email  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture and sanitize form data
    $name  = trim($_POST['name']  ?? '');
    $email = trim($_POST['email'] ?? '');

    // 1. Server-side Validation
    if ($name === '') {
        $errors['name'] = 'Full name is required.';
    }

    if ($email === '') {
        $errors['email'] = 'Email address is required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Please enter a valid email format.';
    }

    // 2. Database Processing
    if (empty($errors)) {
        try {
            $db = Database::getInstance();

            // Integrity Check: Ensure email uniqueness
            $existing = $db->fetch('SELECT id FROM students WHERE email = ?', [$email]);

            if ($existing) {
                $errors['email'] = 'This email is already registered in the system.';
            } else {
                // Insert new student record
                $db->insert('students', [
                    'name'  => $name,
                    'email' => $email,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                // Redirect to the list with a success notification
                header('Location: index.php?success=1');
                exit;
            }
        } catch (Exception $e) {
            // Log technical error and display a generic message to the user
            error_log("Student registration error: " . $e->getMessage());
            $errors['general'] = 'An unexpected error occurred. Please try again later.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
    <style>
        :root {
            --primary: #4f46e5;
            --error: #ef4444;
            --text-dark: #1f2937;
            --bg-gray: #f9fafb;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-gray); margin: 0; padding: 40px; }
        .form-container { max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h1 { font-size: 1.5rem; color: var(--text-dark); margin-bottom: 25px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #374151; }
        input[type="text"], input[type="email"] { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; box-sizing: border-box; font-size: 1rem; }
        .error-msg { color: var(--error); font-size: 0.85rem; margin-top: 5px; display: block; font-weight: 500; }
        .alert-general { background: #fef2f2; color: #991b1b; padding: 12px; border-radius: 8px; border: 1px solid #fecaca; margin-bottom: 20px; text-align: center; }
        .btn-group { display: flex; gap: 15px; margin-top: 30px; }
        button { flex: 2; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: opacity 0.2s; }
        button:hover { opacity: 0.9; }
        .btn-cancel { flex: 1; padding: 12px; background: #e5e7eb; color: #374151; text-decoration: none; text-align: center; border-radius: 8px; font-weight: 600; font-size: 0.9rem; }
        .btn-cancel:hover { background: #d1d5db; }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Register New Student</h1>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert-general"><?= htmlspecialchars($errors['general']) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="form-group">
            <label for="name">Full Name (*)</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($name) ?>" placeholder="e.g. Anh Tuan">
            <?php if (!empty($errors['name'])): ?>
                <span class="error-msg"><?= $errors['name'] ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="email">Email Address (*)</label>
            <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" placeholder="tuan@example.com">
            <?php if (!empty($errors['email'])): ?>
                <span class="error-msg"><?= $errors['email'] ?></span>
            <?php endif; ?>
        </div>

        <div class="btn-group">
            <button type="submit">Save Student</button>
            <a href="index.php" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

</body>
</html>