<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Room Application</title>
  <link rel="stylesheet" href="style4.css" />
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">🏫 Hall Panel</div>
    <ul class="nav-links">
      <li><a href="dashboard.php">Dashboard</a></li>
      <li><a href="students.php">Students</a></li>
      <li><a href="rooms.php">Rooms</a></li>
      <li class="active"><a href="room_application.php">Room Application</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <div class="user-profile">
      <span>👤 Admin</span>
    </div>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="form-container">
      <h2>Room Application Form</h2>
      <form action="submit_room_application.php" method="POST">

        <div class="form-group">
          <label for="preferred_block">Preferred Block</label>
          <input type="text" id="preferred_block" name="preferred_block" required />
        </div>

        <div class="form-group">
          <label for="preferred_room_type">Preferred Room Type</label>
          <select id="preferred_room_type" name="preferred_room_type" class="form-group input" required>
            <option value="">-- Select --</option>
            <option value="single">Single</option>
            <option value="double">Double</option>
            <option value="triple">Triple</option>
            <option value="dormitory">Dormitory</option>
          </select>
        </div>

        <div class="form-group">
          <label for="reason">Reason for Application</label>
          <textarea id="reason" name="reason" rows="4" class="form-group input" style="width: 100%; padding: 10px; border-radius: 4px; background-color: #374151; color: white; border: none;" required></textarea>
        </div>

        <div class="full-width">
          <button type="submit" class="submit-btn">Submit Application</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
