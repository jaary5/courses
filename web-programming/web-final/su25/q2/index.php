<?php

// form input
$attendees    = (int) $_POST["attendees"];
$seatCapacity = (int) $_POST["seatCapacity"];
$ticketPrice  = (int) $_POST["ticketPrice"];

// calculation
$screenNeeded = ceil($attendees / $seatCapacity);
$emptySeat = ($screenNeeded * $seatCapacity) - $attendees;
$wastedMoney = $ticketPrice * $emptySeat;

//  Fetch
echo "Total Screens: " . $screenNeeded . 
  " | Empty Seat: " . $emptySeat . 
  " | Wasted Money: " . $wastedMoney;
?>