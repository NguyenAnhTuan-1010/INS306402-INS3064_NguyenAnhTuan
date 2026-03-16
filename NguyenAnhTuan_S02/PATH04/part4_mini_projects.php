<?php
declare(strict_types=1);

echo "<h1>Part 4 - Mini Projects</h1>";
echo "<hr>";

/**
 * Helper: print a section title
 */
function sectionTitle(string $title): void {
    echo "<h2 style='margin-top:24px;'>$title</h2>";
}

/**
 * Helper: safe output
 */
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

/* =========================================================
   01) BMI Calculator
   Requirements:
   - Define function calculateBMI($kg, $m)
   - Logic: BMI = kg / (m*m)
   - Determine Category: <18.5 Under, 18.5-24.9 Normal, 25+ Over
   ========================================================= */

function calculateBMI(float $kg, float $m): float {
    if ($kg <= 0 || $m <= 0) return 0.0;         // edge case
    return $kg / ($m * $m);
}

function bmiCategory(float $bmi): string {
    if ($bmi <= 0) return "Invalid";
    if ($bmi < 18.5) return "Under";
    if ($bmi < 25.0) return "Normal";
    return "Over";
}

sectionTitle("01) BMI Calculator");

// Example input (bạn có thể đổi số)
$kg = 70.0;
$m  = 1.78;

$bmi = calculateBMI($kg, $m);
$cat = bmiCategory($bmi);

echo "Input: kg = {$kg}, m = {$m}<br>";
echo "Output: BMI = " . number_format($bmi, 1) . " ({$cat})";
echo "<hr>";

/* =========================================================
   02) Student List
   Requirements:
   - Multi-dimensional array: [['name'=>'A','grade'=>90], ...]
   - Loop through array
   - Print an HTML table row for each student
   ========================================================= */

sectionTitle("02) Student List");

// Example data
$students = [
    ['name' => 'A', 'grade' => 90],
    ['name' => 'B', 'grade' => 85],
    ['name' => 'C', 'grade' => 72],
    ['name' => 'D', 'grade' => 96],
];

echo "
<style>
  table { border-collapse: collapse; width: 520px; max-width: 100%; }
  th, td { border: 1px solid #ccc; padding: 10px 12px; text-align: left; }
  th { background: #f3f3f3; }
  caption { caption-side: top; font-weight: 700; font-size: 20px; margin-bottom: 10px; }
</style>
";

echo "<table>";
echo "<caption>Student List</caption>";
echo "<thead><tr><th>#</th><th>Name</th><th>Grade</th></tr></thead>";
echo "<tbody>";

foreach ($students as $i => $student) {
    $name  = isset($student['name']) ? (string)$student['name'] : '';
    $grade = isset($student['grade']) ? (int)$student['grade'] : 0;

    echo "<tr>";
    echo "<td>" . ($i + 1) . "</td>";
    echo "<td>" . e($name) . "</td>";
    echo "<td>" . $grade . "</td>";
    echo "</tr>";
}

echo "</tbody></table>";
echo "<hr>";

/* =========================================================
   03) Prime Seeker
   Requirements:
   - Create utility function isPrime(int $n): bool
   - Loop 1 to 100
   - Print number ONLY if prime
   ========================================================= */

function isPrime(int $n): bool {
    if ($n < 2) return false;
    if ($n === 2) return true;
    if ($n % 2 === 0) return false;

    $limit = (int)floor(sqrt($n));
    for ($i = 3; $i <= $limit; $i += 2) {
        if ($n % $i === 0) return false;
    }
    return true;
}

sectionTitle("03) Prime Seeker (1..100)");

$primes = [];
for ($n = 1; $n <= 100; $n++) {
    if (isPrime($n)) $primes[] = $n;
}

echo "Output: ";
echo implode(", ", $primes);
echo "<hr>";

/* =========================================================
   04) Scoreboard
   Requirements:
   - Input: Array of random integers
   - Calculate: Average, Max, Min
   - Filter: Create new array of scores > Average
   - Output example: "Avg: 75, Top: [80, 98]"
   ========================================================= */

sectionTitle("04) Scoreboard");

// Example input (bạn có thể đổi mảng này)
$scores = [65, 70, 80, 98, 62];

function calcAverage(array $nums): float {
    if (count($nums) === 0) return 0.0;
    $sum = array_sum($nums);
    return $sum / count($nums);
}

function calcMin(array $nums): int {
    if (count($nums) === 0) return 0;
    return (int)min($nums);
}

function calcMax(array $nums): int {
    if (count($nums) === 0) return 0;
    return (int)max($nums);
}

$avg = calcAverage($scores);
$min = calcMin($scores);
$max = calcMax($scores);

// Filter scores > average
$top = [];
foreach ($scores as $s) {
    if ($s > $avg) $top[] = $s;
}

echo "Input: [" . implode(", ", $scores) . "]<br>";
echo "Avg: " . number_format($avg, 2) . "<br>";
echo "Min: {$min}<br>";
echo "Max: {$max}<br>";
echo "Top (> Avg): [" . implode(", ", $top) . "]<br>";

// đúng format kiểu ví dụ trong đề
echo "<br><strong>Output:</strong> \"Avg: " . (int)round($avg) . ", Top: [" . implode(", ", $top) . "]\"";
echo "<hr>";

