<?php
declare(strict_types=1);
require_once __DIR__ . '/utils.php';

$name = post_str('name');
$email = post_str('email');

$plan = '';
$errors = [];
$done = false;

// Nếu user vào step2 trực tiếp không qua step1
if ($name === '' || $email === '') {
  header("Location: step1.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $plan = post_str('plan');

  $data = ['plan' => $plan];
  $rules = ['plan' => ['required' => true, 'min' => 2, 'max' => 30]];
  $errors = validate($data, $rules);

  if (empty($errors)) {
    $done = true;
  }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Step 2</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 720px; margin: 40px auto; padding: 0 16px; }
    label { display:block; margin-top: 14px; font-weight: 600; }
    input, select { width:100%; padding:10px; margin-top:6px; box-sizing:border-box; }
    button { margin-top:16px; padding:10px 14px; cursor:pointer; }
    .box { margin-top:18px; padding:12px; border:1px solid #ddd; border-radius:8px; }
    .err { color:#b00020; font-size:14px; margin-top:6px; }
    .ok { background:#f3fff8; border-color:#b3ffcf; }
  </style>
</head>
<body>
  <h1>Multi-Step Flow — Step 2</h1>

  <?php if ($done): ?>
    <div class="box ok">
      <b>Hoàn tất ✅</b>
      <p><b>Họ tên:</b> <?= e($name) ?></p>
      <p><b>Email:</b> <?= e($email) ?></p>
      <p><b>Plan:</b> <?= e($plan) ?></p>
      <p><a href="step1.php">Làm lại</a></p>
    </div>
  <?php else: ?>
    <p><b>Dữ liệu từ Step 1:</b> <?= e($name) ?> — <?= e($email) ?></p>

    <form method="POST" novalidate>
      <!-- hidden inputs để giữ data từ step1 -->
      <input type="hidden" name="name" value="<?= e($name) ?>">
      <input type="hidden" name="email" value="<?= e($email) ?>">

      <label>Chọn gói (plan) *</label>
      <select name="plan" required>
        <option value="">-- Chọn --</option>
        <option value="basic" <?= $plan==='basic'?'selected':'' ?>>basic</option>
        <option value="pro" <?= $plan==='pro'?'selected':'' ?>>pro</option>
        <option value="vip" <?= $plan==='vip'?'selected':'' ?>>vip</option>
      </select>
      <?php if (isset($errors['plan'])): ?><div class="err"><?= e($errors['plan']) ?></div><?php endif; ?>

      <button type="submit">Hoàn tất</button>
    </form>

    <p style="margin-top:14px;">
      <a href="step1.php">← Quay lại Step 1</a>
    </p>
  <?php endif; ?>
</body>
</html>