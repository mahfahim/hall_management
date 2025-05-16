<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Table</title>
  <link rel="stylesheet" href="style3.css">
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h2 class="logo">BIJOY 24 HALL</h2>
    <ul class="nav-links">
      <li><a href="bar_admin.php"><i>🏠</i> Home</a></li>
      <li class="active"><a href="#"><i>🎓</i> Student</a></li>
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

  <!-- Main Content -->
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
                $sql = "SELECT students.*, rooms.room_number 
                        FROM students 
                        LEFT JOIN rooms ON students.room_id = rooms.id";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['reg_id']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['faculty']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['session']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['room_number'] ?? 'N/A') . "</td>";
                    echo "<td>
                            <button class='edit-btn'>Edit</button>
                            <button class='delete-btn'>Delete</button>
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
