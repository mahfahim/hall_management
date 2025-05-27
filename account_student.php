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

    <!-- Navbar styles -->
    <link rel="stylesheet" href="z_nav.css">

</head>
<body>
    <!-- navber -->
    <?php include 'z_nav.php'; ?>
    
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
