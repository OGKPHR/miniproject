<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Include a database connection file to interact with your database
require('admin/connect.php'); // Replace with the actual database connection file.

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the submitted username and password
    $username = $_POST['username'];
    $providedPassword = $_POST['password'];

    // Create a prepared statement to fetch the stored password
    $query = "SELECT EMPID, USERPASS FROM employee WHERE USERNAME = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        $stmt->store_result();
        
        if ($stmt->num_rows === 1) {
            $stmt->bind_result($empid, $storedPassword);
            $stmt->fetch();
            
            // Verify the provided password against the stored hashed password
            if (password_verify($providedPassword, $storedPassword)) {
                // Authentication successful
                $_SESSION['user_id'] = $empid;
                header("Location: index.php"); // Replace 'dashboard.php' with the actual page to redirect to upon successful login.
                exit();
            } else {
                // Authentication failed - incorrect password
                $login_error = "Invalid username or password";
            }
        } else {
            // Authentication failed - username not found
            $login_error = "Invalid username or password";
        }
    } else {
        // Handle database query error
        $login_error = "Database query error";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
mysqli_close($conn);
?>
