<?php
session_start();
if(!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<?php
        if (isset($_SESSION["create"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["create"];
            ?>
        </div>
        <?php
        unset($_SESSION["create"]);
        }
        ?>
<?php
        if (isset($_SESSION["update"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["update"];
            ?>
        </div>
        <?php
        unset($_SESSION["update"]);
        }
        ?>
        <?php
        if (isset($_SESSION["delete"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["delete"];
            ?>
        </div>
        <?php
        unset($_SESSION["delete"]);
        }
        ?>

<?php
        if (isset($_SESSION["createuser"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["createuser"];
            ?>
        </div>
        <?php
        unset($_SESSION["createuser"]);
        }
        ?>
<?php
        if (isset($_SESSION["updateuser"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["updateuser"];
            ?>
        </div>
        <?php
        unset($_SESSION["updateuser"]);
        }
        ?>
        <?php
        if (isset($_SESSION["deleteuser"])) {
        ?>
        <div class="alert alert-success">
            <?php 
            echo $_SESSION["deleteuser"];
            ?>
        </div>
        <?php
        unset($_SESSION["deleteuser"]);
        }
        ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Library Management System</title>
    <link rel="stylesheet" href="css/sstyles.css?v=<?= time(); ?>">
</head>
<body>
    <div class="containerd">
        <div class="dashheader">
         <h1>Admin Dashboard</h1>
        <h1>Welcome, <span><?= $_SESSION['name']; ?></span></h1>   
        </div>

        <section class="book-management">
            <h2>Book Management</h2>
            <div class="booksflex">
            <form action="process.php" method="post" class="add-form">
                <h3>Add New Book</h3>
                <div class="aform-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" required>
                </div>
                <div class="aform-group">
                    <label for="author">Author</label>
                    <input type="text" id="author" name="author" required>
                </div>
                <div class="aform-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" required pattern="[0-9]{4}" title="Please enter a valid 4-digit ISBN">
                </div>
                <div class="aform-group">
                    <label for="genre">Genre</label>
                    <input type="text" id="genre" name="genre" required>
                </div>
                <div class="aform-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" required min="1" value="1">
                </div>
                <button type="submit" class="btn" name="create">Add Book</button>
            </form>

            <div class="book-list">
                <h3>Book List</h3>
                            <div class="book-details">
                            <?php
                            include('config.php');
                            $sqlSelect = "SELECT * FROM books";
                            $result = mysqli_query($conn,$sqlSelect);
                            while($data = mysqli_fetch_array($result)){
                            ?>    
                                <div class="book-item">
                                <h4><?php echo $data['title']; ?></h4>
                                <p>Author: <?php echo $data['author']; ?></p>
                                <p>ISBN: <?php echo $data['isbn']; ?></p>
                                <p>Genre: <?php echo $data['genre']; ?></p>
                                <p>Available: <?php echo $data['quantity']; ?>/<?php echo $data['quantity']; ?></p>
                                <!-- <button class="btn edit-btn" onclick="toggleEditForm('formId')" id= href="edit.php? >Edit Book</button> -->
                                <a class="btn edit-btn" href="editbook.php? id=<?php echo $data['bookid']; ?>" >Edit Book</a>
                                <form action="{{ url_for('delete_book', book_id=book.id) }}" method="POST" class="delete-form">
                                    <a class="btn delete-btn" href="deletebook.php?id=<?php echo $data['bookid']; ?>">Delete Book</a>
                                </form>
                            </div>     
                            <?php    
                            }?> 
                            <!-- <p>No books available.</p> -->
                        </div>
            </div>
            </div>
        </section>

        <section class="user-management">
            <h2>User Management</h2>
            <div class="booksflex">
            <form action="process.php" method="post" class="add-form">
                <h3>Add New User</h3>
                <div class="aform-group">
                    <label for="new_username">Username</label>
                    <input type="text" id="new_username" name="uname" required >
                </div>
                <div class="aform-group">
                    <label for="new_email">Email</label>
                    <input type="email" id="new_email" name="email" required>
                </div>
                <div class="aform-group">
                    <label for="new_password">Password</label>
                    <input type="password" id="new_password" name="password" required minlength="4" title="Password must be at least 4 characters long">
                </div>
                <div class="aform-group">
                    <label for="new_role">Role</label>
                    <select id="new_role" name="role" required>
                        <option value="">Select a role</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit" class="btn" name="createuser" >Add User</button>
            </form>

            <div class="user-list">
                <h3>User List</h3>
                        <div class="book-details">
                        <?php
                            include('config.php');
                            $sqlSelect = "SELECT * FROM users";
                            $result = mysqli_query($conn,$sqlSelect);
                            while($data = mysqli_fetch_array($result)){
                                // $formId = "editbook" . $data['id'];
                            ?> 
                            <div class="book-item">
                            <h4><?php echo $data['name']; ?></h4>
                            <p>Email: <?php echo $data['email']; ?></p>
                            <p>Role: <?php echo $data['role']; ?></p>
                            <a class="btn edit-btn" href="edituser.php? id=<?php echo $data['userid']; ?>" >Edit User</a>
                            <form action="" method="POST" class="delete-form">
                            <a class="btn delete-btn" href="deleteuser.php?id=<?php echo $data['userid']; ?>">Delete User</a>
                            </form>
                            </div>
                            <?php    
                            }?> 
                        </div>

            </div>
            </div>
        </section>
        <a onclick="window.location.href='logout.php'" class="btn logout-btn">Logout</a>
    </div>

    <script>
        function toggleEditForm(formId) {
            const form = document.getElementById(formId);
            if (!form) return; 
            if (form.style.display === '' || form.style.display === 'none') {
                form.style.display = 'block';
            } else {
                form.style.display = 'none';
            }
        }
    </script>
</body>
</html>