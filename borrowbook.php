<?php 
session_start();
require_once "config.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
// if (!isset($_SESSION["userid"])) {
//     die("You must be logged in to borrow a book.");
// }

$success_message = ''; 
$error_message = ''; 

// Fetch available books for the dropdown
$stmt = $conn->query("SELECT * FROM books WHERE quantity > 0"); // Ensure that the 'available' column is greater than 0
$books = [];
while ($row = $stmt->fetch_assoc()) {
    $books[] = $row;
}

// Handle book borrowing when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["bookid"])) {
    $bookid = $_POST["bookid"];
    // $user_id = $_SESSION["user_id"];

    // Check how many books the user has already borrowed
    // $stmt = $conn->prepare("SELECT COUNT(*) FROM loans WHERE userid = :userid");
    // $stmt->execute(["userid" => $userid]);
    // $borrowed_count = $stmt->fetchColumn();

    $stmt = $conn->prepare("SELECT COUNT(*) FROM loans WHERE userid = ?");
$stmt->bind_param("i", $userid);
$stmt->execute();
$stmt->bind_result($borrowed_count);
$stmt->fetch();
$stmt->close();


    if ($borrowed_count >= 3) {
        $error_message = "Sorry, you have reached your limit.";
    } else {
        // try {
        //     // Insert into borrowed_books table
        //     $stmt = $conn->prepare("INSERT INTO loans (userid, bookid) VALUES (:userid, :bookid)");
        //     $stmt->execute(["userid" => $userid, "bookid" => $bookid]);

        //     // Update book status to unavailable (0) since it's now borrowed
        //     $stmt = $conn->prepare("UPDATE books SET quantity = quantity - 1 WHERE bookid = :bookid AND quantity > 0");
        //     $stmt->execute(["bookid" => $bookid]);

        //     // Set success message
        //     $success_message = "You have successfully borrowed the book!";
        // } catch (PDOException $e) {
        //     // Handle errors
        //     $error_message = "Error: " . $e->getMessage();
        // }
        try {
            // Insert into loans table
            $stmt = $conn->prepare("INSERT INTO loans (loanid, userid, bookid, borrowdate, duedate, returndate) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("iiisss", $loanid, $userid, $bookid, $borrowdate, $duedate, $returndate);
            $stmt->execute();
            $stmt->close();
        
            // Update book quantity
            $stmt = $conn->prepare("UPDATE books SET quantity = quantity - 1 WHERE bookid = ? AND quantity > 0");
            $stmt->bind_param("i", $bookid);
            $stmt->execute();
            $stmt->close();
        
            $success_message = "You have successfully borrowed the book!";
        } catch (mysqli_sql_exception $e) {
            // $error_message = "Error: " . $e->getMessage();
        }
        
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrow Book</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container ">
        <h2>Borrow a Book</h2>

        <?php if (!empty($success_message)): ?>
            <p style="color: green; font-weight: bold;"><?php echo $success_message; ?></p>
        <?php endif; ?>

        <?php if (!empty($error_message)): ?>
            <p style="color: red; font-weight: bold;"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="book_id">Select a book:</label>
            <select name="bookid" id="bookid" required>
                <option value="" disabled selected>-- Choose a book --</option>
                
                <?php if (count($books) > 0): ?>
                    <?php foreach ($books as $book): ?>
                        <option value="<?= $book['bookid'] ?>"><?= htmlspecialchars($book['title']) ?> by <?= htmlspecialchars($book['author']) ?></option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="" disabled>No available books</option>
                <?php endif; ?>
            </select><br><br>

            <button type="submit" class="btn">Borrow</button>
        </form>
    </div>
</body>
</html>