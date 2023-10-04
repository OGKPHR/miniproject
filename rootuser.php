<?php
include_once('connect.php');

// Fetch a list of job positions from the database
$jobPositionsQuery = $conn->query("SELECT * FROM jobposition");
$jobPositions = [];
while ($row = $jobPositionsQuery->fetch_assoc()) {
    $jobPositions[] = $row;
}

// Fetch a list of permissions from the database
$permissionsQuery = $conn->query("SELECT * FROM permission");
$permissions = [];
while ($row = $permissionsQuery->fetch_assoc()) {
    $permissions[] = $row;
}

// Initialize an empty array to store the current permissions for each job position
$accessPermissions = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission to update permissions
    foreach ($jobPositions as $jobPosition) {
        foreach ($permissions as $permission) {
            $checkboxName = "permission_{$jobPosition['JID']}_{$permission['PID']}";
            $isChecked = isset($_POST[$checkboxName]) ? 1 : 0;

            // Update the access_permission table based on checkbox values
            $jobId = $jobPosition['JID'];
            $permissionId = $permission['PID'];

            // Check if the entry already exists in access_permission
            $checkExistsQuery = $conn->prepare("SELECT * FROM access_permission WHERE JOB_ID = ? AND PERMIS_ID = ?");
            $checkExistsQuery->bind_param("ss", $jobId, $permissionId);
            $checkExistsQuery->execute();
            $result = $checkExistsQuery->get_result();

            if ($result->num_rows > 0) {
                // Entry exists, update it
                $updateAccessQuery = $conn->prepare("UPDATE access_permission SET permission = ? WHERE JOB_ID = ? AND PERMIS_ID = ?");
                $updateAccessQuery->bind_param("ss", $isChecked, $jobId, $permissionId);
                $updateAccessQuery->execute();
            } else {
                // Entry does not exist, insert a new one
                $insertAccessQuery = $conn->prepare("INSERT INTO access_permission (JOB_ID, PERMIS_ID, permission) VALUES (?, ?, ?)");
                $insertAccessQuery->bind_param("ss", $jobId, $permissionId);
                $insertAccessQuery->execute();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Employee Permissions</title>
</head>
<body>
    <h1>Manage Permissions for Employees by Job Position</h1>
    
    <form method="post">
        <table border="1">
            <thead>
                <tr>
                    <th>Job Position</th>
                    <?php foreach ($permissions as $permission) : ?>
                        <th><?= $permission['PNAME'] ?></th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobPositions as $jobPosition) : ?>
                    <tr>
                        <td><?= $jobPosition['JNAME'] ?></td>
                        <?php foreach ($permissions as $permission) : ?>
                            <td>
                                <?php
                                // Determine the checkbox name and value based on the permission and job position
                                $checkboxName = "permission_{$jobPosition['JID']}_{$permission['PID']}";
                                $isChecked = isset($_POST[$checkboxName]) ? 'checked' : '';
                                ?>
                                <input type="checkbox" name="<?= $checkboxName ?>" value="1" <?= $isChecked ?>>
                            </td>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <button type="submit">Save Permissions</button>
    </form>
</body>
</html>
