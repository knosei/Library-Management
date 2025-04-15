<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<section class="user-management">
<form action="process.php" method="post" class="edit-form">
            <?php 
            if (isset($_GET['id'])) {
                include("config.php");
                $id = $_GET['id'];
                $sql = "SELECT * FROM users WHERE userid=$id";
                $result = mysqli_query($conn,$sql);
                $row = mysqli_fetch_array($result);
                ?>
                <div class="aform-group">
                    <label for="new_username">Username</label>
                    <input type="text" id="new_username" name="uname" value="<?php echo $row["name"]; ?>" required >
                </div>
                <div class="aform-group">
                    <label for="new_email">Email</label>
                    <input type="email" id="new_email" name="email" value="<?php echo $row["email"]; ?>" required>
                </div>
                <div class="aform-group">
                    <label for="new_password">Password</label>
                    <input type="password" id="new_password" name="password" value="<?php echo $row["password"]; ?>" required minlength="4" title="Password must be at least 4 characters long">
                </div>
                <div class="aform-group">
                    <label for="new_role">Role</label>
                    <select id="new_role" name="role" required>
                        <option value="">Select a role</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
        <input type="hidden" value="<?php echo $id; ?>" name="id">
        <button type="submit" name ="edituser" class="btn">Update</button>
    <!-- <button type="button" class="btn cancel-btn" onclick="toggleEditForm('edit-form-{{ book.id }}')">Cancel</button> -->
    <?php
            }
            ?>
</form>
        </section>


</body>
</html>