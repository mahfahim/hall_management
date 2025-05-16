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
                <tr>
                    <td>1</td>
                    <td>Fahim</td>
                    <td>2022-12345</td>
                    <td>CSE</td>
                    <td>4th</td>
                    <td>2021-22</td>
                    <td>203</td>
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
                    <td>205</td>
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
