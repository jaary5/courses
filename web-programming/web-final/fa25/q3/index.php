<?php

// Conneciton
$conn = new mysqli("localhost", "root", "", "campus_library");
if ($conn->connect_error == false) echo "Connection Successful <br><br>";

// query 1. Show the total number of books for each Status (Returned, Overdue, Lost), but only include
// statuses that have more than 1 entry in the table.
$sql1 = "
    SELECT Status, COUNT(*) AS total
    FROM book_loans
    GROUP BY Status
    HAVING COUNT(*) > 1
";
$result1 = $conn->query($sql1);
if ($result1->num_rows > 0) {
    while ($row = $result1->fetch_assoc()) {
        echo  "Status: " . $row["Status"] . 
           " | Total: " . $row["total"]. "<br>";
    }
} echo "<br>";

// query 2. For any student who has a Status of 'Overdue' and DaysOverdue less than 7, change their
// Status to 'Grace Period' and set their PenaltyFee to 0.
$sql2 = "
    UPDATE book_loans
    SET Status='Grace Period', PenaltyFee=0.00
    WHERE Status='Overdue' AND DaysOverDue<7
";
$result2 = $conn->query($sql2);
if ($result2) echo "DB updated <br><br>";

// query 3. For students with a PenaltyFee greater than 20.00, increase their fee by 10% as a "processing
// charge," but only if the final fee does not exceed 50.00.
$sql3 = "
    UPDATE book_loans
    SET PenaltyFee=PenaltyFee*1.10
    WHERE PenaltyFee>20.00 AND PenaltyFee*1.10<=50.00
";
$result3 = $conn->query($sql3);
if ($result3) echo "DB updated <br><br>";

// query 4. Display each BookTitle and the total PenaltyFee collected/owed for that book. Sort the
// results so that the book generating the most money appears at the top.
$sql4 = "
    SELECT BooKTitle, SUM(PenaltyFee) AS total
    FROM book_loans
    GROUP BY BooKTitle
    ORDER BY SUM(PenaltyFee) DESC
";
$result4 = $conn->query($sql4);
if ($result4->num_rows > 0) {
    while ($row = $result4->fetch_assoc()) {
        echo "Book Title: " . $row["BooKTitle"] . 
        " | Penalty Fee: " . $row["total"] . "<br>";
    }
}
 
?>