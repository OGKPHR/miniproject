<!DOCTYPE html>
<html>
<head>
    <title>Add Permission and Manage Permissions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            padding: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        /* CSS for the modal */
        .modal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }
    </style>
</head>
<body>
<h1>Add Permission and Manage Permissions</h1>
<div class="container">
        <?php
        // Include the database connection file
        require_once 'connect.php';

        // Check if the form is submitted to add a new permission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_permission"])) {
            // Get input values from the form
            $pName = $_POST["p_name"];
            $filename = $_POST["filename"];

            // Validate that the inputs are not empty
            if (!empty($pName) && !empty($filename)) {
                // Prepare and execute the SQL statement to insert data into the PERMISSION table
                $sql = "INSERT INTO PERMISSION (PNAME, FILENAME) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $pName, $filename);

                if ($stmt->execute()) {
                    echo "Permission added successfully!";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                // Close the database connection
                $stmt->close();
            } else {
                echo "Permission Name and File Name are required.";
            }
        }

        // Check if the form is submitted to edit a permission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["edit_permission"])) {
            // Get input values from the form
            $pid = $_POST["pid"];
            $editedFilename = $_POST["editedFilename"];

            // Validate that the input is not empty
            if (!empty($editedFilename)) {
                // Prepare and execute the SQL statement to update the permission in the database
                $sql = "UPDATE PERMISSION SET FILENAME = ? WHERE PID = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $editedFilename, $pid);

                if ($stmt->execute()) {
                    echo "Permission updated successfully!";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }

                // Close the database connection
                $stmt->close();
            } else {
                echo "PHP Filename is required.";
            }
        }

        // Check if the permission ID is provided in the URL for deletion
        if (isset($_GET["action"]) && $_GET["action"] === "delete" && isset($_GET["pid"])) {
            // Get the permission ID from the URL
            $pid = $_GET["pid"];

            // Prepare and execute the SQL statement to delete the permission from the database
            $sql = "DELETE FROM PERMISSION WHERE PID = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $pid);

            if ($stmt->execute()) {
               
                header('location:Permission.php');
                echo "Permission deleted successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // Close the database connection
            $stmt->close();
        }
        ?>

        <h2>Add Permission</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="p_name">Permission Name:</label>
                <input type="text" id="p_name" name="p_name" required>
            </div>

            <div class="form-group">
                <label for="filename">PHP Filename:</label>
                <input type="text" id="filename" name="filename" required>
            </div>

            <div class="form-group">
                <input type="submit" name="add_permission" value="Add Permission">
            </div>
        </form>

        <h2>Manage Permissions</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Permission Name</th>
                <th>PHP Filename</th>
                <th>Action</th>
            </tr>
            <?php
            include_once('connect.php');
            $sql = "SELECT * FROM PERMISSION";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["PID"] . "</td>";
                    echo "<td>" . $row["PNAME"] . "</td>";
                    echo "<td>" . $row["FILENAME"] . "</td>";
                    echo '<td>';
                    echo '<button class="edit-button" data-pid="' . $row["PID"] . '" data-pname="' . $row["PNAME"] . '" data-filename="' . $row["FILENAME"] . '">Edit</button>';
                    echo '<a href="?action=delete&pid=' . $row["PID"] . '">Delete</a>';
                    echo '</td>';
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No permissions found</td></tr>";
            }
            ?>
        </table>

        <!-- Modal for editing permissions -->
        <div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h2>Edit Permission</h2>
        <form id="editPermissionForm">
            <!-- Corrected input names and removed action attribute -->
            <input type="hidden" id="edit_pid" name="pid">
            <div class="form-group">
                <label for="edit_p_name">Permission Name:</label>
                <input type="text" id="edit_p_name" name="edit_p_name" required>
            </div>

            <div class="form-group">
                <label for="edit_filename">PHP Filename:</label>
                <!-- Corrected name attribute -->
                <input type="text" id="edit_filename" name="edit_filename" required>
            </div>

            <div class="form-group">
                <input type="submit" name="edit_permission" value="Save">
            </div>
        </form>
    </div>
</div>
<script>
    // JavaScript functions for showing and hiding the edit modal
    function editPermission(pid, pName, filename) {
        document.getElementById("edit_pid").value = pid;
        document.getElementById("edit_p_name").value = pName;
        document.getElementById("edit_filename").value = filename;
        document.getElementById("editModal").style.display = "block";
    }

    function closeEditModal() {
        document.getElementById("editModal").style.display = "none";
    }

    // Handle form submission for editing permission
    document.getElementById("editPermissionForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission
        var formData = new FormData(this);

        // Send an AJAX request to update the permission
        fetch("Permission.php", {
            method: "POST",
            body: formData,
        })
        .then(function(response) {
            return response.text();
        })
        .then(function(data) {
            // Handle the response from the server (e.g., display a success message)
            alert(data); // You can replace this with more user-friendly feedback
            closeEditModal(); // Close the edit modal
            location.reload(); // Refresh the page to reflect changes
        })
        .catch(function(error) {
            console.error("Error:", error);
        });
    });

    // Add event listeners to the "Edit" buttons
    var editButtons = document.querySelectorAll(".edit-button");
    editButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var pid = button.getAttribute("data-pid");
            var pname = button.getAttribute("data-pname");
            var filename = button.getAttribute("data-filename");
            editPermission(pid, pname, filename);
        });
    });
</script>

    </div>
</body>
</html>
