<?php

// Connect DB
$conn = new mysqli("localhost", "root", "", "sundarban");
if ($conn->connect_error == false)
    echo "Connection Successful <br><br>";

// Queries - 1. Display the total revenue per category from the database.
$sql1 = "
    SELECT CategoryName, SUM(Revenue) AS total
    FROM sales_data
    GROUP BY CategoryName
";
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    while ($rows = $result1->fetch_assoc()) {
        echo "Category: " . $rows["CategoryName"] . 
        " | Total Revenue: " . $rows["total"] .  "<br>";
    }
} echo "<br>";


// Queries - 2. If a product’s revenue is below 40,000 BDT, update its category to “Low Performing”.
$sql2 = "
    UPDATE sales_data
    SET CategoryName='Low Performing'
    WHERE Revenue<40000
";
$result2 = $conn->query($sql2);
if ($result2) echo "DB updated <br><br>";

// Queries - 3. For all products generating more than 70,000 BDT, add a 10% bonus revenue to their total.
$sql3 = "
    UPDATE sales_data
    SET Revenue=Revenue*1.10
    WHERE Revenue>70000
";
$result3 = $conn->query($sql3);
if ($result3) echo "DB updated <br><br>";

// Queries - 4. Display each product’s name along with its category name and a label “Top Seller” if its revenue is
// above the average revenue of its own category. Otherwise, display “Regular Seller”.
// Subquery bhule gesi
$sql4 = "
    SELECT CategoryName, SUM(Revenue) AS total
    FROM sales_data
    GROUP BY CategoryName
";

$electronicsTotal = 0;
$furnitureTotal = 0;
$lowPerformingTotal = 0;

$result4 = $conn->query($sql4);
if ($result4->num_rows > 0) {
    while ($row = $result4->fetch_assoc()) {
        if ($row["CategoryName"] == 'Electronics') {
            $electronicsTotal = $row["total"];
        } else if ($row["CategoryName"] == 'Furniture') {
            $furnitureTotal = $row["total"];
        } else {
            $lowPerformingTotal = $row["total"];
        }
    }
}

$sql5 = "
    SELECT ProductName, CategoryName, Revenue 
    FROM sales_data
";
$result5 = $conn->query($sql5);
if ($result5->num_rows > 0) {
    while ($row = $result5->fetch_assoc()) {    
        if ($row["CategoryName"] == 'Electronics') {
            $avg = $electronicsTotal / 2;
            $revenue = $row["Revenue"];
            $feedback = "";
            
            if ($revenue > $avg) {
                $feedback = "Top Seller";
            } else {
                $feedback = "Regular Seller";
            }

            echo "Products Name: " . $row["ProductName"] . 
            " | Category Name: " . $row["CategoryName"] . 
            " | Label: " . $feedback . "<br>";

        } else if ($row["CategoryName"] == 'Furniture') {
            $avg = $furnitureTotal / 2;
            $revenue = $row["Revenue"];
            $feedback = "";
            if ($revenue > $avg) {
                $feedback = "Top Seller";
            } else {
                $feedback = "Regular Seller";
            }

            echo "Products Name: " . $row["ProductName"] . 
            " | Category Name: " . $row["CategoryName"] . 
            " | Label: " . $feedback . "<br>";
        } else {
            $avg = $lowPerformingTotal / 2;
            $revenue = $row["Revenue"];
            $feedback = "";
            if ($revenue > $avg) {
                $feedback = "Top Seller";
            } else {
                $feedback = "Regular Seller";
            }

            echo "Products Name: " . $row["ProductName"] . 
            " | Category Name: " . $row["CategoryName"] . 
            " | Label: " . $feedback . "<br>";
        }          
    } 
}

?>