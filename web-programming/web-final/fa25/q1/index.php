<?php

// collecting form input
$ct1 = $_POST["ct1"];
$ct2 = $_POST["ct2"];
$ct3 = $_POST["ct3"];
$mid = $_POST["mid"];
$final = $_POST["final"];

// calculation
$ctMin = min($ct1, $ct2, $ct3);
$bestTwo = ($ct1 + $ct2 + $ct3) - $ctMin;
$total = $bestTwo + $mid + $final;

// Data fetch
echo "Best two CT's total: " . $bestTwo . "<br>";
echo "Midterm Marks:       " . $mid . "<br>";
echo "Finalterm Marks:     " . $final . "<br><br>";
echo "Total Marks:         " . $total . "<br>";
if ($total > 54) echo "Status: Passed";
else echo "Status: Failed";

?>