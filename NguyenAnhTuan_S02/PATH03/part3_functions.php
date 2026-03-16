<?php
declare(strict_types=1);

echo "<h1>Part 3 - Function Challenges</h1>";
echo "<hr>";

// ========================
// 01) Greeter
// greet(string $name): string
// ========================
function greet(string $name): string {
    $name = trim($name);
    if ($name === '') return "Hello!";
    return "Hello, " . $name . "!";
}

echo "<h3>01) Greeter</h3>";
echo "Input: greet(\"Sam\")<br>";
echo "Output: " . greet("Sam") . "<hr>";


// ========================
// 02) Area Calc
// area(float $w, float $h): float
// ========================
function area(float $w, float $h): float {
    if ($w < 0 || $h < 0) return 0.0; // edge case
    return $w * $h;
}

echo "<h3>02) Area Calc</h3>";
echo "Input: area(5.5, 2)<br>";
echo "Output: " . area(5.5, 2) . "<hr>";


// ========================
// 03) Adult Check
// isAdult(?int $age): bool
// ========================
function isAdult(?int $age): bool {
    if ($age === null) return false;
    if ($age < 0) return false;
    return $age >= 18;
}

echo "<h3>03) Adult Check</h3>";
echo "Input: isAdult(null)<br>";
echo "Output: " . (isAdult(null) ? "true" : "false") . "<br><br>";
echo "Input: isAdult(20)<br>";
echo "Output: " . (isAdult(20) ? "true" : "false") . "<hr>";


// ========================
// 04) Safe Divide
// safeDiv(float $a, float $b): ?float
// Divide two numbers. Return null if denominator is 0.
// ========================
function safeDiv(float $a, float $b): ?float {
    if ($b == 0.0) return null;
    return $a / $b;
}

echo "<h3>04) Safe Divide</h3>";
echo "Input: safeDiv(10, 0)<br>";
$result = safeDiv(10, 0);
echo "Output: " . ($result === null ? "null" : (string)$result) . "<hr>";


// ========================
// 05) Formatter
// fmt(float $amt, string $c = '$'): string
// Format price with default currency
// ========================
function fmt(float $amt, string $c = '$'): string {
    // format 2 decimal places, thousands separator
    $formatted = number_format($amt, 2, '.', ',');
    return $c . $formatted;
}

echo "<h3>05) Formatter</h3>";
echo "Input: fmt(50)<br>";
echo "Output: " . fmt(50) . "<br><br>";
echo "Input: fmt(1234.5, \"₫\")<br>";
echo "Output: " . fmt(1234.5, "₫") . "<hr>";


// ========================
// 06) Pure Math
// add(int $a, int $b): int
// A pure function (no side effects/echo), just return
// ========================
function add(int $a, int $b): int {
    return $a + $b;
}

echo "<h3>06) Pure Math</h3>";
echo "Input: add(7, 8)<br>";
echo "Output: " . add(7, 8) . "<hr>";
