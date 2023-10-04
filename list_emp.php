<?php
session_start();
require_once "connect.php";
$query = "SELECT * FROM employee";
$result = mysqli_query($conn, $query);
if (isset($_POST['delete_employee'])) {
    $empid = $_POST['empid'];
    $delete_query = "DELETE FROM employee WHERE EMPID = '$empid'";
    if (mysqli_query($conn, $delete_query)) {
        header("Location: list_emp.php");
        exit;
    } else {
        echo "Error deleting employee: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>list employee</title>

</head>

<body>
    <div class="table-responsive mt-5">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Phone Number</th>
                        <th>Sex</th>
                        <th>Birth Date</th>
                        <th>House Number</th>
                        <th>Village Number</th>
                        <th>Subdistrict</th>
                        <th>District</th>
                        <th>Province</th>
                        <th>Job Position</th>
                        <th>Department</th>
                        <th>Username</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <?php echo $row['FNAME']; ?>
                            </td>

                            <td>
                                <?php echo $row['LNAME']; ?>
                            </td>

                            <td>
                                <?php echo $row['TEL']; ?>
                            </td>

                            <td>
                                <?php echo $row['SEX']; ?>
                            </td>

                            <td>
                                <?php echo $row['BDATE']; ?>
                            </td>

                            <td>
                                <?php echo $row['HOUSENO']; ?>
                            </td>

                            <td>
                                <?php echo $row['VILLAGENO']; ?>
                            </td>

                            <td>
                                <?php echo $row['SUBDISTRICT']; ?>
                            </td>

                            <td>
                                <?php echo $row['DISTRICT']; ?>
                            </td>

                            <td>
                                <?php echo $row['PROVINCE']; ?>

                            <td>
                                <?php
                                $jid = $row['JOBPOSITION'];
                                $job_query = "SELECT JNAME FROM jobposition WHERE JID = '$jid'";
                                $job_result = mysqli_query($conn, $job_query);
                                $job_row = mysqli_fetch_assoc($job_result);
                                echo $job_row['JNAME'];
                                ?>
                            </td>

                            <td>
                                <?php
                                $did = $row['DEPARTMENT'];
                                $depart_query = "SELECT DNAME FROM department WHERE DID = '$did'";
                                $depart_result = mysqli_query($conn, $depart_query);
                                $depart_row = mysqli_fetch_assoc($depart_result);
                                echo $depart_row['DNAME'];
                                ?>
                            </td>
                            <td>
                                <?php echo $row['USERNAME']; ?>
                            </td>
                            <td>
                                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                                    <input type="hidden" name="empid" value="<?php echo $row['EMPID']; ?>">
                                    <button type="submit" class="btn btn-danger" name="delete_employee">Delete</button>
                                </form>
                            </td>
                            <td>
                                <a href="edit_employee.php?id=<?php echo $row['EMPID']; ?>"
                                    class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No employees found.</p>
        <?php endif; ?>
    </div>
    </div>
</body>

</html>