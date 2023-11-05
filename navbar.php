<?php require 'admin/connect.php';
// Check if the logout action has been requested
if (isset($_SESSION['user_id'])) {
    $username = $_SESSION['username'];
}
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    require_once('logout.php');
    header('Location: index.php'); // Redirect to the index page
    exit(); // Stop further script execution after a redirect
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <!-- Container wrapper -->
        <div class="container-fluid ">
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- Collapsible wrapper -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <a class="navbar-brand mt-2 mt-lg-0" href="/mini/ ">
                    <img src="https://e7.pngegg.com/pngimages/70/751/png-clipart-logo-graphic-design-m-letter-angle-text.png"
                        height="40" width="40" alt="MDB Logo" loading="lazy" class="rounded-circle" />
                </a>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/mini/">Home</a>
                    </li>
                </ul>
            </div>
            <!-- Right elements -->


            <div class="d-flex align-items-center">

                <?php
                if (isset($_SESSION['user_id'])) {
                    // User is logged in
                    ?>

                    <div class="dropdown"></div>
                    <Your class="text-light">NAME :
                        <?php echo htmlspecialchars($username); ?>
                    </Your>
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuAvatar" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://www.asirox.com/wp-content/uploads/2022/07/pngtree-user-vector-avatar-png-image_1541962.jpeg"
                            class="rounded-circle" height="45" alt="Black and White Portrait of a Man" loading="lazy"
                            style="background-color: aliceblue" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuAvatar">
                        <?php
                        $query_permission_list = $conn->prepare("SELECT permis_id FROM access_permission WHERE JOB_ID = ?");
                        $query_permission_list->bind_param("s", $_SESSION["job_id"]);

                        $query_permission_list->execute();

                        $result = $query_permission_list->get_result();

                        // if($result->num_rows <= 0) {
                        //     //TODO: check no permission?
                        //     exit();
                        // }
                    
                        while ($page = $result->fetch_assoc()) {
                            $query_permission_page = $conn->prepare("SELECT pname, filename FROM permission WHERE PID = ?");
                            $pid = $page["permis_id"];
                            $query_permission_page->bind_param("s", $pid);

                            $query_permission_page->execute();

                            $result_page = $query_permission_page->get_result();

                            if ($result_page->num_rows <= 0) {
                                continue;
                            }

                            $a = $result_page->fetch_assoc();
                            $page_url = $a["filename"];
                            $page_name = $a["pname"];
                            ?><a class="dropdown-item" href="<?= $page_url ?>">
                                <?= $page_name ?>
                            </a>
                        <?php } ?>
                        <a class="dropdown-item" href="/mini/logout.php">Logout </a>
                    </div>
                </div>
                <?php
                } else {
                    // User is not logged in
                    ?>
                <a id="login" href="/mini/login.php" class="text-light">Login</a>
                <!-- 
                <button class="btn btn-success" href="/mini/logout.php" >Logout</button> -->
                <?php
                }
                ?>
        </div>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>