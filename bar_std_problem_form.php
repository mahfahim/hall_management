<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session
session_start();

// Include DB connection
include 'db_connect.php';

// Check if user is logged in and is a student
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

// Get logged-in student ID
$student_id = $_SESSION['student_id'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = $_POST['category'];

    $sql = "INSERT INTO problems (student_id, title, description, category)
            VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "isss", $student_id, $title, $description, $category);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>alert('Problem submitted successfully!');</script>";
            header("Location: bar_std_problem.php");
            exit();
        } else {
            echo "<script>alert('Error: Could not submit.');</script>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Error: Failed to prepare the SQL statement.');</script>";
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Report a Problem</title>
          <!-- reset  -->
  <link rel="stylesheet" href="z_reset.css">
    
    <link rel="stylesheet" href="style4.css">

  <!-- sidebar style -->
  <link rel="stylesheet" href="z_side.css" />

</head>
<body>

  <!-- sidebar -->
   <?php include 'z_side.php'; ?>

<div class="main-content">
    <div class="form-container">
        <h2>Report a Problem</h2>
        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Problem Title</label>
                <input type="text" name="title" id="title" required>
            </div>

            <div class="form-group">
                <label for="description">Problem Description</label>
                <textarea name="description" id="description" rows="5" required></textarea>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="electrical">Electrical</option>
                    <option value="plumbing">Plumbing</option>
                    <option value="furniture">Furniture</option>
                    <option value="cleaning">Cleaning</option>
                    <option value="other" selected>Other</option>
                </select>
            </div>

            <div class="full-width">
                <button type="submit" class="submit-btn">Submit</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
