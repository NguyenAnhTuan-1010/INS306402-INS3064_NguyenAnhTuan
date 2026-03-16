<?php
declare(strict_types=1);

/**
 * utils.php - Validation/Sanitization helpers
 */

function e(string $s): string {
  return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

function post_str(string $key): string {
  return isset($_POST[$key]) ? trim((string)$_POST[$key]) : '';
}

function get_str(string $key): string {
  return isset($_GET[$key]) ? trim((string)$_GET[$key]) : '';
}

function is_required(string $value): bool {
  return trim($value) !== '';
}

function is_email(string $value): bool {
  if ($value === '') return false;
  return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
}

function min_len(string $value, int $min): bool {
  return mb_strlen($value) >= $min;
}

function max_len(string $value, int $max): bool {
  return mb_strlen($value) <= $max;
}

function is_numeric_str(string $value): bool {
  return $value !== '' && is_numeric($value);
}

/**
 * Validate with rules. Returns array of errors keyed by field.
 * Example rules:
 *  [
 *    'email' => ['required' => true, 'email' => true],
 *    'name'  => ['required' => true, 'min' => 2, 'max' => 50]
 *  ]
 */
function validate(array $data, array $rules): array {
  $errors = [];

  foreach ($rules as $field => $r) {
    $val = isset($data[$field]) ? (string)$data[$field] : '';

    if (($r['required'] ?? false) && !is_required($val)) {
      $errors[$field] = 'Trường này không được để trống.';
      continue;
    }

    if (($r['email'] ?? false) && $val !== '' && !is_email($val)) {
      $errors[$field] = 'Email không đúng định dạng.';
      continue;
    }

    if (isset($r['min']) && $val !== '' && !min_len($val, (int)$r['min'])) {
      $errors[$field] = 'Độ dài tối thiểu là ' . (int)$r['min'] . ' ký tự.';
      continue;
    }

    if (isset($r['max']) && $val !== '' && !max_len($val, (int)$r['max'])) {
      $errors[$field] = 'Độ dài tối đa là ' . (int)$r['max'] . ' ký tự.';
      continue;
    }

    if (($r['numeric'] ?? false) && $val !== '' && !is_numeric_str($val)) {
      $errors[$field] = 'Giá trị phải là số.';
      continue;
    }
  }

  return $errors;
}