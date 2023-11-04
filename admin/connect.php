<?php

$conn = mysqli_connect("localhost", "root", "", "miniPro");

if (!$conn) {
    die("Failed to connect to database " . mysqli_error($conn));
}

?>