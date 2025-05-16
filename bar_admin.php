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
  <link rel="stylesheet" href="style6.css" />
</head>
<body>
  <div class="sidebar">
    <h2 class="logo">BIJOY 24 HALL</h2>
    <ul class="nav-links">
      <li><a href="bar_admin.php"><i>🏠</i> Home</a></li>

      <?php if ($_SESSION['role'] === 'student') { ?>
          <li><a href="#"><i>🎓</i> Student Dashboard</a></li>
          <li><a href="bar_ad_payment.php"><i>💳</i> My Payment</a></li>
          <li><a href="bar_ad_room.php"><i>🛏️</i> All Room</a></li>
          <li><a href="room_application.php"><i>🛏️</i> Room Application</a></li>
          <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem Assign</a></li>
      <?php } elseif ($_SESSION['role'] === 'super_admin') { ?>
          <li><a href="bar_admin.php"><i>👨‍💼</i> Admin Dashboard</a></li>
          <li><a href="bar_ad_student.php"><i>👨‍💼</i> All Student</a></li>
          <li><a href="bar_ad_payment.php"><i>💳</i> Payment</a></li>
          <li><a href="bar_ad_room.php"><i>🛏️</i> Room</a></li>
          <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem</a></li>
          <li><a href="bar_ad_notice.php"><i>📢</i> Notice Manage</a></li>
          <li><a href="bar_ad_settings.php"><i>⚙️</i> Settings</a></li>
      <?php } ?>

          <!-- ✅ Add this logout option -->
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
