<?php
require_once "admin/connect.php";
$query = "SELECT r.RID, d.DNAME, j.JNAME, r.QUANTITY, GROUP_CONCAT(s.SKILLNAME) AS SKILLS
          FROM request r
          JOIN department d ON r.DEPTREQUEST = d.DID
          JOIN jobposition j ON r.JOBREQUEST = j.JID
          LEFT JOIN request_skill rs ON r.RID = rs.REQUEST_ID
          LEFT JOIN skill s ON rs.SKILL_ID = s.SKILLID
          WHERE r.STATUS_ID = 2
          GROUP BY r.RID, d.DNAME, j.JNAME, r.QUANTITY";

$result = mysqli_query($conn, $query);
?>

<?php include 'navbar.php';?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Openings</title>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> -->

    <style>
        .job-listing {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .job-title {
            font-size: 24px;
            font-weight: bold;
        }

        .job-info {
            font-size: 18px;
        }

        .skills {
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2>Job Openings</h2>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="job-listing">
                <div class="job-title">
                    <?php echo $row['JNAME']; ?>
                </div>
                <div class="job-info">
                    <div>Department:
                        <?php echo $row['DNAME']; ?>
                    </div>
                    <div>Quantity:
                        <?php echo $row['QUANTITY']; ?>
                    </div>
                    <div class="skills">Skills:
                        <?php echo $row['SKILLS']; ?>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</body>

</html>