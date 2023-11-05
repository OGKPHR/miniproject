<?php session_start(); ?>
<?php
include(dirname(__DIR__).'/admin/connect.php');
include(dirname(__DIR__).'/navbar.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['add_permission'])) {
        $pName = $_POST["p_name"];
        $filename = $_POST["filename"];
        $query = "INSERT INTO PERMISSION (PNAME, FILENAME) VALUES ('$pName', '$filename')";
        if (mysqli_query($conn, $query)) {
            header("Location: add_permission.php");
            exit;
        } else {
            die("Error: " . mysqli_error($conn));
        }
    } elseif (isset($_POST['edit_permission'])) {
        $pid = $_POST['pid'];
        $editedPName = $_POST['edited_p_name']; // Updated line
        $editedFilename = $_POST['edited_filename'];
        $edit_query = "UPDATE PERMISSION SET PNAME = '$editedPName', FILENAME = '$editedFilename' WHERE PID = '$pid'";
        if (mysqli_query($conn, $edit_query)) {
            header("Location: add_permission.php");
            exit;
        } else {
            echo "Error editing permission: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_permission'])) {
        $pid = $_POST['pid'];
        $delete_query = "DELETE FROM PERMISSION WHERE PID = '$pid'";
        if (mysqli_query($conn, $delete_query)) {
            header("Location: add_permission.php");
            exit;
        } else {
            echo "Error deleting permission: " . mysqli_error($conn);
        }
    }
}

$query = "SELECT * FROM PERMISSION";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Permission</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Add Permission</h2>
        <form method="POST">
            <div class="form-group">
                <label for="p_name">Permission Name:</label>
                <input type="text" class="form-control" id="p_name" name="p_name" required>
            </div>
            <div class="form-group">
                <label for="filename">PHP Filename:</label>
                <input type="text" class="form-control" id="filename" name="filename" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_permission">Add Permission</button>
        </form>
        <?php if (isset($_GET['edit_id'])): ?>
            <?php
            $edit_id = $_GET['edit_id'];
            $edit_query = "SELECT * FROM PERMISSION WHERE PID = '$edit_id'";
            $edit_result = mysqli_query($conn, $edit_query);
            $edit_row = mysqli_fetch_assoc($edit_result);
            ?>
            <h2 class="mt-4">Edit Permission</h2>
            <form method="POST">
                <input type="hidden" name="pid" value="<?php echo $edit_row['PID']; ?>">
                <div class="form-group">
                    <label for="edit_p_name">Permission Name:</label>
                    <input type="text" class="form-control" id="edit_p_name" name="edited_p_name" required
                        value="<?php echo $edit_row['PNAME']; ?>">
                </div>
                <div class="form-group">
                    <label for="edit_filename">PHP Filename:</label>
                    <input type="text" class="form-control" id="edit_filename" name="edited_filename" required
                        value="<?php echo $edit_row['FILENAME']; ?>">
                </div>
                <button type="submit" class="btn btn-success" name="edit_permission">Save</button>
            </form>
        <?php endif; ?>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Permission Name</th>
                    <th>PHP Filename</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?php echo $row['PID']; ?>
                        </td>
                        <td>
                            <?php echo $row['PNAME']; ?>
                        </td>
                        <td>
                            <?php echo $row['FILENAME']; ?>
                        </td>
                        <td>
                            <a href="add_permission.php?edit_id=<?php echo $row['PID']; ?>"
                                class="btn btn-warning">Edit</a>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="pid" value="<?php echo $row['PID']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_permission">Delete</button>
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
        <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
