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

  <div class="main-content">
    <!-- Your main content goes here -->

    <div class="form-container">
    <h2>Student Form</h2>
    <form action="#" method="post">
      <div class="form-group">
        <label for="student-id">ID</label>
        <input type="number" id="student-id" name="student-id" required>
      </div>

      <div class="form-group">
        <label for="student-name">Name</label>
        <input type="text" id="student-name" name="student-name" required>
      </div>

      <div class="form-group">
        <label for="reg-id">Reg ID</label>
        <input type="text" id="reg-id" name="reg-id" required>
      </div>

      <div class="form-group">
        <label for="faculty">Faculty</label>
        <input type="text" id="faculty" name="faculty" required>
      </div>

      <div class="form-group">
        <label for="semester">Semester</label>
        <input type="text" id="semester" name="semester" required>
      </div>

      <div class="form-group">
        <label for="session">Session</label>
        <input type="text" id="session" name="session" required>
      </div>

      <div class="form-group">
        <label for="room-no">Room No</label>
        <input type="text" id="room-no" name="room-no" required>
      </div>

      <div class="form-group full-width">
        <button type="submit" class="submit-btn">Save Student</button>
      </div>
    </form>
  </div>

  </div>




</body>
</html>
