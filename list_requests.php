<?php

require_once "admin/connect.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['accept_request'])) {
        $request_id = $_POST['request_id'];
        $update_query = "UPDATE request SET STATUS_ID = '2' WHERE RID = '$request_id'";
        if (mysqli_query($conn, $update_query)) {
            header("Location: list_requests.php");
            exit;
        } else {
            die("Error: " . mysqli_error($conn));
        }
    } elseif (isset($_POST['reject_request'])) {
        $request_id = $_POST['request_id'];
        $update_query = "UPDATE request SET STATUS_ID = '1' WHERE RID = '$request_id'";

        if (mysqli_query($conn, $update_query)) {
            header("Location: list_requests.php");
            exit;
        } else {
            die("Error: " . mysqli_error($conn));
        }
    }

}
$query = "SELECT r.RID, d.DNAME, j.JNAME, r.QUANTITY, r.STATUS_ID, GROUP_CONCAT(s.SKILLNAME) AS SKILLS
          FROM request r
          JOIN department d ON r.DEPTREQUEST = d.DID
          JOIN jobposition j ON r.JOBREQUEST = j.JID
          LEFT JOIN request_skill rs ON r.RID = rs.REQUEST_ID
          LEFT JOIN skill s ON rs.SKILL_ID = s.SKILLID
          WHERE r.STATUS_ID IN (1, 2, 3)
          GROUP BY r.RID, d.DNAME, j.JNAME, r.QUANTITY, r.STATUS_ID";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Requests</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- เพิ่ม jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<?php include 'navbar.php';?>
<body>
    <div class="container">
        <h2 class="mt-4">List Requests</h2>
        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Department</th>
                    <th>Job Position</th>
                    <th>Skills</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?php echo $row['RID']; ?>
                        </td>
                        <td>
                            <?php echo $row['DNAME']; ?>
                        </td>
                        <td>
                            <?php echo $row['JNAME']; ?>
                        </td>
                        <td>
                            <?php echo $row['SKILLS']; ?>
                        </td>
                        <td>
                            <?php echo $row['QUANTITY']; ?>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="request_id" value="<?php echo $row['RID']; ?>">
                                <?php if ($row['STATUS_ID'] == 3): ?>
                                    <button type="submit" class="btn btn-success" name="accept_request">Accept</button>
                                    <button type="submit" class="btn btn-danger" name="reject_request">Reject</button>
                                <?php elseif ($row['STATUS_ID'] == 2): ?>
                                    <button type="submit" class="btn btn-success" name="accept_request">Accept</button>
                                <?php elseif ($row['STATUS_ID'] == 1): ?>
                                    <button type="submit" class="btn btn-danger" name="reject_request">Reject</button>
                                <?php endif; ?>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <!-- โค้ด JavaScript เพื่อซ่อนปุ่ม "ไม่ยอมรับ" เมื่อคลิกปุ่ม "ยอมรับ" -->
    <script>
        $(document).ready(function () {
            $('button[name="accept_request"]').click(function () {
                // ซ่อนปุ่ม "ไม่ยอมรับ" ที่อยู่ในแถวที่ถูกคลิก
                $(this).closest('tr').find('button.reject-btn').hide();
            });
        });
    </script>
</body>

</html>