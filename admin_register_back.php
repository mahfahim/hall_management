<?php
include 'db_connect.php';

$username = $_POST['admin_username'];
$email = $_POST['admin_email'];
$password = $_POST['admin_password'];
$confirm_password = $_POST['admin_confirm_password'];

if ($password !== $confirm_password) {
    die("❌ Passwords do not match.");
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement
$sql = "INSERT INTO admins (username, email, password) VALUES (?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "✅ Admin registered successfully. <a href='account.php'>Login now</a>";
    } else {
        echo "❌ Error: " . mysqli_stmt_error($stmt);
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    echo "❌ Failed to prepare statement: " . mysqli_error($conn);
}

// Close connection
mysqli_close($conn);
?>
