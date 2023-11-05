<?php
session_start();
include("navbar.php");
require_once "admin/connect.php";

// Fetch interview data with average scores and quantity from the database
$query = "SELECT a.APPID, a.FNAME, a.LNAME, j.JNAME, 
                 (s.TSCORE + s.CSCORE + s.CRSCORE + s.NLSCORE) / 4 AS AVG_SCORE, 
                 r.QUANTITY, e.EMPID
          FROM applicant a
          JOIN jobposition j ON a.REQUESTID = j.JID
          LEFT JOIN score s ON a.APPID = s.EMPID
          LEFT JOIN request r ON a.REQUESTID = r.JOBREQUEST
          LEFT JOIN employee e ON a.APPID = e.EMPID";
$result = mysqli_query($conn, $query);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIST INTERVIEW</title>
    <style>
        body {
            background-color: rgba(0, 0, 0, 0.245);
        }

        .card {
            background-color: rgba(255, 255, 255, 0.245);
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">
            <table class="table align-middle mb-0 bg-white justify-content-center align-content-center">
                <thead class="bg-light">
                    <tr>
                        <th>ชื่อ</th>
                        <th>ตำแหน่งที่สมัคร</th>
                        <th>คะแนนเฉลี่ย</th>
                        <th>จำนวนการรับ</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Loop through the interview data and populate the table -->
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="ms-3">
                                        <p class="fw-bold mb-1">
                                            <?php echo $row['FNAME'] . ' ' . $row['LNAME']; ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="fw-normal mb-1">
                                    <?php echo $row['JNAME']; ?>
                                </p>
                            </td>
                            <td>
                                <span>
                                    <?php echo number_format($row['AVG_SCORE'], 2); ?>
                                </span>
                            </td>
                            <td>
                                <?php echo $row['QUANTITY']; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <!-- End the loop -->
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>