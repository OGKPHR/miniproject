<?php session_start(); ?>
<?php
require_once "admin/connect.php";
$jobposition = "SELECT * FROM jobposition";
$jobpositionResult = mysqli_query($conn, $jobposition);
$jobpositionOptions = mysqli_fetch_all($jobpositionResult, MYSQLI_ASSOC);

$department = "SELECT * FROM department";
$departmentResult = mysqli_query($conn, $department);
$departmentOptions = mysqli_fetch_all($departmentResult, MYSQLI_ASSOC);

if (isset($_GET['id'])) {
    $empid = $_GET['id'];

    // ดึงข้อมูลพนักงานที่ต้องการแก้ไข
    $query = "SELECT * FROM employee WHERE EMPID = '$empid'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (!$row) {
        echo "Employee not found.";
        exit;
    }
}

if (isset($_POST['update_employee'])) {
    // รับข้อมูลจากแบบฟอร์มแก้ไข
    $empid = $_POST['empid'];
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

    // อัปเดตข้อมูลพนักงาน
    $update_query = "UPDATE employee SET FNAME='$fname', LNAME='$lname', TEL='$tel', SEX='$sex', BDATE='$bdate', HOUSENO='$houseno', VILLAGENO='$villageno', SUBDISTRICT='$subdistrict', DISTRICT='$district', PROVINCE='$province', JOBPOSITION='$jobposition', DEPARTMENT='$department', USERNAME='$username' WHERE EMPID = '$empid'";

    if (mysqli_query($conn, $update_query)) {
        header("Location: list_emp.php");
        exit;
    } else {
        echo "Error updating employee: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Edit Employee</title>
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Employee</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="hidden" name="empid" value="<?php echo $row['EMPID']; ?>">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fname">First Name:</label>
                    <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row['FNAME']; ?>"
                        required>
                </div>
                <div class="form-group col-md-6">
                    <label for="lname">Last Name:</label>
                    <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row['LNAME']; ?>"
                        required>
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
                        <input type="radio" class="form-check-input" id="male" name="sex" value="M" <?php if ($row['SEX'] === 'M')
                            echo 'checked'; ?> required>
                        <label class="form-check-label" for="male">Male</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="female" name="sex" value="F" <?php if ($row['SEX'] === 'F')
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
                    <input type="password" class="form-control" id="userpass" name="userpass" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Employee</button>
        </form>

    </div>
</body>

</html>