<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Company Recruitment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    /* Reset some default styles for better consistency */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
}

header {
    background-color: #d9b791;
    color: #b00000;
    text-align: center;
    padding: 20px;
}

nav ul {
    list-style: none;
    display: flex;
    justify-content: center;
    background-color: #444;
    padding: 10px;
}

nav li {
    margin-right: 20px;
}

nav a {
    color: #fff;
    text-decoration: none;
}

main {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.hero {
    text-align: center;
    padding: 40px 0;
}

.cta-button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #333;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
}

.job-listings {
    margin-top: 20px;
}

.job {
    padding: 10px;
    border: 1px solid #ddd;
    margin-bottom: 20px;
}

.apply-button {
    display: inline-block;
    padding: 5px 10px;
    background-color: #333;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    float: right;
}


/* Make the navigation bar sticky */
nav {
    position: sticky;
    top: 0;
    background-color: #444;
    z-index: 100;
}

/* Set the footer to stay at the bottom */
footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    text-align: center;
    background-color: #333;
    color: #fff;
    padding: 10px 0;
}
</style>
<body>
    <header>
        <h1>Welcome to Your Company Recruitment</h1>
    </header>
    <nav>
        <ul>
            <li><a href="#">หน้าแรก</a></li>
            <li><a href="#">รายชื่องาน</a></li>
            <li><a href="#">ติดต่อเรา</a></li>
            
        </ul>
    </nav>
    <main>
        <section class="job-listings">
            <h2>Latest Job Listings</h2>
            <?php
            // Include the database connection
            include 'connection.php';

            // Query to fetch data from the REQUEST table
            $query = "SELECT * FROM INNO061.REQUEST";

            // Execute the query
            $stmt = oci_parse($conn, $query);
            oci_execute($stmt);

            // Fetch and display job listings
            while ($row = oci_fetch_assoc($stmt)) {
                echo '<div class="job">';
                echo '<h3>' . $row['DEPTREQUEST'] . '</h3>';
                echo '<p>' . $row['SKILL'] . '</p>';
                echo '<a href="#" class="apply-button">Apply Now</a>';
                echo '</div>';
            }

            // Close the database connection (if needed)
            oci_close($conn);
            ?>
        </section>
    </main>
    <footer>
        <p>&copy; 2023 Your Company. All rights reserved.</p>
    </footer>
</body>
</html>
