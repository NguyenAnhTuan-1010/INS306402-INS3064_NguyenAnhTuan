<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo "<h1>405 - Method Not Allowed</h1>";
  echo "<p>Hãy gửi form bằng POST.</p>";
  echo '<a href="contact.html">Quay lại</a>';
  exit;
}

function get_post($key) {
  return isset($_POST[$key]) ? trim((string)$_POST[$key]) : '';
}

$name    = get_post('name');
$email   = get_post('email');
$subject = get_post('subject');
$message = get_post('message');

$errors = [];

if ($name === '')    $errors[] = "Họ tên không được để trống.";
if ($email === '')   $errors[] = "Email không được để trống.";
if ($subject === '') $errors[] = "Tiêu đề không được để trống.";
if ($message === '') $errors[] = "Tin nhắn không được để trống.";

if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $errors[] = "Email không đúng định dạng.";
}

function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }

if (!empty($errors)) {
  http_response_code(422);
  echo "<h1>Form có lỗi</h1><ul>";
  foreach ($errors as $err) echo "<li>" . e($err) . "</li>";
  echo "</ul>";
  echo '<a href="contact.html">Quay lại</a>';
  exit;
}

echo "<h1>Gửi thành công ✅</h1>";
echo "<p><b>Họ tên:</b> " . e($name) . "</p>";
echo "<p><b>Email:</b> " . e($email) . "</p>";
echo "<p><b>Tiêu đề:</b> " . e($subject) . "</p>";
echo "<p><b>Tin nhắn:</b><br>" . nl2br(e($message)) . "</p>";
echo '<hr><a href="contact.html">Gửi thêm</a>';