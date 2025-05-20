<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: account_student.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Student</title>
  <link rel="stylesheet" href="style3.css">

</head>
<body>

   <div class="sidebar">
    <h2 class="logo">BIJOY 24 HALL</h2>
    <ul class="nav-links">
      

      <?php if ($_SESSION['role'] === 'student') { ?>
          <li><a href="#"><i>🎓</i> Student Dashboard</a></li>
          <li><a href="bar_std_payment.php"><i>💳</i> My Payment</a></li>
          <li><a href="bar_ad_room.php"><i>🛏️</i> All Room</a></li>
          <li><a href="bar_std_room_appli_form.php"><i>🛏️</i> Room Application</a></li>
          <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem Assign</a></li>
      <?php } elseif ($_SESSION['role'] === 'super_admin') { ?>
          <li><a href="bar_admin.php"><i>👨‍💼</i> Admin Dashboard</a></li>
          <li><a href="bar_ad_student.php"><i>👨‍💼</i> All Student</a></li>
          <li><a href="bar_ad_payment.php"><i>💳</i> Payment</a></li>
          <li><a href="bar_ad_room.php"><i>🛏️</i> Room</a></li>
          <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem</a></li>
          <li><a href="bar_std_room_appli.php"><i>🛠️</i>Room Application</a></li>
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


  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="table-section">
      <a href="bar_ad_student_form.php" class="add-button">Add Student</a>
      <table class="student-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Reg ID</th>
            <th>Faculty</th>
            <th>Semester</th>
            <th>Session</th>
            <th>Room No</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT students.*, rooms.room_number FROM students LEFT JOIN rooms ON students.room_id = rooms.id";
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>{$row['id']}</td>";
                  echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['reg_id']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['faculty']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['session']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['room_number'] ?? 'N/A') . "</td>";
                  echo "<td>
                          <a href='bar_ad_student_form.php?edit={$row['id']}' class='edit-btn'>Edit</a>
                          <a href='bar_ad_student_form.php?delete={$row['id']}' class='delete-btn' onclick=\"return confirm('Are you sure?')\">Delete</a>
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='8'>No students found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
