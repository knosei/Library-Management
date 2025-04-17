<?php
session_start();
require_once "config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['userid'])) {
    die("You must be logged in to borrow a book.");
}

$userid = $_SESSION['userid'];

if (!isset($_GET['bookid'])) {
    die("Book ID is missing.");
}

$bookid = (int) $_GET['bookid']; 

$stmt = $conn->prepare("SELECT COUNT(*) FROM loans WHERE userid = ? AND returndate IS NULL");
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($borrowed_count);
$stmt->fetch();
$stmt->close();

if ($borrowed_count >= 3) {
    die("Borrowing limit reached. Return a book before borrowing more.");
}

$stmt = $conn->prepare("SELECT quantity, title FROM books WHERE bookid = ?");
$stmt->bind_param("i", $bookid);
$stmt->execute();
$stmt->bind_result($quantity, $booktitle);
$stmt->fetch();
$stmt->close();

if ($quantity < 1) {
    die("Sorry, this book is not available right now.");
}

$borrow_date = date("Y-m-d H:i:s");
$due_date = date("Y-m-d", strtotime("+14 days"));
$returndate = null;

try {
    $stmt = $conn->prepare("INSERT INTO loans (userid, bookid, booktitle, borrowdate, duedate, returndate) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iissss", $userid, $bookid, $booktitle, $borrow_date, $due_date, $returndate);
    $stmt->execute();
    $stmt->close();

    $stmt = $conn->prepare("UPDATE books SET quantity = quantity - 1 WHERE bookid = ?");
    $stmt->bind_param("i", $bookid);
    $stmt->execute();
    $stmt->close();

    echo "✅ You have successfully borrowed the book <strong>$booktitle</strong>";
} catch (mysqli_sql_exception $e) {
    echo "❌ Error borrowing book: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Book</title>
    <link rel="stylesheet" href="css/styles.css?v=<?= time(); ?>">
</head>
<body>
<button onclick="history.back()" class="btn">← Go Back</button>
</body>
</html>
