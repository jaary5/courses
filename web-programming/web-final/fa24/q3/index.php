<?php

// Connection ===============================================
$conn = new mysqli("localhost", "root", "", "uiuweb_final");
if ($conn->connect_error  == false) 
    echo "connection successful <br><br>";

// Select query =============================================
$sql1 = "
    SELECT LetterGrade, COUNT(*) AS total_students 
    FROM student_final
    GROUP BY LetterGrade;
";

$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        echo "LetterGrade: " . $row["LetterGrade"] . " got " . $row["total_students"] . "<br>";
    }
}
echo "<br>";

// Update query ===============================================
$sql2 = "
    UPDATE student_final
    SET LetterGrade='C'
    WHERE Grade<75 AND LetterGrade!='D'
";
$result2 = $conn->query($sql2);
if ($result2) 
    echo "DB updated successfully <br><br>"; 


$sql3 = "
    UPDATE student_final
    SET Grade=Grade+5
    WHERE Grade>80 AND Grade+5<=90
";
$result3 = $conn->query($sql3);
if ($result3)
    echo "DB updated succesffully <br><br>";

$sql4 = "
    SELECT CourseTitle, COUNT(*) AS total_students
    FROM student_final
    GROUP BY CourseTitle
    ORDER BY COUNT(*) DESC
";
$result4 = $conn->query($sql4);
if ($result4->num_rows > 0) {
    while ($row = $result4->fetch_assoc()) {
        echo "Course: " . $row["CourseTitle"] . " | Enrolled: " . $row["total_students"] . "<br>";
    }
}

// Close Connection================================================
$conn->close();
?>