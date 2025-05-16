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
  <title>Student Form</title>
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
    <!-- Your main content goes here -->

    <div class="form-container">
    <h2>Student Form</h2>
    <form action="#" method="post">
      <div class="form-group">
        <label for="room-number">Room Number</label>
        <input type="number" id="room-number" name="room-number" required>
      </div>

      <div class="form-group">
        <label for="block-name">Block Name</label>
        <input type="text" id="block-name" name="block-name" required>
      </div>

      <div class="form-group">
        <label for="room-number">Seat Quantity</label>
        <input type="number" id="room-number" name="room-number" required>
      </div>

      <div class="form-group">
        <label for="room-number">Availability</label>
        <input type="number" id="room-number" name="room-number" required>
      </div>

      

      <div class="form-group full-width">
        <button type="submit" class="submit-btn">Save Room</button>
      </div>
    </form>
  </div>

  </div>




</body>
</html>
