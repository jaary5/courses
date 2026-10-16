<?php

// Form input collection
$numOfStudents = (int) $_POST["numOfStudents"];
$slicePerStudent = (int) $_POST["slicePerStudent"];
$slicePerPizza = (int) $_POST["slicePerPizza"];

// Calculation
$pizzaNeeded = ceil($slicePerStudent * $numOfStudents / $slicePerPizza);
$leftOverSlices = ($pizzaNeeded * $slicePerPizza) - ($slicePerStudent * $numOfStudents);
$wastedMoney = (1050 / $slicePerPizza) * $leftOverSlices;  

// Feedback
echo "Total Pizzas: $pizzaNeeded | LeftOver Slices: $leftOverSlices | Wasted Money(BDT): $wastedMoney";

?>