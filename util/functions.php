<?php
    function alert($msg, $redirect = null) {
        if(isset($redirect)) {
            echo "<script type='text/javascript'> alert('$msg'); window.location.href='$redirect'; </script>";
        } else {
            echo "<script type='text/javascript'> alert('$msg'); </script>";
        }
    }
?>