<?php
session_start();
include_once(dirname(__DIR__) . '/util/check_access_permission.php');
check_access_permission(basename($_SERVER['SCRIPT_FILENAME']));

include('connect.php');
// Fetch a list of job positions and permissions from the database
$jobPositionsQuery = $conn->query("SELECT * FROM jobposition");
$permissionsQuery = $conn->query("SELECT * FROM permission");

$jobPositions = $jobPositionsQuery->fetch_all(MYSQLI_ASSOC);
$permissions = $permissionsQuery->fetch_all(MYSQLI_ASSOC);

// Fetch existing access permissions from the database
$accessPermissions = [];
$accessPermissionQuery = $conn->query("SELECT JOB_ID, PERMIS_ID FROM access_permission");
while ($row = $accessPermissionQuery->fetch_assoc()) {
    $accessPermissions[$row['JOB_ID']][$row['PERMIS_ID']] = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Clear existing access permissions
    $conn->query("DELETE FROM access_permission");

    // Loop through job positions
    foreach ($jobPositions as $jobPosition) {
        // Loop through permissions
        foreach ($permissions as $permission) {
            // Build the checkbox name
            $checkboxName = "permission_{$jobPosition['JID']}_{$permission['PID']}";

            // Check if the checkbox is checked
            $isChecked = isset($_POST[$checkboxName]) ? 1 : 0;

            // Insert into access_permission if the checkbox is checked
            if ($isChecked) {
                $stmt = $conn->prepare("INSERT INTO access_permission (JOB_ID, PERMIS_ID) VALUES (?, ?)");
                if ($stmt === false) {
                    die('Error preparing statement: ' . $conn->error);
                }

                // Bind parameters and execute the statement
                if (!$stmt->bind_param('ss', $jobPosition['JID'], $permission['PID'])) {
                    die('Error binding parameters: ' . $stmt->error);
                }

                if (!$stmt->execute()) {
                    die('Error executing statement: ' . $stmt->error);
                }

                // Close the statement
                $stmt->close();
            }
        }
    }

    // Redirect back to the page after updating permissions
    header("Location: PermissionManage.php");
    exit();
}
include('../navbar.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Employee Permissions</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
        }

        form {
            margin: 20px auto;
            width: 80%;
            max-width: 800px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        input[type="checkbox"] {
            width: 20px;
            height: 20px;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .access-table {
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <h1>Manage Permissions for Employees by Job Position</h1>

    <form method="post">
        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Job Position</th>
                    <?php foreach ($permissions as $permission): ?>
                        <th>
                            <?= $permission['PNAME'] ?>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobPositions as $jobPosition): ?>
                    <tr>
                        <td>
                            <?= $jobPosition['JNAME'] ?>
                        </td>
                        <?php foreach ($permissions as $permission): ?>
                            <td>
                                <?php
                                // Build the checkbox name
                                $checkboxName = "permission_{$jobPosition['JID']}_{$permission['PID']}";

                                // Check if the checkbox is checked based on access_permission data
                                $isChecked = isset($accessPermissions[$jobPosition['JID']][$permission['PID']]) ? 'checked' : '';
                                ?>
                                <input type="checkbox" name="<?= $checkboxName ?>" <?= $isChecked ?>>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Save Permissions</button>

    </form>

    <!-- Table to display how many pages each job position can access -->
    <table class="table access-table">
        <thead class="thead-dark">
            <tr>
                <th>Job Position</th>
                <th>Accessible Pages</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $accessPagesQuery = $conn->query("SELECT jobposition.JNAME, GROUP_CONCAT(permission.PNAME) AS AccessiblePages
                                              FROM jobposition
                                              LEFT JOIN access_permission ON jobposition.JID = access_permission.JOB_ID
                                              LEFT JOIN permission ON access_permission.PERMIS_ID = permission.PID
                                              GROUP BY jobposition.JID");

            while ($accessPages = $accessPagesQuery->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $accessPages['JNAME'] . "</td>";
                echo "<td>" . $accessPages['AccessiblePages'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Include Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</body>

</html>