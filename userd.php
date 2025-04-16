<?php
session_start();
require_once "config.php";

$search_query = "";
$filter = "title";

$allowed_filters = ['title', 'author', 'genre'];
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
    $search_query = $_GET['search'];

    if (isset($_GET['filter']) && in_array($_GET['filter'], $allowed_filters)) {
        $filter = $_GET['filter'];
    }
}

$sql = "SELECT * FROM books WHERE $filter LIKE ? AND quantity > 0";
$stmt = $conn->prepare($sql);
$search_param = '%' . $search_query . '%';
$stmt->bind_param("s", $search_param);
$stmt->execute();
$result = $stmt->get_result();
$books = $result->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="container dashboard">
        <h1>User Dashboard</h1>
        <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>

        <section class="search-books">
            <h2>Search Books</h2>
            <form  method="GET" class="search-form">
                <div class="form-group">
                    <input type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search by title, author, or genre">
                    <button type="submit" class="btn">Search</button>
                </div>
                    <select name="filter" id="filter" class="search-select">
                        <option value="title" <?php echo ($filter == "title") ? 'selected' : ''; ?>>Title</option>
                        <option value="author" <?php echo ($filter == "author") ? 'selected' : ''; ?>>Author</option>
                        <option value="genre" <?php echo ($filter == "genre") ? 'selected' : ''; ?>>Genre</option>
                    </select>
            </form>
            <div class="no-results" <?php echo empty($books) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
            <p>No books available.</p>
            </div>


            <div class="book-list" <?php echo !empty($books) ? 'style="display:block;"' : 'style="display:none;"'; ?>>
            <h3>Available Books</h3>
                <?php if (count($books) > 0): ?>
                    <?php foreach ($books as $book): ?>
                        <div class="book-item">
                            <h4><?php echo htmlspecialchars($book['title']); ?></h4>
                            <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
                            <p>ISBN: <?php echo htmlspecialchars($book['isbn']); ?></p>
                            <p>Genre: <?php echo htmlspecialchars($book['genre']); ?></p>
                            <p>Available Quantity: <?php echo $book['quantity']; ?></p>

                            <form  method="POST">
                                <input type="hidden" name="book_id" value="<?php echo $book['bookid']; ?>">
                                <a href="borrow.php?bookid=<?= $book['bookid'] ?>" type="submit" class="btn">Borrow</a>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div> 
        </section>

        <section class="loan-management">
        <h2>My Borrowed Books</h2>
        <div class="loan-list">
        <?php
        // Assume session_start() and $conn setup already exist
        $userid = $_SESSION['userid'];
        $stmt = $conn->prepare("
        SELECT loans.loanid, books.title, loans.borrowdate, loans.duedate 
        FROM loans 
        JOIN books ON loans.bookid = books.bookid 
        WHERE loans.userid = ? AND loans.returndate IS NULL
    ");
        $stmt->bind_param("i", $userid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0):
            while ($loan = $result->fetch_assoc()):
        ?>
            <div class="loan-item">
                <h4><?= htmlspecialchars($loan['title']) ?></h4>
                <p>Borrowed: <?= date("Y-m-d", strtotime($loan['borrowdate'])) ?></p>
                <p>Due: <?= date("Y-m-d", strtotime($loan['duedate'])) ?></p>
                <a href="returnbook.php?loanid=<?= $loan['loanid'] ?>" class="btn">Return Book</a>
            </div>
        <?php
            endwhile;
        else:
        ?>
            <p>No active loans.</p>
        <?php endif; ?>
        </div>
        </section>



        <a onclick="window.location.href='logout.php'" class="btn logout-btn">Logout</a>
    </div>
    
</body>
</html>