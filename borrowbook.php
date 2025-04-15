<?php
session_start();
include 'config.php';

$usermail = $_SESSION['email'];
$bookisbn = $_GET['isbn'];

// To check if user has borrowed up to 3 books already
$check = mysqli_query($conn, "SELECT COUNT(*) as count FROM loans WHERE email = $usermail AND returned = 0");
$count = mysqli_fetch_assoc($check)['count'];

if ($count >= 3) {
    echo "<script>alert('You can only borrow 3 books at a time!'); window.location='dashboard.php';</script>";
} else {
    // To borrow book
    mysqli_query($conn, "INSERT INTO loans (user_id, book_id, due_date) VALUES ($user_id, $book_id, DATE_ADD(NOW(), INTERVAL 14 DAY))");
    mysqli_query($conn, "UPDATE books SET quantity = quantity - 1 WHERE id = $book_id");

    echo "<script>alert('Book borrowed successfully!'); window.location='borrowedbooks.php';</script>";
}
?>