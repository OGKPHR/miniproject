<?php session_start() ?>
<?php
    include('admin/connect.php');
    $q_update_req = $conn->prepare("UPDATE request SET status_id = ? WHERE rid = ?");
    $q_update_req->bind_param("ss", $_GET["status"], $_GET["rid"]);
    $q_update_req->execute();

    header("location: /mini/jobrequestboss.php");
    exit();
?>
