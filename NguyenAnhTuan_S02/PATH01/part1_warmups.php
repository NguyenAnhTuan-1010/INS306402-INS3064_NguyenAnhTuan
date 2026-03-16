<?php
echo "<h1>Part 1 - Warm-up Exercises</h1><hr>";

// 01 Hello Strings
$name = "Alice";
$city = "Paris";
echo "<h3>01) Hello Strings</h3>";
echo "$name lives in $city.<br><br>";

// 02 Math Ops
$x = 10; $y = 5;
echo "<h3>02) Math Ops</h3>";
echo ($x+$y).", ".($x-$y).", ".($x*$y).", ".($x/$y)."<br><br>";

// 03 Casting
echo "<h3>03) Casting</h3>";
$raw = "25.50";
$f = (float)$raw;
$i = (int)$f;
echo gettype($f)."($f), ".gettype($i)."($i)<br><br>";

// 04 Truthiness
echo "<h3>04) Truthiness</h3>";
$isOnline = true;
echo ($isOnline ? "User is Online" : "User is Offline")."<br><br>";

// 05 Array Init
echo "<h3>05) Array Init</h3>";
$fruits = ["Apple", "Banana", "Pear"];
echo $fruits[1]."<br><br>";

// 06 Sentence Builder
echo "<h3>06) Sentence Builder</h3>";
$sentence = "PHP";
$sentence .= " is";
$sentence .= " fun";
echo $sentence."<br><br>";

// 07 Strict Check
echo "<h3>07) Strict Check</h3>";
echo (5 == "5" ? "Equal (True)" : "Equal (False)") . "<br>";
echo (5 === "5" ? "Identical (True)" : "Identical (False)") . "<br><br>";

// 08 Logic Gate
echo "<h3>08) Logic Gate</h3>";
$age = 20;
$hasTicket = true;
echo (($age >= 18 && $hasTicket) ? "Enter" : "Deny") . "<br><br>";
