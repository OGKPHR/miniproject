<?php session_start(); ?>
<?php

include('../navbar.php');
require 'connect.php'; // Ensure this path is correct
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
    // Fetch job position and department options from the database
    $jobposition = "SELECT * FROM jobposition";
    $jobpositionResult = mysqli_query($conn, $jobposition);
    $jobpositionOptions = mysqli_fetch_all($jobpositionResult, MYSQLI_ASSOC);

    $department = "SELECT * FROM department";
    $departmentResult = mysqli_query($conn, $department);
    $departmentOptions = mysqli_fetch_all($departmentResult, MYSQLI_ASSOC);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empid =  generateUniqueEmployeeID($conn);
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Always hash passwords
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $telephone = $_POST['telephone'];
    $date_of_birth = $_POST['date_of_birth']; 
    $house_number = $_POST['house_number'];
    $village_number = $_POST['village_number'];
    $subdistrict = $_POST['Subdistrict'];
    $district = $_POST['District'];
    $province = $_POST['province'];
    $gender = $_POST['inlineRadioOptions'] === 'option1' ? 'male' : 'female';
    $jobpositionOption = $_POST['jobposition'];
    $departmentOption = $_POST['department'];

    //into the database
    $stmt = $conn->prepare("INSERT INTO employee (EMPID, FNAME, LNAME, TEL, SEX, BDATE, HOUSENO, VILLAGENO, DISTRICT, SUBDISTRICT, PROVINCE, jobposition, department, USERNAME, USERPASS) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssssssssssss", $empid, $first_name, $last_name, $telephone, $gender, $date_of_birth, $house_number, $village_number, $district, $subdistrict, $province, $jobpositionOption, $departmentOption, $username, $password);

    
    // Execute the prepared statement
    if ($stmt->execute()) {  
        header("Location: list_emp.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and the connection
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <!-- Scripts -->


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Employee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

    <style>
        @media (min-width: 1025px) {
            .h-custom {
            height: 100vh !important;
            }
        }
        body{
            background-color: black;
            background-image: url("https://images.pexels.com/photos/1210555/pexels-photo-1210555.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1");
            background-repeat: no-repeat;
            background-size: cover;
            height: 100%;
        }   
    </style>
</head>
<body>
<div class="alert <?php echo isset($message) ? ($message === 'New record created successfully' ? 'alert-success' : 'alert-danger') : 'd-none'; ?>">
        <?php echo $message; ?>
    </div>
    <section class="h-100 h-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-10">
                    <div class="card rounded-3">
                        <img src="https://images.pexels.com/photos/18955637/pexels-photo-18955637/free-photo-of-autumn-wallpapers.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" class="w-100"
                            style="border-top-left-radius: .3rem; border-top-right-radius: .3rem; height:30vh; object-fit: cover; object-position: center; "
                            alt="Sample photo">
                        <div class="card-body p-4 p-md-5">
                            <h2 class="mb-2 pb-2 pb-md-0 mb-md-5 px-md-2 text-center">ADD EMPLOYEE</h2>
                            <form method="post" action="add_employee.php" enctype="multipart/form-data">
                                <div class="card" style="border-radius: 15px;">
                                    <div class="card-body py-5 px-md-5">
                                        <!-- Username input -->
                                        <div class="form-floating mb-3 mt-3">
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="Username" />
                                            <label for="username">Username</label>
                                        </div>
                                        <!-- Password input -->
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="password" name="password"
                                                placeholder="Password" />
                                            <label for="password">Password</label>
                                        </div>
                                        <!-- Confirm Password input -->
                                        <div class="form-floating mb-3">
                                            <input type="password" class="form-control" id="ConfirmPassword"
                                                name="confirmpassword" placeholder="Confirm Password" />
                                            <label for="ConfirmPassword">Confirm Password</label>
                                        </div>
                                        <!-- First and Last Name inputs -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" id="firstname" name="first_name" class="form-control"
                                                        placeholder="First name" />
                                                    <label for="firstname">First name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="lastname" name="last_name"
                                                        placeholder="Last name" />
                                                    <label for="lastname">Last name</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Telephone input -->
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="Telephone" name="telephone"
                                                placeholder="Telephone Number" />
                                            <label for="Telephone">Telephone</label>
                                        </div>
                                        <!-- Date of Birth input -->
                                        <div class="form-floating mb-3">
                                            <input type="date" class="form-control" id="Dateofbirth" name="date_of_birth"
                                                placeholder="Date of birth" />
                                            <label for="Dateofbirth">Date of birth</label>
                                        </div>
                                        <!-- House and Village Number inputs -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="Housenumber"
                                                        name="house_number" placeholder="House number" />
                                                    <label for="Housenumber">House number</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="Village" name="village_number"
                                                        placeholder="Village number" />
                                                    <label for="Village">Village number</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Subdistrict, District, and Province inputs -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="Subdistrict" name="Subdistrict"
                                                        placeholder="Subdistrict" />
                                                    <label for="Subdistrict">Subdistrict</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="District" name="District"
                                                        placeholder="District" />
                                                    <label for="District">District</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="Province" name="province"
                                                        placeholder="Province" />
                                                    <label for="Province">Province</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Gender input -->
                                        <div class="row mb-3 mt-3 justify-content-center align-content-center text-center">
                                            <div class="col-md-3">
                                                <p style="font-size: 18px">Gender</p>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                        id="genderMale" value="option1" />
                                                    <label class="form-check-label" for="genderMale">Male</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                        id="genderFemale" value="option2" />
                                                    <label class="form-check-label" for="genderFemale">Female</label>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Job Position and Department selections -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3">
                                                <select class="form-select" id="jobposition" name="jobposition" required>
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
                                        </div>
                                        <hr>
                                        <div class="d-flex justify-content-center align-items-center mt-3 mb-3">
                                            <button type="submit" class="btn btn-outline-primary btn-lg" style="width: 80%;">Add Employee</button>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
      flatpickr('#Dateofbirth', {
        enableTime: false,
        dateFormat: "Y-m-d",
        maxDate: "today", // จำกัดการเลือกวันเป็นวันปัจจุบันและวันที่อาจารย์
        minDate: "1900-01-01", // กำหนดวันขั้นต่ำในอดีต
      });
    </script>
</body>

</html>