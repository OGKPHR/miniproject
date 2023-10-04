<?php
require_once "connect.php"; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['add_department'])) {
        $name = $_POST["name"];
        $query = "INSERT INTO department (DNAME) VALUES ('$name')";
        if (mysqli_query($conn, $query)) {
            header("Location: add_department.php");
            exit;
        } else {
            die("Error: " . mysqli_error($conn));
        }
    } elseif (isset($_POST['edit_department'])) {
        $did = $_POST['did'];
        $name = $_POST['name'];
        $edit_query = "UPDATE department SET DNAME = '$name' WHERE DID = '$did'";
        if (mysqli_query($conn, $edit_query)) {
            header("Location: add_department.php");
            exit;
        } else {
            echo "Error editing department: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_department'])) {
        $did = $_POST['did'];
        $delete_query = "DELETE FROM department WHERE DID = '$did'";
        if (mysqli_query($conn, $delete_query)) {
            header("Location: add_department.php");
            exit;
        } else {
            echo "Error deleting department: " . mysqli_error($conn);
        }
    }
}

$query = "SELECT * FROM department";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Add Department</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_department">Add</button>
        </form>
        <?php if (isset($_GET['edit_id'])): ?>
            <?php
            $edit_id = $_GET['edit_id'];
            $edit_query = "SELECT * FROM department WHERE DID = '$edit_id'";
            $edit_result = mysqli_query($conn, $edit_query);
            $edit_row = mysqli_fetch_assoc($edit_result);
            ?>

            <h2 class="mt-4">Edit Department</h2>
            <form method="POST">
                <input type="hidden" name="did" value="<?php echo $edit_row['DID']; ?>">
                <div class="form-group">
                    <label for="editName">Name:</label>
                    <input type="text" class="form-control" id="editName" name="name" required
                        value="<?php echo $edit_row['DNAME']; ?>">
                </div>
                <button type="submit" class="btn btn-success" name="edit_department">Save</button>
            </form>
        <?php endif; ?>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td>
                            <?php echo $row['DNAME']; ?>
                        </td>
                        <td><a href="add_department.php?edit_id=<?php echo $row['DID']; ?>" class="btn btn-warning">Edit</a>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="did" value="<?php echo $row['DID']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_department">Delete</button>
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