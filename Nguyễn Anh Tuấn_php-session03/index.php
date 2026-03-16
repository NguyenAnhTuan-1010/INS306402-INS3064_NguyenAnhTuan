<?php
declare(strict_types=1);

$base = '/php-session03/';

// Danh sách bài + đường dẫn file
$items = [
  ['Bài 1 — Basic Contact Form', 'contact.html', 'HTML Forms + POST Handling + Basic Validation'],
  ['Bài 2 — Arithmetic Calculator', 'calculator.php', 'Type Casting + Numeric Validation + Switch/Match'],
  ['Bài 3 — Login with Counter', 'login.php', 'State Tracking + Conditionals + Security Basics'],
  ['Bài 4 — Search Query Echo', 'search.php', 'GET Method + XSS Prevention + Query Params'],
  ['Bài 5 — Self-Processing Form', 'contact_self.php', 'Logic/View Mixing + Request Detection + UX Feedback'],
  ['Bài 6 — Validation Library', 'test_utils.php', 'Functions + Reusability + Unit Testing (utils.php)'],
  ['Bài 7 — Sticky Forms', 'sticky.php', 'UX Design + Value Persistence + Error Handling'],
  ['Bài 8 — Multi-Step Flow', 'step1.php', 'Data Persistence + Flow Control + Hidden Inputs (step1/step2)'],
];

function e(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>
<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>PHP Session 03 — Index</title>
  <style>
    body { font-family: Arial, sans-serif; max-width: 920px; margin: 40px auto; padding: 0 16px; }
    h1 { margin-bottom: 6px; }
    .muted { color:#666; margin-top: 0; }
    .grid { display: grid; grid-template-columns: 1fr; gap: 12px; margin-top: 18px; }
    .card { border:1px solid #ddd; border-radius: 12px; padding: 14px; }
    .title { font-weight: 700; font-size: 16px; margin: 0 0 6px; }
    .desc { color:#666; margin: 0 0 10px; }
    .row { display:flex; gap: 10px; flex-wrap: wrap; }
    a.btn {
      display:inline-block; padding: 8px 12px; border:1px solid #333;
      border-radius: 10px; text-decoration: none; color:#111;
    }
    a.btn:hover { opacity: 0.85; }
    code { background:#f5f5f5; padding: 2px 6px; border-radius: 8px; }
    @media (min-width: 820px) {
      .grid { grid-template-columns: 1fr 1fr; }
    }
  </style>
</head>
<body>
  <h1>PHP Session 03</h1>
  <p class="muted">
    Menu bài 1 → 8 (đang chạy trên <code>localhost:8080</code>).  
    Thư mục: <code>C:\xampp\htdocs\php-session03\</code>
  </p>

  <div class="grid">
    <?php foreach ($items as [$title, $file, $desc]): ?>
      <div class="card">
        <p class="title"><?= e($title) ?></p>
        <p class="desc"><?= e($desc) ?></p>
        <div class="row">
          <a class="btn" href="<?= e($base . $file) ?>">Open</a>
          <span class="muted">File: <code><?= e($file) ?></code></span>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="card" style="margin-top: 16px;">
    <p class="title">Quick tips</p>
    <ul class="muted">
      <li>Nếu 404: kiểm tra tên file/folder và đúng port <code>:8080</code>.</li>
      <li>Bài 6: chạy <code>test_utils.php</code> để xem PASS/FAIL.</li>
      <li>Bài 8: bắt đầu từ <code>step1.php</code>.</li>
    </ul>
  </div>
</body>
</html>