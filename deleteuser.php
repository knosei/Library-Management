<?php
if (isset($_GET['id'])) {
include("config.php");
$id = $_GET['id'];
$sql = "DELETE FROM users WHERE userid='$id'";
if(mysqli_query($conn,$sql)){
    session_start();
    $_SESSION["deleteuser"] = "User Deleted Successfully!";
    header("Location:admind.php");
}else{
    die("Something went wrong");
}
}else{
    echo "User does not exist";
}
?>