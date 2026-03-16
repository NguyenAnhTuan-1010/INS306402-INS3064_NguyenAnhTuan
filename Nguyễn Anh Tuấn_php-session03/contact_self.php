<?php
session_start();

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

$name = '';
$email = '';
$subject = '';
$message = '';
$errors = [];
$success_msg = '';

// 1) Nếu vừa redirect từ POST thành công (PRG)
if (isset($_GET['success']) && $_GET['success'] === '1') {
  $success_msg = isset($_SESSION['flash_success']) ? (string)$_SESSION['flash_success'] : 'Gửi thành công ✅';
  unset($_SESSION['flash_success']);
}

// 2) Nếu POST thì validate + process
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name    = isset($_POST['name']) ? trim((string)$_POST['name']) : '';
  $email   = isset($_POST['email']) ? trim((string)$_POST['email']) : '';
  $subject = isset($_POST['subject']) ? trim((string)$_POST['subject']) : '';
  $message = isset($_POST['message']) ? trim((string)$_POST['message']) : '';

  if ($name === '') $errors[] = "Họ tên không được để trống.";
  if ($email === '') $errors[] = "Email không được để trống.";
  if ($subject === '') $errors[] = "Tiêu đề không được để trống.";
  if ($message === '') $errors[] = "Tin nhắn không được để trống.";

  if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Email không đúng định dạng.";
  }

  // 3) Process: nếu OK -> redirect (PRG)
  if (empty($errors)) {
    // Demo: chỉ flash message (thực tế có thể lưu DB / gửi mail)
    $_SESSION['flash_success'] = "Cảm ơn " . $name . "! Mình đã nhận được tin nhắn của bạn.";
    header("Location: contact_self.php?success=1");
    exit;
  }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Self-Processing Form</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 720px; margin: 40px auto; padding: 0 16px; }
    label { display:block; margin-top: 14px; font-weight: 600; }
    input, textarea { width:100%; padding:10px; margin-top:6px; box-sizing:border-box; }
    button { margin-top:16px; padding:10px 14px; cursor:pointer; }
    .box { margin-top:18px; padding:12px; border:1px solid #ddd; border-radius:8px; }
    .error { background:#fff5f5; border-color:#ffb3b3; }
    .ok { background:#f3fff8; border-color:#b3ffcf; }
  </style>
</head>
<body>
  <h1>Self-Processing Contact Form</h1>

  <?php if ($success_msg): ?>
    <div class="box ok">
      <b><?= e($success_msg) ?></b>
    </div>
  <?php endif; ?>

  <?php if (!empty($errors)): ?>
    <div class="box error">
      <b>Form có lỗi:</b>
      <ul>
        <?php foreach ($errors as $err): ?>
          <li><?= e($err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="POST" novalidate>
    <label>Họ tên *</label>
    <input name="name" value="<?= e($name) ?>" />

    <label>Email *</label>
    <input name="email" value="<?= e($email) ?>" />

    <label>Tiêu đề *</label>
    <input name="subject" value="<?= e($subject) ?>" />

    <label>Tin nhắn *</label>
    <textarea name="message" rows="6"><?= e($message) ?></textarea>

    <button type="submit">Gửi</button>
  </form>
</body>
</html>