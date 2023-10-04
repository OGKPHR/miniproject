<?php
session_start();
require_once "connect.php";

$jobposition = "SELECT * FROM jobposition";
$jobpositionResult = mysqli_query($conn, $jobposition);
$jobpositionOptions = mysqli_fetch_all($jobpositionResult, MYSQLI_ASSOC);

$department = "SELECT * FROM department";
$departmentResult = mysqli_query($conn, $department);
$departmentOptions = mysqli_fetch_all($departmentResult, MYSQLI_ASSOC);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fname'])) {
    // รหัส SQL สำหรับเพิ่มข้อมูลลงในฐานข้อมูล
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $tel = $_POST['tel'];
    $sex = $_POST['sex'];
    $bdate = $_POST['bdate'];
    $houseno = $_POST['houseno'];
    $villageno = $_POST['villageno'];
    $subdistrict = $_POST['subdistrict'];
    $district = $_POST['district'];
    $province = $_POST['province'];
    $jobposition = $_POST['jobposition'];
    $department = $_POST['department'];
    $username = $_POST['username'];
    $userpass = $_POST['userpass'];
    $sql = "INSERT INTO employee (FNAME, LNAME, TEL, SEX, BDATE, HOUSENO, VILLAGENO, SUBDISTRICT, DISTRICT, PROVINCE, JOBPOSITION, DEPARTMENT, USERNAME, USERPASS)
    VALUES ('$fname', '$lname', '$tel', '$sex', '$bdate', '$houseno', '$villageno', '$subdistrict', '$district', '$province', '$jobposition', '$department', '$username', '$userpass')";
    if (mysqli_query($conn, $sql)) {
        echo "Employee added successfully.";
        header("Location: add_employee.php");
        exit; // จบการทำงานที่นี่
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
$query = "SELECT * FROM employee";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <!-- เรียกใช้งานไฟล์ CSS และ JavaScript ของ Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h1>Add Employee</h1>
        <form action="add_employee.php" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fname">First Name:</label>
                    <input type="text" class="form-control" id="fname" name="fname" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="lname">Last Name:</label>
                    <input type="text" class="form-control" id="lname" name="lname" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tel">Phone Number:</label>
                    <input type="text" class="form-control" id="tel" name="tel" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="sex">Sex:</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="male" name="sex" value="M" required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="female" name="sex" value="F" required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="bdate">Birth Date:</label>
                    <input type="date" class="form-control" id="bdate" name="bdate" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="houseno">House Number:</label>
                    <input type="text" class="form-control" id="houseno" name="houseno" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="villageno">Village Number:</label>
                    <input type="text" class="form-control" id="villageno" name="villageno" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="subdistrict">Subdistrict:</label>
                    <input type="text" class="form-control" id="subdistrict" name="subdistrict" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="district">District:</label>
                    <input type="text" class="form-control" id="district" name="district" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="province">Province:</label>
                    <input type="text" class="form-control" id="province" name="province" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="jobposition">Job Position:</label>
                    <select class="form-control" id="jobposition" name="jobposition" required>
                        <?php foreach ($jobpositionOptions as $jobpositionOption): ?>
                            <option value="<?php echo $jobpositionOption['JID']; ?>">
                                <?php echo $jobpositionOption['JNAME']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="department">Department:</label>
                    <select class="form-control" id="department" name="department" required>
                        <?php foreach ($departmentOptions as $departmentOption): ?>
                            <option value="<?php echo $departmentOption['DID']; ?>">
                                <?php echo $departmentOption['DNAME']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="userpass">Password:</label>
                    <input type="password" class="form-control" id="userpass" name="userpass" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Add Employee</button>
        </form>
    </div>
</body>

</html>