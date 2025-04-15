<?php
if (isset($_GET['id'])) {
include("config.php");
$id = $_GET['id'];
$sql = "DELETE FROM books WHERE bookid='$id'";
if(mysqli_query($conn,$sql)){
    session_start();
    $_SESSION["delete"] = "Book Deleted Successfully!";
    header("Location:admind.php");
}else{
    die("Something went wrong");
}
}else{
    echo "Book does not exist";
}
?>