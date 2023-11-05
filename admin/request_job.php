<?php session_start(); ?>
<?php include_once(dirname(__DIR__).'/util/check_access_permission.php'); check_access_permission(basename($_SERVER['SCRIPT_FILENAME'])) ?>
<?php
include("../navbar.php");
require_once "connect.php";
include_once('../util/functions.php');

// Function to get the next unique RID
function getNextUniqueRID($conn) {
    $existing_rids = array();
    $query = "SELECT RID FROM request";
    $result = mysqli_query($conn, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        $existing_rids[] = $row['RID'];
    }

    $nextRID = 1;

    while (in_array($nextRID, $existing_rids)) {
        $nextRID++;
    }

    return str_pad($nextRID, 6, '0', STR_PAD_LEFT);
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_request'])) {
    $department = $_POST['department'];
    $jobposition = $_POST['jobposition'];
    $quantity = $_POST['quantity'];
    $STATUS_PENDING = 1; //

    // Get the next unique RID
    $request_id = getNextUniqueRID($conn);
    
    // Insert the request with the generated RID
    $request_query = "INSERT INTO request (RID, DEPTREQUEST, JOBREQUEST, STATUS_ID) VALUES ('$request_id', '$department', '$jobposition', '$STATUS_PENDING')";

    if (mysqli_query($conn, $request_query)) {
        // Add selected skills to the request_skill table
        if (isset($_POST['skills']) && is_array($_POST['skills'])) {
            foreach ($_POST['skills'] as $skill_id) {
                $request_skill_query = "INSERT INTO request_skill (SKILL_ID, REQUEST_ID) VALUES ('$skill_id', '$request_id')";
                mysqli_query($conn, $request_skill_query);
            }
        }

        // Update the quantity of people to be hired in the request table
        $quantity_query = "UPDATE request SET QUANTITY = '$quantity' WHERE RID = '$request_id'";
        mysqli_query($conn, $quantity_query);
        alert("เพิ่มสำเร็จ", "/mini/index.php");
        exit;

    } else {
        die("Error: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Request</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Job Request</h2>
        <form method="POST">
            <div class="form-group">
                <label for="department">Department:</label>
                <select class="form-control" id="department" name="department" required>
                    <!-- ดึงข้อมูลแผนก (department) จากฐานข้อมูลและแสดงผล -->
                    <?php
                    // เชื่อมต่อฐานข้อมูล
                    $query = "SELECT * FROM department";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['DID']}'>{$row['DNAME']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="jobposition">Job Position:</label>
                <select class="form-control" id="jobposition" name="jobposition" required>
                    <!-- ดึงข้อมูลตำแหน่งงาน (job position) จากฐานข้อมูลและแสดงผล -->
                    <?php
                    $query = "SELECT * FROM jobposition";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['JID']}'>{$row['JNAME']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="skills">Skills:</label><br>
                <!-- ดึงข้อมูลทักษะ (skills) จากฐานข้อมูลและแสดงเป็น checkbox -->
                <?php
                $query = "SELECT * FROM skill";
                $result = mysqli_query($conn, $query);
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<input type='checkbox' name='skills[]' value='{$row['SKILLID']}'> {$row['SKILLNAME']}<br>";
                }
                ?>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit_request">Submit Request</button>
        </form>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->
</body>
</html>