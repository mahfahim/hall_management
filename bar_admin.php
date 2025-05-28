<?php
require_once 'db_connect.php'; // Your DB connection
session_start();

// Prevent access if not logged in
if (!isset($_SESSION['role'])) {
    header("Location: .php"); // Redirect to login page
    exit();
}

// Total students
$students_result = mysqli_query($conn, "SELECT COUNT(*) AS total_students FROM students");
$students_count = mysqli_fetch_assoc($students_result)['total_students'];

// Total rooms
$rooms_result = mysqli_query($conn, "SELECT COUNT(*) AS total_rooms FROM rooms");
$rooms_count = mysqli_fetch_assoc($rooms_result)['total_rooms'];

// Unreplied problems
$problems_result = mysqli_query($conn, "SELECT COUNT(*) AS unreplied_problems FROM problems WHERE admin_reply IS NULL OR status != 'resolved'");
$unreplied_problems = mysqli_fetch_assoc($problems_result)['unreplied_problems'];

// Students who completed payment
$payments_result = mysqli_query($conn, "SELECT COUNT(DISTINCT student_id) AS paid_students FROM payments WHERE status = 'completed'");
$paid_students = mysqli_fetch_assoc($payments_result)['paid_students'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sidebar</title>
        <!-- reset  -->
  <link rel="stylesheet" href="z_reset.css">
    
  <link rel="stylesheet" href="bar_admin.css" />

    <!-- sidebar style -->
  <link rel="stylesheet" href="z_side.css" />

   <!-- pagination styles -->
    <link rel="stylesheet" href="z_page.css">

</head>
<body>

  <!-- sidebar -->
   <?php include 'z_side.php'; ?>

  

<div class="main-content">
  <!-- Headline -->
  <h1 class="dashboard-title">Admin Dashboard</h1>

  <!-- Dashboard summary cards -->
  <div class="dashboard-summary">
    <div class="card students">
      <h3>👨‍🎓 Students</h3>
      <p><?= $students_count ?> students</p>
    </div>
    <div class="card rooms">
      <h3>🛏️ Rooms</h3>
      <p><?= $rooms_count ?> rooms</p>
    </div>
    <div class="card unreplied">
      <h3>🛠️ Unreplied Problems</h3>
      <p><?= $unreplied_problems ?> issues</p>
    </div>
    <div class="card paid">
      <h3>💳 Paid Students</h3>
      <p><?= $paid_students ?> students</p>
    </div>
  </div>
</div>

</body>
</html>
