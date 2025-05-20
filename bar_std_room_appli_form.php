<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Room Application</title>
  <link rel="stylesheet" href="style4.css" />
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
