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
      <li ><a href="bar_ad_student.php"><i>🎓</i> Student</a></li>
      <li class="active"><a href="#"><i>💳</i> Payment</a></li>
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
