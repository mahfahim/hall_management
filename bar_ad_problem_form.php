<?php
session_start();

// Prevent access if not logged in
if (!isset($_SESSION['role'])) {
    header("Location: .php"); // Redirect to login page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Reply to Student Problem</title>
  <link rel="stylesheet" href="style4.css">
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
          <li><a href="#"><i>👨‍💼</i> Admin Dashboard</a></li>
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
  <div class="form-container">
    <h2>Reply to Student Problem</h2>
    <form action="submit_reply.php" method="POST">
      
      <div class="form-group">
        <label for="student-id">Student ID</label>
        <input type="text" id="student-id" name="student_id" required>
      </div>

      <div class="form-group">
        <label for="student-name">Student Name</label>
        <input type="text" id="student-name" name="student_name" required>
      </div>

      <div class="form-group">
        <label for="problem-desc">Problem Description</label>
        <input type="text" id="problem-desc" name="problem_desc" readonly value="Student's reported issue will appear here">
      </div>

      <div class="form-group">
        <label for="reply">Your Reply</label>
        <textarea id="reply" name="reply_message" rows="5" required style="width: 100%; padding: 8px; border-radius: 5px; background-color: #374151; color: white; border: none;"></textarea>
      </div>

      <div class="form-group full-width">
        <button type="submit" class="submit-btn">Submit Reply</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
