<?php
session_start();

// Database connection
$conn = mysqli_connect("localhost", "root", "", "hall_management");

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if username and password were sent
if (isset($_POST['student_username']) && isset($_POST['student_password'])) {
    $username = mysqli_real_escape_string($conn, $_POST['student_username']);
    $password = mysqli_real_escape_string($conn, $_POST['student_password']);

    // Query student info
    $sql = "SELECT * FROM students WHERE username = '$username' AND status = 'active'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Check password using password_verify
        if (password_verify($password, $row['password'])) {
            $_SESSION['student_id'] = $row['id'];
            $_SESSION['student_username'] = $row['username'];
            $_SESSION['student_name'] = $row['name'];
            $_SESSION['role'] = 'student';

            header("Location: bar_admin.php");
            exit();
        } else {
            $_SESSION['login_error'] = "Incorrect password.";
        }
    } else {
        $_SESSION['login_error'] = "Username not found or account inactive.";
    }

    header("Location: account_student.php"); // Redirect back with error
    exit();
} else {
    $_SESSION['login_error'] = "Please fill in all fields.";
    header("Location: account_student.php");
    exit();
}

mysqli_close($conn);
?>
