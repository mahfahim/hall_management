<?php
if (isset($_SESSION['login_error'])) {
    echo "<p style='color:red;'>".$_SESSION['login_error']."</p>";
    unset($_SESSION['login_error']); // Remove after showing
}
?>


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
            <h2>🔑 Admin Login</h2>
            <form action="account_admin_back.php" method="post">
                <input type="text" name="admin_username" placeholder="Username" required>
                <input type="password" name="admin_password" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            
        </div>
    </div>
</body>
</html>
