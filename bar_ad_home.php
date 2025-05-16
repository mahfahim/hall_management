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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NexusFlow Sidebar</title>
  <link rel="stylesheet" href="style5.css" />
</head>
<body>
  <div class="sidebar">
    <h2 class="logo">BIJOY 24 HALL</h2>
    <ul class="nav-links">
      <li class="active"><a href="#"><i>🏠</i> Home</a></li>
      <li><a href="bar_ad_student.php"><i>🎓</i> Student</a></li>
      <li><a href="bar_ad_payment.php"><i>💳</i> Payment</a></li>
      <li><a href="bar_ad_room.php"><i>🛏️</i> Room</a></li>
      <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem</a></li>
      <li><a href="bar_ad_settings.php"><i>⚙️</i> Settings</a></li>
    </ul>

    <div class="user-profile">
      <span style="font-size: 40px;">👤</span>
      <span>Alex Morgan</span>
    </div>
  </div>

  <div class="main-content">
    <div class="dashboard">
      <div class="card">
        <h3>Total Students</h3>
        <p>7</p>
      </div>
      <div class="card">
        <h3>Total Rooms</h3>
        <p>8</p>
      </div>
    </div>
  </div>
</body>
</html>
