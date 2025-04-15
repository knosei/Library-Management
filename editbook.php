<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<section class="book-management">
<form action="process.php" method="post" class="edit-form">
            <?php 
            if (isset($_GET['id'])) {
                include("config.php");
                $id = $_GET['id'];
                $sql = "SELECT * FROM books WHERE bookid=$id";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_array($result);
                ?>

    <div class="aform-group">
        <label >Title</label>
        <input type="text"  name="title" value="<?php echo $row["title"]; ?>" required>
    </div>
    <div class="aform-group">
        <label >Author</label>
        <input type="text"  name="author" value="<?php echo $row["author"]; ?>" required>
    </div>
    <div class="aform-group">
        <label >ISBN</label>
        <input type="text"  name="isbn" value="<?php echo $row["isbn"]; ?>" required>
    </div>
    <div class="aform-group">
        <label >Genre</label>
        <input type="text"  name="genre" value="<?php echo $row["genre"]; ?>" required>
    </div>
    <div class="aform-group">
        <label >Quantity</label>
        <input type="number" name="quantity" value="<?php echo $row["quantity"]; ?>" required min="1">
    </div>
    <input type="hidden" value="<?php echo $id; ?>" name="id">
    <button type="submit" name ="edit" class="btn">Update</button>
    <!-- <button type="button" class="btn cancel-btn" onclick="toggleEditForm('edit-form-{{ book.id }}')">Cancel</button> -->
    <?php
            }
            // else{
            //     echo "<h3>Book Does Not Exist</h3>";
            // }
            ?>
</form>
</section>


</body>
</html>