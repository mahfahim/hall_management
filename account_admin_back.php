<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "hall_management");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if form data is sent
if (isset($_POST['admin_username']) && isset($_POST['admin_password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['admin_username']);
    $password = mysqli_real_escape_string($conn, $_POST['admin_password']);

    // Query admin by username
    $sql = "SELECT * FROM admins WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $admin = mysqli_fetch_assoc($result);

        if ($password === $admin['password']) {
            // Set session variables
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['role'] = $admin['role']; // Use role from DB

            // Redirect to shared dashboard
            header("Location: bar_admin.php");
            exit();
        } else {
            $_SESSION['login_error'] = "❌ Incorrect password.";
        }
    } else {
        $_SESSION['login_error'] = "❌ Username not found.";
    }

    header("Location: account_admin.php");
    exit();
} else {
    $_SESSION['login_error'] = "Please fill in all fields.";
    header("Location: account_admin.php");
    exit();
}

mysqli_close($conn);
?>
