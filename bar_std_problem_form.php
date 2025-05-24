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
    <link rel="stylesheet" href="style4.css">
</head>
<body>

<div class="sidebar">
    <h2 class="logo">BIJOY 24 HALL</h2>
    <ul class="nav-links">
        <?php if ($_SESSION['role'] === 'student') { ?>
            <li><a href="#"><i>🎓</i> Student Dashboard</a></li>
            <li><a href="bar_std_payment.php"><i>💳</i> My Payment</a></li>
            <li><a href="bar_ad_room.php"><i>🛏️</i> All Room</a></li>
            <li><a href="bar_std_room_appli.php"><i>🛏️</i> Room Application</a></li>
            <li><a href="bar_std_problem.php"><i>🛠️</i> Problem Assign</a></li>
        <?php } elseif ($_SESSION['role'] === 'super_admin') { ?>
            <li><a href="bar_admin.php"><i>👨‍💼</i> Admin Dashboard</a></li>
            <li><a href="bar_ad_student.php"><i>👨‍💼</i> All Student</a></li>
            <li><a href="bar_ad_payment.php"><i>💳</i> Payment</a></li>
            <li><a href="bar_ad_room.php"><i>🛏️</i> Room</a></li>
            <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem</a></li>
            <li><a href="bar_ad_room_appli.php"><i>🛠️</i> Room Application</a></li>
            <li><a href="bar_ad_notice.php"><i>📢</i> Notice Manage</a></li>
        <?php } ?>
        <li><a href="logout.php"><i>🚪</i> Logout</a></li>
    </ul>

    <div class="user-profile">
        <span style="font-size: 40px;">👤</span>
        <span>
        <?= htmlspecialchars(
            isset($_SESSION['student_name']) ? $_SESSION['student_name'] : (isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'User')
        ); ?>
        </span>
    </div>
</div>

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
