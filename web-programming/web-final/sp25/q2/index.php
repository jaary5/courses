<?php

// Form input collection
$attendees     = (int) $_POST["attendees"];
$costPerPerson = (int) $_POST["costPerPerson"];
$venueCapacity = (int) $_POST["venueCapacity"];

// Calculation 
$venueNeeded = ceil($attendees / $venueCapacity);
$emptySeat = ($venueNeeded * $venueCapacity) - $attendees;
$moneyWasted = $emptySeat * $costPerPerson;

// Feedback
echo "Total Venues: " . $venueNeeded . 
    " | Empty Seats: " . $emptySeat . 
    " | Wasted Money: " . $moneyWasted;
?>