<?php
echo "<h1>Part 2 - Core Challenges</h1>";
echo "<hr>";

// ========================
// 01) Grade Bot
// ========================
echo "<h3>01) Grade Bot</h3>";

$score = 85;

if ($score >= 90) {
    $grade = "A";
} elseif ($score >= 80) {
    $grade = "B";
} elseif ($score >= 70) {
    $grade = "C";
} else {
    $grade = "F";
}

echo "Score: $score<br>";
echo "Grade: $grade<hr>";

// ========================
// 02) Day Planner
// ========================
echo "<h3>02) Day Planner</h3>";

$day = 3;

switch ($day) {
    case 1: $name = "Monday"; break;
    case 2: $name = "Tuesday"; break;
    case 3: $name = "Wednesday"; break;
    case 4: $name = "Thursday"; break;
    case 5: $name = "Friday"; break;
    case 6: $name = "Saturday"; break;
    case 7: $name = "Sunday"; break;
    default: $name = "Invalid"; break;
}

echo "Input: $day<br>";
echo "Output: $name<hr>";

// ========================
// 03) Multi-Table
// ========================
echo "<h3>03) Multi-Table (5x5)</h3>";
echo "<pre>";
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= 5; $j++) {
        echo str_pad($i * $j, 4, " ", STR_PAD_LEFT);
    }
    echo "\n";
}
echo "</pre><hr>";

// ========================
// 04) Cart Total
// ========================
echo "<h3>04) Cart Total</h3>";

$prices = [10, 20, 5];
$total = 0;

foreach ($prices as $p) {
    $total += $p;
}

echo "Prices: [" . implode(", ", $prices) . "]<br>";
echo "Total: $total<hr>";

// ========================
// 05) Countdown
// ========================
echo "<h3>05) Countdown</h3>";

$n = 10;
while ($n >= 1) {
    echo $n;
    if ($n > 1) echo ", ";
    $n--;
}
echo ", Liftoff!<hr>";

// ========================
// 06) Even Filter
// ========================
echo "<h3>06) Even Filter</h3>";

$evens = [];
for ($i = 1; $i <= 20; $i++) {
    if ($i % 2 == 0) {
        $evens[] = $i;
    }
}
echo implode(", ", $evens) . "<hr>";

// ========================
// 07) Array Reverse
// ========================
echo "<h3>07) Array Reverse</h3>";

$arr = [1, 2, 3];
$reversed = [];

for ($i = count($arr) - 1; $i >= 0; $i--) {
    $reversed[] = $arr[$i];
}

echo "Input: [" . implode(", ", $arr) . "]<br>";
echo "Output: [" . implode(", ", $reversed) . "]<hr>";

// ========================
// 08) FizzBuzz
// ========================
echo "<h3>08) FizzBuzz</h3>";

$out = [];
for ($i = 1; $i <= 50; $i++) {
    if ($i % 15 == 0) {
        $out[] = "FizzBuzz";
    } elseif ($i % 3 == 0) {
        $out[] = "Fizz";
    } elseif ($i % 5 == 0) {
        $out[] = "Buzz";
    } else {
        $out[] = $i;
    }
}

echo implode(", ", $out);
