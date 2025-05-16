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

  <!-- Main Content -->
  <div class="main-content">
    <div class="table-section">
      <a href="bar_ad_room_form.php" class="add-button">Add room</a>
        <table class="student-table">
            <thead>
                <tr>
                <th>Room Number</th>
                <th>Block Name</th>
                <th>Seat Quantity</th>
                <th>Availability</th>
                <th>Action</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                    <td>101</td>
                    <td>Block A</td>
                    <td>3</td>
                    <td >1</td>
                    <td>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                    </td>
                </tr>
                <tr>
                    <td>102</td>
                    <td>Block A</td>
                    <td>4</td>
                    <td >0</td>
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
