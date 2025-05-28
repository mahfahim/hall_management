<?php session_start(); ?>
<?php if (isset($_SESSION['login_error'])): ?>
    <div class="login-error">
        <?= $_SESSION['login_error']; ?>
        <?php unset($_SESSION['login_error']); ?>
    </div>
<?php endif; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Login</title>

    <!-- Reset -->
    <link rel="stylesheet" href="z_reset.css">
    <!-- Custom Styles -->
    <link rel="stylesheet" href="account_student.css">
    <!-- Navbar -->
    <link rel="stylesheet" href="z_nav.css">
</head>
<body>

<!-- Navbar -->
<?php include 'z_nav.php'; ?>

<section class="login-container">
    <div class="login-box">
        <h2>🔑 Student Login</h2>
        <form action="account_student_back.php" method="post">
            <input type="text" name="student_username" placeholder="Username" required>
            <input type="password" name="student_password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="student_register.php">Register</a></p>
    </div>
</section>

</body>
</html>
