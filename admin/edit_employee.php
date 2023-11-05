<?php
session_start();
include_once(dirname(__DIR__).'/util/check_access_permission.php'); check_access_permission(basename($_SERVER['SCRIPT_FILENAME']));
include(dirname(__DIR__).'/navbar.php');
// include_once(dirname(__DIR__).'/util/check_access_permission.php'); check_access_permission(basename($_SERVER['SCRIPT_FILENAME']));
require_once "connect.php";

$jobpositionQuery = "SELECT * FROM jobposition";
$jobpositionResult = mysqli_query($conn, $jobpositionQuery);
$jobpositionOptions = mysqli_fetch_all($jobpositionResult, MYSQLI_ASSOC);

$departmentQuery = "SELECT * FROM department";
$departmentResult = mysqli_query($conn, $departmentQuery);
$departmentOptions = mysqli_fetch_all($departmentResult, MYSQLI_ASSOC);

echo $_SERVER['PHP_SELF'];

// ตรวจสอบการรับค่า id จาก GET request เพื่อดึงข้อมูลเดิม
if (isset($_GET['id'])) {
    $empid = mysqli_real_escape_string($conn, $_GET['id']);

    $query = "SELECT * FROM employee WHERE EMPID = '$empid'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if (!$row) {
        echo "Employee not found.";
        exit;
    }
}

// ตรวจสอบการรับค่าจาก POST request 
if (isset($_POST['update_employee'])) {
    echo "aha";
    // รับข้อมูลจากแบบฟอร์มแก้ไข พร้อมทำการ escape ข้อมูลเพื่อป้องกัน SQL Injection
    $empid = mysqli_real_escape_string($conn, $_POST['empid']);
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $tel = mysqli_real_escape_string($conn, $_POST['tel']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $bdate = mysqli_real_escape_string($conn, $_POST['bdate']);
    $houseno = mysqli_real_escape_string($conn, $_POST['houseno']);
    $villageno = mysqli_real_escape_string($conn, $_POST['villageno']);
    $subdistrict = mysqli_real_escape_string($conn, $_POST['subdistrict']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $jobposition = mysqli_real_escape_string($conn, $_POST['jobposition']);
    $department = mysqli_real_escape_string($conn, $_POST['department']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $userpass = mysqli_real_escape_string($conn, $_POST['userpass']);

    // ทำการ hash รหัสผ่านก่อนบันทึกลงฐานข้อมูล
    $hashed_password = password_hash($userpass, PASSWORD_DEFAULT);

    // อัปเดตข้อมูลพนักงาน
    $update_query = "UPDATE employee SET FNAME='$fname', LNAME='$lname', TEL='$tel', SEX='$sex', BDATE='$bdate', HOUSENO='$houseno', VILLAGENO='$villageno', SUBDISTRICT='$subdistrict', DISTRICT='$district', PROVINCE='$province', JOBPOSITION='$jobposition', DEPARTMENT='$department', USERNAME='$username', USERPASS='$hashed_password' WHERE EMPID = '$empid'";

    $a = (mysqli_query($conn, $update_query));
    var_dump($a);

    if ($a) {
        header('Location: list_emp.php');
        exit;
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en"></html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Edit Employee</title>
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Employee</h2>
        <!-- <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" onsubmit="return confirm('Are you sure you want to update this employee?');"> -->
        <form action="./edit_employee.php" method="POST" onsubmit="return confirm('Are you sure you want to update this employee?');">
            <input type="hidden" name="empid" value="<?php echo $row['EMPID']; ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fname">First Name:</label>
                    <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row['FNAME']; ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="lname">Last Name:</label>
                    <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row['LNAME']; ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="tel">Phone Number:</label>
                    <input type="text" class="form-control" id="tel" name="tel" value="<?php echo $row['TEL']; ?>"
                        required>
                </div>

                <div class="form-group col-md-6">
                    <label for="sex">Sex:</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="male" name="sex" value="m" <?php if ($row['SEX'] === 'm')
                            echo 'checked'; ?> required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>

                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="female" name="sex" value="f" <?php if ($row['SEX'] === 'f')
                            echo 'checked'; ?> required>
                        <label class="form-check-label" for="female">Female</label>
                    </div>

                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="bdate">Birth Date:</label>
                    <input type="date" class="form-control" id="bdate" name="bdate" value="<?php echo $row['BDATE']; ?>"
                        required>
                </div>

                <div class="form-group col-md-6">
                    <label for="houseno">House Number:</label>
                    <input type="text" class="form-control" id="houseno" name="houseno"
                        value="<?php echo $row['HOUSENO']; ?>" required>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="villageno">Village Number:</label>
                    <input type="text" class="form-control" id="villageno" name="villageno"
                        value="<?php echo $row['VILLAGENO']; ?>" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="subdistrict">Subdistrict:</label>
                    <input type="text" class="form-control" id="subdistrict" name="subdistrict"
                        value="<?php echo $row['SUBDISTRICT']; ?>" required>
                </div>

            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="district">District:</label>
                    <input type="text" class="form-control" id="district" name="district"
                        value="<?php echo $row['DISTRICT']; ?>" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="province">Province:</label>
                    <input type="text" class="form-control" id="province" name="province"
                        value="<?php echo $row['PROVINCE']; ?>" required>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="jobposition">Job Position:</label>
                    <select class="form-control" id="jobposition" name="jobposition" required>
                        <?php foreach ($jobpositionOptions as $jobpositionOption): ?>
                            <option value="<?php echo $jobpositionOption['JID']; ?>" <?php if ($jobpositionOption['JID'] === $row['JOBPOSITION'])
                                   echo 'selected'; ?>>
                                <?php echo $jobpositionOption['JNAME']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="department">Department:</label>
                    <select class="form-control" id="department" name="department" required>
                        <?php foreach ($departmentOptions as $departmentOption): ?>
                            <option value="<?php echo $departmentOption['DID']; ?>" <?php if ($departmentOption['DID'] === $row['DEPARTMENT'])
                                   echo 'selected'; ?>>
                                <?php echo $departmentOption['DNAME']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="<?php echo $row['USERNAME']; ?>" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="userpass">Password:</label>
                    <input type="password" class="form-control" id="userpass" name="userpass">  
                    <!-- TODO: should we required password input? -->
                </div>

            </div>

            <button type="submit" class="btn btn-primary" name="update_employee">Update Employee</button>
        </form>
    </div>
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>
</body>
</html>