<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Registration</title>
    <link rel="stylesheet" href="style2.css">
</head>
<body>

<header class="navbar">
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
        <h2>🔑 Student Registration</h2>
        <form action="student_register_back.php" method="post">
            <label for="name">Full Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="reg_id">Registration ID:</label>
            <input type="text" id="reg_id" name="reg_id" required>

            <label for="faculty">Faculty:</label>
            <input type="text" id="faculty" name="faculty" required>

            <label for="semester">Semester:</label>
            <input type="text" id="semester" name="semester" required>

            <label for="session">Session:</label>
            <input type="text" id="session" name="session" required>

            <label for="phone">Phone:</label>
            <input type="text" id="phone" name="phone">

            <label for="username">Username:</label>
            <input type="text" id="username" name="student_username" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="student_email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="student_password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="student_confirm_password" required>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="account_student.php">Login here</a></p>
    </div>
</div>
</body>
</html>
