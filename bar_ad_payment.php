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
  <title>Student Table</title>
  <link rel="stylesheet" href="style3.css">
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
          <li><a href="notice_manage.php"><i>📢</i> Notice Manage</a></li>
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


  <!-- Main Content -->
  <div class="main-content">
    <div class="table-section">
      <p  class="add-button">Hall Fee</p>
        <table class="student-table">
            <thead>
                <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Reg ID</th>
                <th>Faculty</th>
                <th>Semester</th>
                <th>Session</th>
                <th>Hall Fee</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Fahim</td>
                    <td>2022-12345</td>
                    <td>CSE</td>
                    <td>4th</td>
                    <td>2021-22</td>
                    <td>2000</td>
                    <td>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Saif</td>
                    <td>2022-67890</td>
                    <td>CSE</td>
                    <td>4th</td>
                    <td>2021-22</td>
                    <td>2000</td>
                    <td>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                    </td>
                </tr>
            </tbody>

        </table>
    </div>
  </div>

</body>
</html>
