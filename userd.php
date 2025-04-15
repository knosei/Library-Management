<?php

session_start();
if(!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<?php
include 'config.php';

// Fetch unique authors and genres
$authors = mysqli_query($conn, "SELECT DISTINCT author FROM books WHERE quantity > 0");
$genres = mysqli_query($conn, "SELECT DISTINCT genre FROM books WHERE quantity > 0");

// Fetch books with search and filter
$search = $_GET['search'] ?? '';
$author = $_GET['author'] ?? '';
$genre = $_GET['genre'] ?? '';

$query = "SELECT * FROM books WHERE quantity > 0";
if ($search) {
    $query .= " AND title LIKE '%$search%'";
}
if ($author) {
    $query .= " AND author='$author'";
}
if ($genre) {
    $query .= " AND genre='$genre'";
}
$result = mysqli_query($conn, $query);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Library Management System</title>
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
                    <input type="text" name="search" value="<?= $search ?>" placeholder="Search by title, author, or genre">
                    <button type="submit" class="btn">Search</button>
                </div>
            </form>

            <div class="book-list">
                <h3>Available Books</h3>
                        <?php
                            include('config.php');
                            $sqlSelect = "SELECT * FROM books";
                            $result = mysqli_query($conn,$sqlSelect);
                            while($data = mysqli_fetch_array($result)){
                                // $formId = "editbook" . $data['id'];
                            ?>   
                                <div class="book-item">
                                <h4><?php echo $data['title']; ?></h4>
                                <p>Author: <?php echo $data['author']; ?></p>
                                <p>ISBN: <?php echo $data['isbn']; ?></p>
                                <p>Genre: <?php echo $data['genre']; ?></p>
                                <p>Available: <?php echo $data['quantity']; ?>/<?php echo $data['quantity']; ?></p>
                                <a href="" class="btn">Borrow</a>
                                <!-- <button class="btn" disabled>Not Available</button> -->
                            </div>
                    <!-- <p>No books available.</p> -->
                    <?php    
                    }?> 
            </div>
        </section>
        <section class="loan-management">
            <h2>My Borrowed Books</h2>
            <div class="loan-list">
                        <div class="loan-item">
                            <h4>{{ loan.book.title }}</h4>
                            <p>Borrowed: {{ loan.borrow_date.strftime('%Y-%m-%d') }}</p>
                            <p>Due: {{ loan.return_date.strftime('%Y-%m-%d') }}</p>
                            <a href="{{ url_for('return_book', loan_id=loan.id) }}" class="btn">Return Book</a>
                        </div>
                    <p>No active loans.</p>
            </div>
        </section>
        <a onclick="window.location.href='logout.php'" class="btn logout-btn">Logout</a>
    </div>
    
</body>
</html>