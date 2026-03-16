<?php
declare(strict_types=1);
require_once __DIR__ . '/utils.php';

$data = [
  'name' => '',
  'email' => '',
  'subject' => '',
  'message' => '',
];

$errors = [];
$success = false;

$rules = [
  'name' => ['required' => true, 'min' => 2, 'max' => 50],
  'email' => ['required' => true, 'email' => true, 'max' => 100],
  'subject' => ['required' => true, 'min' => 3, 'max' => 80],
  'message' => ['required' => true, 'min' => 10, 'max' => 1000],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($data as $k => $_) {
    $data[$k] = post_str($k);
  }

  $errors = validate($data, $rules);

  if (empty($errors)) {
    $success = true;
  }
}

function field_error(array $errors, string $key): string {
  return $errors[$key] ?? '';
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Sticky Forms</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 720px; margin: 40px auto; padding: 0 16px; }
    label { display:block; margin-top: 14px; font-weight: 600; }
    input, textarea { width:100%; padding:10px; margin-top:6px; box-sizing:border-box; }
    button { margin-top:16px; padding:10px 14px; cursor:pointer; }
    .msg { margin-top: 12px; font-size: 14px; }
    .err { color: #b00020; }
    .ok { color: #0a7a2f; }
    .field-err { border: 1px solid #b00020; }
  </style>
</head>
<body>
  <h1>Sticky Forms</h1>

  <?php if ($success): ?>
    <p class="msg ok"><b>Gửi thành công ✅</b> (Form vẫn giữ dữ liệu là chủ ý của bài 7)</p>
  <?php elseif (!empty($errors)): ?>
    <p class="msg err"><b>Form có lỗi:</b> hãy sửa các trường bên dưới.</p>
  <?php endif; ?>

  <form method="POST" novalidate>
    <label>Họ tên *</label>
    <input
      name="name"
      required
      minlength="2"
      maxlength="50"
      value="<?= e($data['name']) ?>"
      class="<?= field_error($errors, 'name') ? 'field-err' : '' ?>"
    />
    <?php if (field_error($errors, 'name')): ?>
      <div class="msg err"><?= e(field_error($errors, 'name')) ?></div>
    <?php endif; ?>

    <label>Email *</label>
    <input
      name="email"
      type="email"
      required
      maxlength="100"
      value="<?= e($data['email']) ?>"
      class="<?= field_error($errors, 'email') ? 'field-err' : '' ?>"
    />
    <?php if (field_error($errors, 'email')): ?>
      <div class="msg err"><?= e(field_error($errors, 'email')) ?></div>
    <?php endif; ?>

    <label>Tiêu đề *</label>
    <input
      name="subject"
      required
      minlength="3"
      maxlength="80"
      value="<?= e($data['subject']) ?>"
      class="<?= field_error($errors, 'subject') ? 'field-err' : '' ?>"
    />
    <?php if (field_error($errors, 'subject')): ?>
      <div class="msg err"><?= e(field_error($errors, 'subject')) ?></div>
    <?php endif; ?>

    <label>Tin nhắn *</label>
    <textarea
      name="message"
      required
      minlength="10"
      maxlength="1000"
      rows="6"
      class="<?= field_error($errors, 'message') ? 'field-err' : '' ?>"
    ><?= e($data['message']) ?></textarea>
    <?php if (field_error($errors, 'message')): ?>
      <div class="msg err"><?= e(field_error($errors, 'message')) ?></div>
    <?php endif; ?>

    <button type="submit">Gửi</button>
  </form>
</body>
</html>