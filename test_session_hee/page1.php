<?php 
require '../admin/connect.php';

session_abort();
session_start(); ?>
<?php 
    if(isset($_SESSION)) {
        var_dump($_SESSION);
        //session_destroy();
    }
    else {
        echo "no <br>";
    }

$query_permission_list = $conn->prepare("SELECT permis_id FROM access_permission WHERE JOB_ID = ?");
$job_id = "J02";
$query_permission_list->bind_param("s", $job_id);

$query_permission_list->execute();

$result = $query_permission_list->get_result();

if($result->num_rows <= 0) {
    //TODO: check no permission?
    exit();
}

while($page = $result->fetch_assoc()) {
    echo "<br>";
    $query_permission_page = $conn->prepare("SELECT filename FROM permission WHERE PID = ?");
    $pid = $page["permis_id"];
    $query_permission_page->bind_param("s", $pid);

    $query_permission_page->execute();

    $result_page = $query_permission_page->get_result();

    if($result_page->num_rows <= 0) {
        continue;
    }

    $a = $result_page->fetch_assoc()["filename"];
    var_dump($a);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <hr>
    <a href="page2.php">hee</a>
</body>
</html>
