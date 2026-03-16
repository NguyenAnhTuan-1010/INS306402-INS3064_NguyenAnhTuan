<?php
declare(strict_types=1);
require_once __DIR__ . '/utils.php';

$name = '';
$email = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = post_str('name');
  $email = post_str('email');

  $data = ['name' => $name, 'email' => $email];
  $rules = [
    'name' => ['required' => true, 'min' => 2, 'max' => 50],
    'email' => ['required' => true, 'email' => true, 'max' => 100],
  ];
  $errors = validate($data, $rules);

  if (empty($errors)) {
    // Sang step2 bằng POST (hidden inputs)
    // (Có thể redirect bằng query, nhưng bài yêu cầu hidden inputs)
    ?>
    <!doctype html>
    <html><head><meta charset="utf-8"><title>Redirect to Step2</title></head>
    <body onload="document.forms[0].submit()">
      <form method="POST" action="step2.php">
        <input type="hidden" name="name" value="<?= e($name) ?>">
        <input type="hidden" name="email" value="<?= e($email) ?>">
      </form>
      <p>Đang chuyển sang bước 2...</p>
    </body></html>
    <?php
    exit;
  }
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Step 1</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 720px; margin: 40px auto; padding: 0 16px; }
    label { display:block; margin-top: 14px; font-weight: 600; }
    input { width:100%; padding:10px; margin-top:6px; box-sizing:border-box; }
    button { margin-top:16px; padding:10px 14px; cursor:pointer; }
    .err { color:#b00020; font-size:14px; margin-top:6px; }
  </style>
</head>
<body>
  <h1>Multi-Step Flow — Step 1</h1>

  <form method="POST" novalidate>
    <label>Họ tên *</label>
    <input name="name" required minlength="2" maxlength="50" value="<?= e($name) ?>">
    <?php if (isset($errors['name'])): ?><div class="err"><?= e($errors['name']) ?></div><?php endif; ?>

    <label>Email *</label>
    <input name="email" type="email" required maxlength="100" value="<?= e($email) ?>">
    <?php if (isset($errors['email'])): ?><div class="err"><?= e($errors['email']) ?></div><?php endif; ?>

    <button type="submit">Tiếp tục</button>
  </form>
</body>
</html>