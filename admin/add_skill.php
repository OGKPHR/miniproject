<?php
require_once "connect.php"; // Connect to the database

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['add_skill'])) {
        $name = $_POST["name"];
        $newSkillID = getNextSKILLID($conn); // Get the next available SKILLID
        $query = "INSERT INTO skill (SKILLID, SKILLNAME) VALUES ($newSkillID, '$name')";
        if (mysqli_query($conn, $query)) {
            header("Location: add_skill.php");
            exit;
        } else {
            die("Error: " . mysqli_error($conn));
        }
    } elseif (isset($_POST['edit_skill'])) {
        $skid = $_POST['skid'];
        $name = $_POST['name'];
        $edit_query = "UPDATE skill SET SKILLNAME = '$name' WHERE SKILLID = $skid";
        if (mysqli_query($conn, $edit_query)) {
            header("Location: add_skill.php");
            exit;
        } else {
            echo "Error editing skill: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['delete_skill'])) {
        $skid = $_POST['skid'];
        $delete_query = "DELETE FROM skill WHERE SKILLID = $skid";
        if (mysqli_query($conn, $delete_query)) {
            header("Location: add_skill.php");
            exit;
        } else {
            echo "Error deleting skill: " . mysqli_error($conn);
        }
    }
}

// Function to get the next available SKILLID
function getNextSKILLID($conn) {
    $query = "SELECT MAX(SKILLID) AS max_SKILLID FROM skill";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $maxSKILLID = (int)$row['max_SKILLID'];

    if ($maxSKILLID < 999999) {
        $nextSKILLID = $maxSKILLID + 1;
    } else {
        die("Error: SKILLID limit reached.");
    }

    return $nextSKILLID;
}

$query = "SELECT * FROM skill";
$result = mysqli_query($conn, $query);
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Skill</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2 class="mt-4">Add Skill</h2>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <button type="submit" class="btn btn-primary" name="add_skill">Add</button>
        </form>
        <?php if (isset($_GET['edit_id'])): ?>
            <?php
            $edit_id = $_GET['edit_id'];
            $edit_query = "SELECT * FROM skill WHERE SKILLID = '$edit_id'";
            $edit_result = mysqli_query($conn, $edit_query);
            $edit_row = mysqli_fetch_assoc($edit_result);
            ?>

            <h2 class="mt-4">Edit Skill</h2>
            <form method="POST">
                <input type="hidden" name="skid" value="<?php echo $edit_row['SKILLID']; ?>">
                <div class="form-group">
                    <label for="editName">Name:</label>
                    <input type="text" class="form-control" id="editName" name="name" required
                        value="<?php echo $edit_row['SKILLNAME']; ?>">
                </div>
                <button type="submit" class="btn btn-success" name="edit_skill">Save</button>
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
                            <?php echo $row['SKILLNAME']; ?>
                        </td>
                        <td><a href="add_skill.php?edit_id=<?php echo $row['SKILLID']; ?>" class="btn btn-warning">Edit</a>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="skid" value="<?php echo $row['SKILLID']; ?>">
                                <button type="submit" class="btn btn-danger" name="delete_skill">Delete</button>
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