<?php

// Connection
$conn = new mysqli("localhost", "root", "", "uiutech_final");
if ($conn->connect_error == false)
    echo "Connection Successful <br><br>";

// query
$sql1 = "
    SELECT PerformanceRating, COUNT(*) AS total
    FROM employee_final
    GROUP BY PerformanceRating
";
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        echo "Performance Rating: " . $row["PerformanceRating"] . 
        " | Total: " .  $row["total"] . "<br>";
    }
} echo "<br>";

$sql2 = "
    UPDATE employee_final
    SET PerformanceRating='C'
    WHERE Salary<40000 AND PerformanceRating!='D'
";
$result2 = $conn->query($sql2);
if ($result2) echo "DB updated<br><br>";

$sql3 = "
    UPDATE employee_final
    SET Salary=Salary+5000
    WHERE Salary>50000 AND Salary+5000<=60000
";
$result3 = $conn->query($sql3);
if ($result3) echo "DB updated <br><br>";

$sql4 = "
    SELECT DepartmentName, COUNT(*) AS total
    FROM employee_final
    GROUP BY DepartmentName
    ORDER BY COUNT(*) DESC
";
$result4 = $conn->query($sql4);
if ($result4->num_rows > 0) {
    while ($row = $result4->fetch_assoc()) {
        echo "Department: " . $row["DepartmentName"] . 
        " | Employees: " . $row["total"] .  "<br>" ;
    }
}

// connection close
$conn->close();
?>