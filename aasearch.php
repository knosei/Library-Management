<?php

include 'config.php';

$search = "";
if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);
    $sql = "SELECT * FROM books WHERE title LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM books";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
        }
        input {
            padding: 10px;
            width: 70%;
            margin-right: 5px;
        }
        button {
            padding: 10px;
        }
        .book {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Search Books</h2>
    <form method="POST">
        <input type="text" name="search" placeholder="Enter book title" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>

    <h3>Available Books</h3>
    
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='book'>";
            echo "<h4>" . htmlspecialchars($row["title"]) . "</h4>";
            echo "<p>Author: " . htmlspecialchars($row["author"]) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p>No books found.</p>";
    }

    $conn->close();
    ?>
</div>

</body>
</html>
