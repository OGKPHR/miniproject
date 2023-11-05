<?php
include 'admin/connect.php'; // Include your connection script

// Query the database to retrieve all applicant data
$sql = "SELECT * FROM applicant";
$result = $conn->query($sql);

// Check if there are any applicants
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>";
    echo "<th>Applicant ID</th>";
    echo "<th>First Name</th>";
    echo "<th>Last Name</th>";
    echo "<th>Contact</th>";
    // Add more columns for other applicant information as needed
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["APPID"] . "</td>";
        echo "<td>" . $row["FNAME"] . "</td>";
        echo "<td>" . $row["LNAME"] . "</td>";
        echo "<td>" . $row["TEL"] . "</td>";
        // Add more columns for other applicant information as needed
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No applicants found.";
}

// Close the database connection
$conn->close();
?>