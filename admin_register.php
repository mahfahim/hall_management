<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
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
    <div class="register-wrapper">
        <div class="register-container">
            <h2>🔑 Admin Registration</h2>
            <form action="handle_admin_register.php" method="post">
                <label for="username">Username:</label>
                <input type="text" id="username" name="admin_username" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="admin_email" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="admin_password" required>

                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="admin_confirm_password" required>

                <button type="submit">Register</button>
            </form>

            <p>Already have an account? <a href="account_admin.php">Login here</a></p>
        </div>
    </div>
</body>
</html>
