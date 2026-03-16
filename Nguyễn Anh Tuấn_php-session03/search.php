<?php
$q = isset($_GET['q']) ? trim((string)$_GET['q']) : '';
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Search Query Echo</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 720px; margin: 40px auto; padding: 0 16px; }
    label { display:block; margin-top: 14px; font-weight: 600; }
    input { width:100%; padding:10px; margin-top:6px; box-sizing:border-box; }
    button { margin-top:16px; padding:10px 14px; cursor:pointer; }
    .box { margin-top:18px; padding:12px; border:1px solid #ddd; border-radius:8px; }
    .muted { color:#666; }
  </style>
</head>
<body>
  <h1>Search Query Echo</h1>

  <form method="GET">
    <label>Search</label>
    <input name="q" value="<?= e($q) ?>" placeholder="Nhập từ khóa..." />
    <button type="submit">Tìm</button>
  </form>

  <div class="box">
    <?php if ($q === ''): ?>
      <p class="muted">Chưa có từ khóa. Hãy nhập và bấm Tìm.</p>
    <?php else: ?>
      <p><b>Bạn đang tìm:</b> <?= e($q) ?></p>
      <p class="muted">URL hiện tại: <code>?q=<?= e($q) ?></code></p>
    <?php endif; ?>
  </div>

  <p class="muted">
    Test XSS: thử nhập <code>&lt;script&gt;alert(1)&lt;/script&gt;</code> → phải hiển thị dạng text, không được chạy.
  </p>
</body>
</html>