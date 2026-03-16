<?php
session_start();

// ----- cấu hình tài khoản demo -----
const DEMO_USER = 'admin';
const DEMO_PASS = '123456';

// ----- init attempt counter -----
if (!isset($_SESSION['attempts'])) {
  $_SESSION['attempts'] = 0;
}

$username = '';
$message = '';
$errors = [];
$success = false;

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = isset($_POST['username']) ? trim((string)$_POST['username']) : '';
  $password = isset($_POST['password']) ? (string)$_POST['password'] : '';

  // Validate
  if ($username === '') $errors[] = "Username không được để trống.";
  if ($password === '') $errors[] = "Password không được để trống.";

  // Process
  if (empty($errors)) {
    if ($username === DEMO_USER && $password === DEMO_PASS) {
      $success = true;
      $message = "Đăng nhập thành công ✅";
      $_SESSION['attempts'] = 0; // reset khi đúng
      $_SESSION['logged_in'] = true;
    } else {
      $_SESSION['attempts']++;
      $message = "Sai tài khoản hoặc mật khẩu ❌";
      $_SESSION['logged_in'] = false;
    }
  }
}

// Optional: nút reset attempts
if (isset($_GET['reset']) && $_GET['reset'] === '1') {
  $_SESSION['attempts'] = 0;
  $_SESSION['logged_in'] = false;
  header("Location: login.php");
  exit;
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login with Counter</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 720px; margin: 40px auto; padding: 0 16px; }
    label { display:block; margin-top: 14px; font-weight: 600; }
    input { width:100%; padding:10px; margin-top:6px; box-sizing:border-box; }
    button { margin-top:16px; padding:10px 14px; cursor:pointer; }
    .box { margin-top:18px; padding:12px; border:1px solid #ddd; border-radius:8px; }
    .error { background:#fff5f5; border-color:#ffb3b3; }
    .ok { background:#f3fff8; border-color:#b3ffcf; }
    .muted { color:#666; }
    a { color: inherit; }
  </style>
</head>
<body>
  <h1>Login with Counter</h1>

  <p class="muted">
    Tài khoản demo: <b>admin</b> / <b>123456</b>
  </p>

  <form method="POST" autocomplete="off">
    <label>Username</label>
    <input name="username" value="<?= e($username) ?>" />

    <label>Password</label>
    <input name="password" type="password" />

    <button type="submit">Login</button>
  </form>

  <div class="box <?= $success ? 'ok' : (!empty($errors) || $message ? 'error' : '') ?>">
    <b>Attempts:</b> <?= (int)$_SESSION['attempts'] ?>
    <?php if (!empty($errors)): ?>
      <ul>
        <?php foreach ($errors as $err): ?>
          <li><?= e($err) ?></li>
        <?php endforeach; ?>
      </ul>
    <?php elseif ($message): ?>
      <p><?= e($message) ?></p>
    <?php else: ?>
      <p class="muted">Hãy nhập tài khoản để đăng nhập.</p>
    <?php endif; ?>

    <p class="muted">
      <a href="login.php?reset=1">Reset attempts</a>
    </p>
  </div>
</body>
</html>