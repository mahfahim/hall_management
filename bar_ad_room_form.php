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

  <!-- Sidebar -->
  <div class="sidebar">
        <h2 class="logo">BIJOY 24 HALL</h2>
        <ul class="nav-links">
        <li><a href="bar_admin.php"><i>🏠</i> Home</a></li>
        <li ><a href="bar_ad_student.php"><i>🎓</i> Student</a></li>
        <li><a href="bar_ad_payment.php"><i>💳</i> Payment</a></li>
        <li class="active"><a href="#"><i>🛏️</i> Room</a></li>
        <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem</a></li>
        <li><a href="bar_ad_settings.php"><i>⚙️</i> Settings</a></li>
        </ul>
        <div class="user-profile">
        <span style="font-size: 40px;">👤</span>
        <span>Alex Morgan</span>
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
