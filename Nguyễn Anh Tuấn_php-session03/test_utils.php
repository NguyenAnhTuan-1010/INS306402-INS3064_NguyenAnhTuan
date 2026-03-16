<?php
declare(strict_types=1);

require_once __DIR__ . '/utils.php';

$tests = [];

$tests[] = ['required empty', is_required('') === false];
$tests[] = ['required ok', is_required(' a ') === true];

$tests[] = ['email invalid', is_email('abc@') === false];
$tests[] = ['email ok', is_email('a@gmail.com') === true];

$tests[] = ['min ok', min_len('hello', 3) === true];
$tests[] = ['min fail', min_len('hi', 3) === false];

$tests[] = ['max ok', max_len('hello', 10) === true];
$tests[] = ['max fail', max_len('hello', 3) === false];

$tests[] = ['numeric ok', is_numeric_str('12.5') === true];
$tests[] = ['numeric fail', is_numeric_str('abc') === false];

?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <title>Test Utils</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 720px; margin: 40px auto; }
    .pass { color: green; }
    .fail { color: red; }
  </style>
</head>
<body>
  <h1>utils.php tests</h1>
  <ul>
    <?php foreach ($tests as [$name, $ok]): ?>
      <li class="<?= $ok ? 'pass' : 'fail' ?>">
        <?= e($name) ?> — <?= $ok ? 'PASS' : 'FAIL' ?>
      </li>
    <?php endforeach; ?>
  </ul>
</body>
</html>