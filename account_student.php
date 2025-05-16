<?php session_start(); ?>
<?php if (isset($_SESSION['login_error'])): ?>
    <div style="color:red; text-align:center; font-weight:bold;">
        <?= $_SESSION['login_error']; ?>
        <?php unset($_SESSION['login_error']); ?>
    </div>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>
<header class="navbar" >
        <div class="container">
            <div class="logo">BIJOY 24 HALL</div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="#">Home</a></li>
                    <li><a href="administration.php">Administration</a></li>
                    <li><a href="notice.php">Notice</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="log_button.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <hr>
    <div class="login-boxes">
        <div class="login-box">
            <h2>🔑 Student Login</h2>
            <form action="account_student_back.php" method="post">
                <input type="text" name="student_username" placeholder="Username" required>
                <input type="password" name="student_password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <p>Don't have an account? <a href="student_register.php">Register</a></p> 
        </div>
    </div>
</body>
</html>
