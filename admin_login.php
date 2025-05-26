<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = htmlspecialchars(trim($_POST['admin_username']));
    $password = trim($_POST['admin_password']);

    
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['success'] = "Login successful!";
        header("Location: sidebar.php");
        exit;
    } else {
        $_SESSION['error'] = "❌ Invalid username or password.";
        header("Location: index.php");
        exit;
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: index.php");
    exit;
}
?>
