<?php
require_once "connect.php"; // Connect to the database

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['add_job'])) {
        $name = $_POST["name"];
        $nextJID = getNextJID($conn); // Get the next available JID
        $query = "INSERT INTO jobposition (JID, JNAME) VALUES ('$nextJID', '$name')";
        if (mysqli_query($conn, $query)) {
            header("Location: add_jobposition.php");
            exit;
        } else {
            die("Error: " . mysqli_error($conn));
        }
    } elseif (isset($_POST['edit_job'])) {
        $jid = $_POST['jid'];
        $name = $_POST['name'];
        $edit_query = "UPDATE jobposition SET JNAME = '$name' WHERE JID = '$jid'";
        if (mysqli_query($conn, $edit_query)) {
            header("Location: add_jobposition.php");
            exit;
        } else {
            echo "Error editing job position: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_job'])) {
        $jid = $_POST['jid'];
        $delete_query = "DELETE FROM jobposition WHERE JID = '$jid'";
        if (mysqli_query($conn, $delete_query)) {
            header("Location: add_jobposition.php");
            exit;
        } else {
            echo "Error deleting job position: " . mysqli_error($conn);
        }
    }
}

// Function to get the next available JID
function getNextJID($conn) {
    $query = "SELECT MAX(CAST(SUBSTRING(JID, 2) AS UNSIGNED)) AS max_jid FROM jobposition";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $maxJID = (int)$row['max_jid'];

    if ($maxJID < 99) {
        $nextJID = 'J' . str_pad($maxJID + 1, 2, '0', STR_PAD_LEFT);
    } else {
        $nextJID = 'J99'; // Maximum JID reached
    }

    return $nextJID;
}

$query = "SELECT * FROM jobposition";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Job Position</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Add Job Position</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_job">Add</button>
        </form>
        <?php if (isset($_GET['edit_id'])): ?>
            <?php
            $edit_id = $_GET['edit_id'];
            $edit_query = "SELECT * FROM jobposition WHERE JID = '$edit_id'";
            $edit_result = mysqli_query($conn, $edit_query);
            $edit_row = mysqli_fetch_assoc($edit_result);
            ?>
            <h2 class="mt-4">Edit Job Position</h2>
            <form method="POST">
                <input type="hidden" name="jid" value="<?php echo $edit_row['JID']; ?>">
                <div class="form-group">
                    <label for="editName">Name:</label>
                    <input type="text" class="form-control" id="editName" name="name" required
                        value="<?php echo $edit_row['JNAME']; ?>">
                </div>
                <button type="submit" class="btn btn-success" name="edit_job">Save</button>
            </form>
        <?php endif; ?>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?php echo $row['JID']; ?>
                        </td>
                        <td>
                            <?php echo $row['JNAME']; ?>
                        </td>
                        <td><a href="add_jobposition.php?edit_id=<?php echo $row['JID']; ?>"
                                class="btn btn-warning">Edit</a></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="jid" value="<?php echo $row['JID']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_job">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
