<?php
require 'admin/connect.php'; // Ensure this path is correct
// Function to generate a unique EMPID
function generateUniqueEmployeeID($conn) {
    $unique = false;
    $empid = '';

    while (!$unique) {
        // Generate a random 6-character string using numbers and uppercase letters
        $empid = strtoupper(substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6));

        // Check if the generated EMPID already exists in the database
        $check_query = "SELECT COUNT(*) AS count FROM employee WHERE EMPID = '$empid'";
        $result = mysqli_query($conn, $check_query);
        $row = mysqli_fetch_assoc($result);

        // If the EMPID is not found in the database, it's unique
        if ($row['count'] == 0) {
            $unique = true;
        }
    }

    return $empid;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empid =  generateUniqueEmployeeID($conn);
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Always hash passwords
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $telephone = $_POST['telephone'];
    $date_of_birth = $_POST['date_of_birth']; 
    $house_number = $_POST['house_number'];
    $village_number = $_POST['village_number'];
    $subdistrict = $_POST['subdistrict'];
    $district = $_POST['district'];
    $province = $_POST['province'];
    $gender = $_POST['inlineRadioOptions'] === 'option1' ? 'male' : 'female';

    //into the database
    $stmt = $conn->prepare("INSERT INTO employee (EMPID,FNAME, LNAME, TEL, SEX, BDATE, HOUSENO, VILLAGENO, SUBDISTRICT, DISTRICT, PROVINCE, USERNAME, USERPASS) VALUES (?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssssss",$empid, $first_name, $last_name, $telephone, $gender, $date_of_birth, $house_number, $village_number, $subdistrict, $district, $province, $username, $password);

    // Execute the prepared statement
    if ($stmt->execute()) {
        
        echo "New record created successfully";
        
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
}

$conn->close();
?>
