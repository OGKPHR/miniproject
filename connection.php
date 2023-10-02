<?php
// Database connection parameters
$host = "203.188.54.7"; // Change this to your Oracle database host or IP address
$username = "your_oracle_username"; // Change this to your Oracle database username
$password = "your_oracle_password"; // Change this to your Oracle database password
$service_name = "your_service_name"; // Change this to your Oracle database service name or SID

// Create a database connection
$conn = oci_connect($username, $password, $host . "/" . $service_name);

// Check connection
if (!$conn) {
    $e = oci_error();
    die("Connection failed: " . htmlentities($e['message'], ENT_QUOTES));
}
?>
