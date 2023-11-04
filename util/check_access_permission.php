<?php
    include_once(dirname(__DIR__).'/util/functions.php');

    function check_access_permission($current_file_name) {
        // $current_file_name = basename($_SERVER['SCRIPT_FILENAME']);

        include_once(dirname(__DIR__) . '/admin/connect.php');

        $q = $conn->prepare("SELECT filename FROM access_permission ap JOIN permission p on ap.PERMIS_ID = p.PID WHERE JOB_ID = ?");
        $q->bind_param("s", $_SESSION["job_id"]);
        $q->execute();
        $current_user_accessible_pages = $q->get_result();

        $allowed_access = false;
        while ($page = $current_user_accessible_pages->fetch_assoc()) {
            if (strrchr($page["filename"], $current_file_name)) {
                $allowed_access = true;
                break;
            }
        }

        if (!$allowed_access) {
            alert("You are not allowed to access this page", "/mini/index.php");
            exit();
        }
    }
?>