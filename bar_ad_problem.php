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
  <title>Student Problems - Admin Dashboard</title>
  <link rel="stylesheet" href="style3.css" />
</head>
<body>
  <div class="sidebar">
    <h2 class="logo">BIJOY 24 HALL</h2>
    <ul class="nav-links">
      <li><a href="bar_admin.php"><i>🏠</i> Home</a></li>
      <li><a href="#"><i>🎓</i> Student</a></li>
      <li><a href="bar_ad_payment.php"><i>💳</i> Payment</a></li>
      <li><a href="bar_ad_room.php"><i>🛏️</i> Room</a></li>
      <li class="active"><a href="bar_ad_problem.php"><i>🛠️</i> Problem</a></li>
      <li><a href="bar_ad_settings.php"><i>⚙️</i> Settings</a></li>
    </ul>

    <div class="user-profile">
      <span style="font-size: 40px;">👤</span>
      <span>Alex Morgan</span>
    </div>
  </div>

  <div class="main-content">
    <div class="table-section">
      <h2 style="text-align:center; margin-bottom: 20px;">Student Problem Section</h2>

      <table class="student-table">
        <thead>
          <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Problem</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>2023101</td>
            <td>Fahim Rahman</td>
            <td>Internet is not working in my hall room.</td>
            <td><button class="edit-btn">Reply</button></td>
          </tr>
          <tr>
            <td>2023102</td>
            <td>Saif Hossain</td>
            <td>Water supply is unavailable on the 3rd floor.</td>
            <td><button class="edit-btn">Reply</button></td>
          </tr>
          <tr>
            <td>2023103</td>
            <td>Tanvir Ahmed</td>
            <td>My room door lock is broken.</td>
            <td><button class="edit-btn">Reply</button></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
