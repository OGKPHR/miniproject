<?php
    function alert($msg, $redirect = null) {
        if(isset($redirect)) {
            echo "<script type='text/javascript'> alert('$msg'); window.location.href='$redirect'; </script>";
        } else {
            echo "<script type='text/javascript'> alert('$msg'); </script>";
        }
    }

    function genDepartmentID() {
        include(dirname(__DIR__) . '/admin/connect.php');

        $q = $conn->prepare("select did from department order by did desc limit 1");
        $q->execute();
        $result = $q->get_result()->fetch_assoc()["did"];

        $num = (int)substr($result,1);
        $new_num = $num + 1;
        $new_id = "D";

        if($new_num < 10) {
            $new_id .= "0";
        }
        $new_id .= $new_num;

        return $new_id;
    }

    function genJobPositionID() {
        include(dirname(__DIR__) . '/admin/connect.php');

        $q = $conn->prepare("select jid from jobposition order by jid desc limit 1");
        $q->execute();
        $result = $q->get_result()->fetch_assoc()["jid"];

        $num = (int)substr($result,1);
        $new_num = $num + 1;
        $new_id = "J";

        if($new_num < 10) {
            $new_id .= "0";
        }
        $new_id .= $new_num;

        return $new_id;
    }
?>