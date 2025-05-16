<?php
include 'db_connect.php'; 

$student_id = $_POST['student_id'];
$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    die("❌ Passwords do not match.");
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare the SQL statement
$sql = "INSERT INTO students (student_id, name, email, password) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if ($stmt) {
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssss", $student_id, $name, $email, $hashed_password);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "✅ Student registered successfully. <a href='account.php'>Login now</a>";
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
