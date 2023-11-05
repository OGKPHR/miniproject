<?php
session_start();
include("navbar.php");

require_once "admin/connect.php";

if (isset($_POST['apply'])) {
    // Get the user's information from the employee table
    $user_id = $_POST['user_id'];

    $query = "SELECT EMPID, FNAME, LNAME, TEL, SEX, BDATE, HOUSENO, VILLAGENO, SUBDISTRICT, DISTRICT, PROVINCE, JOBPOSITION, DEPARTMENT
              FROM employee
              WHERE EMPID = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();

    if (!$user_data) {
        echo "User not found in the employee table.";
    } else {
        // Insert the user's information into the applicant table
        $insert_query = "INSERT INTO applicant (APPID, FNAME, LNAME, TEL, SEX, BDATE, HOUSENO, VILLAGENO, SUBDISTRICT, DISTRICT, PROVINCE, REQUESTID)
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssssssssssss", $user_data['EMPID'], $user_data['FNAME'], $user_data['LNAME'], $user_data['TEL'], $user_data['SEX'], $user_data['BDATE'], $user_data['HOUSENO'], $user_data['VILLAGENO'], $user_data['SUBDISTRICT'], $user_data['DISTRICT'], $user_data['PROVINCE'], $user_data['DEPARTMENT']);

        if ($stmt->execute()) {
            echo "Application submitted successfully!";
        } else {
            echo "Error submitting the application.";
        }
    }
}
?>