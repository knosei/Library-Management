<?php

session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';

session_unset();

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS</title>
    <link rel="stylesheet" href="css/sstyles.css?v=<?= time(); ?>">
</head>
<body>
    <div class="container">
        <div class="form-group <?= isActiveForm('login', $activeForm); ?>" id="login">   
        <form action="login_register.php" method="post">
            <h1 class="form-title">Login</h1>
                <?= showError($errors['login']); ?>
                <label for="username">Email</label>
                <input type="email" name="email" required >
                <label for="password">Password</label>
                <input type="password" name="password" required >
            <button type="submit" class="btn" name="login">Login</button>
            <div class="form-footer">
                <p>Don't have an account? <a href="#" onclick="showForm('register')">Register</a></p>
            </div>
        </form>
        </div> 
       

        <div class="form-group <?= isActiveForm('register', $activeForm); ?>" id="register">
        <form action="login_register.php" method="post">
        <h1 class="form-title">Register</h1>
                <?= showError($errors['register']); ?>
                <label for="username">Name</label>
                <input type="text" name="name" required >
                <label for="username">Email</label>
                <input type="email" name="email" required >
                <label for="password">Password</label>
                <input type="password" name="password" required >
                <label for="role">Role</label>
                <select id="role" name="role" required>
                    <option value="">Select a role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            <button type="submit" class="btn" name="register">Register</button>
            <div class="form-footer">
                <p>Already have an account? <a href="#" onclick="showForm('login')">Login</a></p>
            </div>
        </form>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html>

