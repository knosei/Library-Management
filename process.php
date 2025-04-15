<?php
include('config.php');
if (isset($_POST["create"])) {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $author = mysqli_real_escape_string($conn, $_POST["author"]);
    $isbn = mysqli_real_escape_string($conn, $_POST["isbn"]);
    $genre = mysqli_real_escape_string($conn, $_POST["genre"]);
    $quantity = mysqli_real_escape_string($conn, $_POST["quantity"]);
    $sqlInsert = "INSERT INTO books (title, author, isbn, genre, quantity) VALUES ('$title','$author','$isbn', '$genre', '$quantity')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["create"] = "Book Added Successfully!";
        header("Location:admind.php");
    }else{
        die("Something went wrong");
    }
}
if (isset($_POST["edit"])) {
    $title = mysqli_real_escape_string($conn, $_POST["title"]);
    $author = mysqli_real_escape_string($conn, $_POST["author"]);
    $isbn = mysqli_real_escape_string($conn, $_POST["isbn"]);
    $genre = mysqli_real_escape_string($conn, $_POST["genre"]);
    $quantity = mysqli_real_escape_string($conn, $_POST["quantity"]);
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sqlUpdate = "UPDATE books SET title = '$title', author = '$author', isbn = '$isbn', genre = '$genre', quantity = '$quantity' WHERE bookid='$id'";
    if(mysqli_query($conn,$sqlUpdate)){
        session_start();
        $_SESSION["update"] = "Book Updated Successfully!";
        header("Location:admind.php");
    }else{
        die("Something went wrong");
    }
}

if (isset($_POST["createuser"])) {
    $name = mysqli_real_escape_string($conn, $_POST["uname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, password_hash($_POST['password'], PASSWORD_DEFAULT));
    $role = mysqli_real_escape_string($conn, $_POST["role"]);
    $sqlInsert = "INSERT INTO users (name, email, password, role) VALUES ('$name','$email','$password', '$role')";
    if(mysqli_query($conn,$sqlInsert)){
        session_start();
        $_SESSION["createuser"] = "User Added Successfully!";
        header("Location:admind.php");
        echo "user created";
    }else{
        die("Something went wrong");
    }
}

if (isset($_POST["edituser"])) {
    $name = mysqli_real_escape_string($conn, $_POST["uname"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, password_hash($_POST['password'], PASSWORD_DEFAULT));
    $role = mysqli_real_escape_string($conn, $_POST["role"]);
    $id = mysqli_real_escape_string($conn, $_POST["id"]);
    $sqlUpdate = "UPDATE users SET name = '$name', email = '$email', password = '$password', role = '$role' WHERE userid='$id'";
    if(mysqli_query($conn,$sqlUpdate)){
        session_start();
        $_SESSION["updateuser"] = "User Updated Successfully!";
        header("Location:admind.php");
    }else{
        die("Something went wrong");
    }
}
?>