<?php
require_once "connect.php";

// Function to generate a unique EMPID
function generateUniqueEmployeeID($conn) {
    $unique = false;
    $empid = '';

    while (!$unique) {
        // Generate a random 6-character string using numbers and uppercase letters
        $empid = strtoupper(substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6));

        // Check if the generated EMPID already exists in the database
        $check_query = "SELECT COUNT(*) AS count FROM employee WHERE EMPID = '$empid'";
        $result = mysqli_query($conn, $check_query);
        $row = mysqli_fetch_assoc($result);

        // If the EMPID is not found in the database, it's unique
        if ($row['count'] == 0) {
            $unique = true;
        }
    }

    return $empid;
}
require_once "connect.php";

$jobposition = "SELECT * FROM jobposition";
$jobpositionResult = mysqli_query($conn, $jobposition);
$jobpositionOptions = mysqli_fetch_all($jobpositionResult, MYSQLI_ASSOC);

$department = "SELECT * FROM department";
$departmentResult = mysqli_query($conn, $department);
$departmentOptions = mysqli_fetch_all($departmentResult, MYSQLI_ASSOC);
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fname'])) {
    $empid = generateUniqueEmployeeID($conn);
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
  
    $sql = "INSERT INTO employee (EMPID, FNAME, LNAME, TEL, SEX, BDATE, HOUSENO, VILLAGENO, SUBDISTRICT, DISTRICT, PROVINCE, JOBPOSITION, DEPARTMENT, USERNAME, USERPASS)
            VALUES ('$empid', '$fname', '$lname', '$tel', '$sex', '$bdate', '$houseno', '$villageno', '$subdistrict', '$district', '$province', '$jobposition', '$department', '$username', '$userpass')";
if (mysqli_query($conn, $sql)) {
        echo "Employee added successfully.";
        header("Location: add_employee.php");
        exit;
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <style>
        @media (min-width: 1025px) {
            .h-custom {
            height: 100vh !important;
            }
        }
        body{
            background-color: dimgray;
            background-image: url("https://images.pexels.com/photos/1210555/pexels-photo-1210555.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1");
            background-repeat: no-repeat;
            background-size: cover;
            
        }   
    </style>
</head>

<body>
<section class="h-100 h-custom" >
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100 " >
      <div class="col-lg-12 col-xl-10">
        <div class="card rounded-3 bg-dark ">
          <img src="https://images.pexels.com/photos/18955637/pexels-photo-18955637/free-photo-of-autumn-wallpapers.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
            class="w-100" style="border-top-left-radius: .3rem; border-top-right-radius: .3rem; height:30vh; object-fit: cover; object-position: center; "
            alt="Sample photo">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-2 pb-2 pb-md-0 mb-md-5 px-md-2 text-light">Add Employee</h3>

            <form class="px-md-2">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                        <label for="username">Username:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="userpass" name="userpass" placeholder="Password" required>
                        <label for="userpass">Password:</label>
                    </div>
                </div>
            </div>
              <div class="row ">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="fname" name="fname" placeholder="First name" required>
                        <label for="fname">First Name:</label>
                    </div>
                    
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="lname" name="lname" placeholder="Last name" required>
                        <label for="lname">Last Name:</label>
                    </div>
                </div>
              </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="tel" name="tel" placeholder="Phone Number" required>
                        <label for="tel">Phone Number:</label>
                    </div>
                </div>

                <div class="form-group col-md-6 mt-2 text-light" style="font-size: 20px; ">
                    <label for="sex" style="display: inline-block;">Sex:</label>
                    <div class="form-check ms-2" style="display: inline-block;">
                        <input type="radio" class="form-check-input" id="male" name="sex" value="M" required style="display: inline-block;">
                        <label class="form-check-label" for="male" style="display: inline-block;">Male</label>
                    </div>
                    <div class="form-check ms-2" style="display: inline-block;">
                        <input type="radio" class="form-check-input" id="female" name="sex" value="F" required style="display: inline-block;">
                        <label class="form-check-label" for="female" style="display: inline-block;">Female</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="date" class="form-control" id="bdate" name="bdate" placeholder="MM/DD/YYYY" required>
                        <label for="bdate">Date of birth:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="houseno" name="houseno" placeholder="House Number" required>
                        <label for="houseno">House Number:</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="villageno" name="villageno" placeholder="Village Number" required>
                        <label for="villageno">Village Number:</label>
                    </div>   
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="subdistrict" placeholder="Subdistrict" name="subdistrict" required>
                        <label for="subdistrict">Subdistrict:</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="district" name="district" placeholder="District" required>
                        <label for="district">District:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="province" placeholder="Province" name="province" required>
                        <label for="province">Province:</label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="jobposition" name="jobposition"  required>
                            <?php foreach ($jobpositionOptions as $jobpositionOption): ?>
                                <option value="<?php echo $jobpositionOption['JID']; ?>">
                                    <?php echo $jobpositionOption['JNAME']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="jobposition">Job Position:</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="department" name="department" required>
                            <?php foreach ($departmentOptions as $departmentOption): ?>
                                <option value="<?php echo $departmentOption['DID']; ?>">
                                    <?php echo $departmentOption['DNAME']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <label for="department">Department:</label>
                    </div>
                </div>
                <hr>
                <div class="d-flex justify-content-center align-items-center mt-3 mb-3" >
                    <button type="submit" class="btn btn-outline-primary btn-lg" style="width: 80%;">Add Employee</button>
                </div>
                <hr>
                
            </div>


              


            
            </form>

          </div>
          <img src="https://images.pexels.com/photos/2129793/pexels-photo-2129793.png?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
            class="w-100" style="border-top-left-radius: .3rem; border-top-right-radius: .3rem; height:5vh; object-fit: cover; object-position: bottom; "
            alt="Sample photo">
        </div>
      </div>
    </div>
  </div>
</section>

</body>

</html>