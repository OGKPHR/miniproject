<?php
require_once "connect.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_request'])) {
    $department = $_POST['department'];
    $jobposition = $_POST['jobposition'];
    $quantity = $_POST['quantity'];

    // เพิ่มข้อมูลการร้องขอตำแหน่งงานลงในตาราง request
    $request_query = "INSERT INTO request (DEPTREQUEST, JOBREQUEST, STATUS_ID) VALUES ('$department', '$jobposition', '3')";
    if (mysqli_query($conn, $request_query)) {
        $request_id = mysqli_insert_id($conn); // รับค่า ID ของ request ที่เพิ่มล่าสุด

        // เพิ่มข้อมูล skill ที่ถูกเลือกลงในตาราง request_skill
        if (isset($_POST['skills']) && is_array($_POST['skills'])) {
            foreach ($_POST['skills'] as $skill_id) {
                $request_skill_query = "INSERT INTO request_skill (SKILL_ID, REQUEST_ID) VALUES ('$skill_id', '$request_id')";
                mysqli_query($conn, $request_skill_query);
            }
        }

        // รับค่าจำนวณคนที่จะรับและเพิ่มลงในตาราง request
        $quantity_query = "UPDATE request SET QUANTITY = '$quantity' WHERE RID = '$request_id'";
        mysqli_query($conn, $quantity_query);

        header("Location: request_job.php");
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
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>