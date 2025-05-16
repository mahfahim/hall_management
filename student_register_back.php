<?php
require 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get and sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $reg_id = mysqli_real_escape_string($conn, $_POST['reg_id']);
    $faculty = mysqli_real_escape_string($conn, $_POST['faculty']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $session = mysqli_real_escape_string($conn, $_POST['session']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $username = mysqli_real_escape_string($conn, $_POST['student_username']);
    $email = mysqli_real_escape_string($conn, $_POST['student_email']);
    $password = $_POST['student_password'];
    $confirm_password = $_POST['student_confirm_password'];

    // Password match check
    if ($password !== $confirm_password) {
        die("❌ Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // SQL insert
    $sql = "INSERT INTO students (name, reg_id, faculty, semester, session, email, phone, username, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssss", $name, $reg_id, $faculty, $semester, $session, $email, $phone, $username, $hashed_password);

    if (mysqli_stmt_execute($stmt)) {
        // ✅ Redirect to login page
        header("Location: account_student.php?success=1");
        exit();
    } else {
        echo "❌ Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
