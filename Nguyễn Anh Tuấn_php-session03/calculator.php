<?php
$num1 = '';
$num2 = '';
$op = '+';
$result = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $num1 = isset($_POST['num1']) ? trim((string)$_POST['num1']) : '';
  $num2 = isset($_POST['num2']) ? trim((string)$_POST['num2']) : '';
  $op   = isset($_POST['op']) ? trim((string)$_POST['op']) : '+';

  if ($num1 === '' || !is_numeric($num1)) $errors[] = "Số thứ nhất không hợp lệ.";
  if ($num2 === '' || !is_numeric($num2)) $errors[] = "Số thứ hai không hợp lệ.";

  $allowed = ['+','-','*','/'];
  if (!in_array($op, $allowed, true)) $errors[] = "Phép toán không hợp lệ.";

  if (empty($errors)) {
    $a = (float)$num1;
    $b = (float)$num2;

    switch ($op) {
      case '+': $result = $a + $b; break;
      case '-': $result = $a - $b; break;
      case '*': $result = $a * $b; break;
      case '/':
        if ($b == 0.0) $errors[] = "Không thể chia cho 0.";
        else $result = $a / $b;
        break;
    }
  }
}

function e($s){ return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Calculator</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 720px; margin: 40px auto; padding: 0 16px; }
    label { display:block; margin-top: 14px; font-weight: 600; }
    input, select { width:100%; padding:10px; margin-top:6px; box-sizing: border-box; }
    button { margin-top:16px; padding:10px 14px; cursor:pointer; }
    .box { margin-top:18px; padding:12px; border:1px solid #ddd; border-radius:8px; }
  </style>
</head>
<body>
  <h1>Arithmetic Calculator</h1>

  <form method="POST">
    <label>Số thứ nhất</label>
    <input name="num1" value="<?= e($num1) ?>" placeholder="VD: 12.5">

    <label>Phép toán</label>
    <select name="op">
      <option value="+" <?= $op==='+'?'selected':'' ?>>+</option>
      <option value="-" <?= $op==='-'?'selected':'' ?>>-</option>
      <option value="*" <?= $op==='*'?'selected':'' ?>>*</option>
      <option value="/" <?= $op==='/'?'selected':'' ?>>/</option>
    </select>

    <label>Số thứ hai</label>
    <input name="num2" value="<?= e($num2) ?>" placeholder="VD: 3">

    <button type="submit">Tính</button>
  </form>

  <?php if (!empty($errors)): ?>
    <div class="box">
      <b>Lỗi:</b>
      <ul>
        <?php foreach ($errors as $err): ?>
          <li><?= e($err) ?></li>
        <?php endforeach; ?>
      </ul>
    </div>
  <?php elseif ($result !== null): ?>
    <div class="box">
      <b>Kết quả:</b>
      <p><?= e($num1) ?> <?= e($op) ?> <?= e($num2) ?> = <b><?= e($result) ?></b></p>
    </div>
  <?php endif; ?>
</body>
</html>