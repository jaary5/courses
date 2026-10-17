<?php

// input 
$creditPerCourse = $_POST["creditEarned"];
$coursesCompleted = $_POST["courseCompleted"];
$targetCredit = $_POST["target"];

// calculation
$totalCredits = $creditPerCourse * $coursesCompleted;
$progress = "";
if ($totalCredits >= 120) $progress = "Excellent";
else if ($totalCredits >= 90) $progress = "Good";
else if ($totalCredits >= 60) $progress = "Average";
else $progress = "Poor";

$feedback = "";
if ($targetCredit == $totalCredits) $feedback = "Target met exactly (0 diff)";
else if ($targetCredit > $totalCredits) {
    $res = abs($targetCredit - $totalCredits);
    $feedback = "Below target by " . $res;
} else {
    $res = abs($targetCredit - $totalCredits);
    $feedback = "Above target by " . $res;    
}

// fetch
echo "Progress: " . $progress . 
   " | Result: " . $feedback . "<br>"

?>