<?php
/**
 * Create Enrollment Module
 * Facilitates the association between Students and Courses.
 */

require_once __DIR__ . '/../classes/Database.php';

try {
    $db = Database::getInstance();

    // Fetch lists for dropdown menus
    $students = $db->fetchAll('SELECT id, name FROM students ORDER BY name ASC');
    $courses  = $db->fetchAll('SELECT id, title FROM courses ORDER BY title ASC');
} catch (Exception $e) {
    error_log("Data retrieval failed: " . $e->getMessage());
    die("A system error occurred. Please try again later.");
}

$errors     = [];
$student_id = 0;
$course_id  = 0;

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = (int) ($_POST['student_id'] ?? 0);
    $course_id  = (int) ($_POST['course_id']  ?? 0);

    // Basic Validation
    if ($student_id <= 0) $errors['student_id'] = 'Please select a student.';
    if ($course_id <= 0)  $errors['course_id']  = 'Please select a course.';

    if (empty($errors)) {
        try {
            // Check for existing enrollment to prevent duplicates (Integrity Check)
            $is_enrolled = $db->fetch(
                'SELECT id FROM enrollments WHERE student_id = ? AND course_id = ?',
                [$student_id, $course_id]
            );

            if ($is_enrolled) {
                $errors['general'] = 'This student is already enrolled in the selected course.';
            } else {
                // Insert into the junction table
                $db->insert('enrollments', [
                    'student_id' => $student_id,
                    'course_id'  => $course_id,
                    'enrolled_at' => date('Y-m-d H:i:s')
                ]);

                header('Location: index.php?success=1');
                exit;
            }
        } catch (Exception $e) {
            error_log("Enrollment failed: " . $e->getMessage());
            $errors['general'] = 'An error occurred while saving the enrollment.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Enrollment</title>
    <style>
        :root {
            --primary: #4f46e5;
            --error: #ef4444;
            --bg-page: #f9fafb;
        }
        body { font-family: 'Inter', sans-serif; background-color: var(--bg-page); margin: 0; padding: 40px; }
        .form-card { max-width: 500px; margin: auto; background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        h1 { font-size: 1.5rem; color: #111827; margin-bottom: 25px; text-align: center; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #374151; }
        select { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; background-color: white; font-size: 1rem; }
        .error-text { color: var(--error); font-size: 0.85rem; margin-top: 5px; display: block; }
        .alert-error { background: #fef2f2; color: #991b1b; padding: 12px; border-radius: 8px; border: 1px solid #fecaca; margin-bottom: 20px; text-align: center; }
        button { width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: opacity 0.2s; }
        button:hover { opacity: 0.9; }
        .cancel-link { display: block; text-align: center; margin-top: 15px; text-decoration: none; color: #6b7280; font-size: 0.9rem; }
    </style>
</head>
<body>

<div class="form-card">
    <h1>New Enrollment</h1>

    <?php if (!empty($errors['general'])): ?>
        <div class="alert-error"><?= htmlspecialchars($errors['general']) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
        <div class="form-group">
            <label for="student_id">Select Student</label>
            <select name="student_id" id="student_id">
                <option value="0">-- Choose a student --</option>
                <?php foreach ($students as $s): ?>
                    <option value="<?= $s['id'] ?>" <?= ($s['id'] == $student_id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($s['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['student_id'])): ?>
                <span class="error-text"><?= $errors['student_id'] ?></span>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="course_id">Select Course</label>
            <select name="course_id" id="course_id">
                <option value="0">-- Choose a course --</option>
                <?php foreach ($courses as $c): ?>
                    <option value="<?= $c['id'] ?>" <?= ($c['id'] == $course_id) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($c['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?php if (!empty($errors['course_id'])): ?>
                <span class="error-text"><?= $errors['course_id'] ?></span>
            <?php endif; ?>
        </div>

        <button type="submit">Complete Enrollment</button>
        <a href="index.php" class="cancel-link">Cancel and Return</a>
    </form>
</div>

</body>
</html>