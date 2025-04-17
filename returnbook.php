<?php
session_start();
require_once "config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['userid'])) {
    die("You must be logged in to return a book.");
}

$userid = $_SESSION['userid'];

if (!isset($_GET['loanid'])) {
    die("Loan ID is missing.");
}

$loanid = (int) $_GET['loanid'];


$stmt = $conn->prepare("SELECT bookid FROM loans WHERE loanid = ? AND userid = ? AND returndate IS NULL");
$stmt->bind_param("ii", $loanid, $userid);
$stmt->execute();
$stmt->bind_result($bookid);
if (!$stmt->fetch()) {
    $stmt->close();
    die("Invalid loan ID or book already returned.");
}
$stmt->close();

$returndate = date("Y-m-d");
$stmt = $conn->prepare("UPDATE loans SET returndate = ? WHERE loanid = ?");
$stmt->bind_param("si", $returndate, $loanid);
$stmt->execute();
$stmt->close();

$stmt = $conn->prepare("UPDATE books SET quantity = quantity + 1 WHERE bookid = ?");
$stmt->bind_param("i", $bookid);
$stmt->execute();
$stmt->close();

echo "✅ Book successfully returned.";
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
    <link rel="stylesheet" href="css/styles.css?v=<?= time(); ?>">
</head>
<body>
<button onclick="history.back()" class="btn">← Go Back</button>
</body>
</html>
