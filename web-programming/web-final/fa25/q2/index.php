<?php

// form data collection
$itemSold = $_POST["itemSold"];
$saleRuns = $_POST["saleRuns"];
$targetSale = $_POST["targetSale"];

// calculation
$totalItems = $itemSold * $saleRuns;

$performance = "";
if ($totalItems >= 500) $performance = 'Excellent';
else if ($totalItems >= 300) $performance = 'Good';
else if ($totalItems >= 150) $performance = 'Average';
else $performance = "Poor";

$targetMet = "";
if ($targetSale == $totalItems) {
    $targetMet = "Target met exactly";
} else if ($targetSale != $totalItems) {
    $res = abs($targetSale - $totalItems);
    
    if ($targetSale > $totalItems) {
        $targetMet = "Below target by $res";
    } else {
        $targetMet = "Above target by $res";
    }
}

// Fetch data 
echo "Total Items Sold: " . $totalItems . 
    " | Performance: " . $performance . 
    " | Result: " . $targetMet;
?>