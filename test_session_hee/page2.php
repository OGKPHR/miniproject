<?php session_start() ?>
<?php 
    $_SESSION["yedhee"] = "hee555";
    header("Location: page1.php");
    exit();
?>