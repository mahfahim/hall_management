<?php
session_start();

// Redirect if not logged in or unauthorized
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'super_admin')) {
    header("Location: login.php");
    exit();
}

// DB connection
$conn = mysqli_connect("localhost", "root", "", "hall_management");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Validate problem ID from GET
if (!isset($_GET['problem_id'])) {
    die("No problem ID provided.");
}
$problem_id = intval($_GET['problem_id']);

// Fetch problem + student info including admin_reply
$sql = "SELECT problems.id, students.reg_id, students.name, problems.description, problems.admin_reply
        FROM problems
        JOIN students ON problems.student_id = students.id
        WHERE problems.id = ?
        ORDER BY problems.created_at DESC";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $problem_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    die("Problem not found.");
}

$student_id = $row['reg_id'];
$student_name = $row['name'];
$problem_desc = $row['description'];
$problem_reply = $row['admin_reply'] ?? '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reply to Student Problem</title>
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
          <li><a href="bar_std_room_appli.php"><i>🛏️</i> Room Application</a></li>
          <li><a href="bar_std_problem.php"><i>🛠️</i> Problem Assign</a></li>
      <?php } elseif ($_SESSION['role'] === 'super_admin') { ?>
          <li><a href="bar_admin.php"><i>👨‍💼</i> Admin Dashboard</a></li>
          <li><a href="bar_ad_student.php"><i>👨‍💼</i> All Student</a></li>
          <li><a href="bar_ad_payment.php"><i>💳</i> Payment</a></li>
          <li><a href="bar_ad_room.php"><i>🛏️</i> Room</a></li>
          <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem</a></li>
          <li><a href="bar_ad_room_appli.php"><i>🛠️</i>Room Application</a></li>
          <li><a href="bar_ad_notice.php"><i>📢</i> Notice Manage</a></li>
          
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



<div class="main-content">
  <div class="form-container">
    <h2>Reply to Student Problem</h2>
    <form action="bar_ad_problem_form_handle.php" method="POST">
      <input type="hidden" name="problem_id" value="<?= htmlspecialchars($problem_id) ?>">

      <div class="form-group">
        <label for="student-id">Student ID</label>
        <input type="text" id="student-id" value="<?= htmlspecialchars($student_id) ?>" readonly>
      </div>

      <div class="form-group">
        <label for="student-name">Student Name</label>
        <input type="text" id="student-name" value="<?= htmlspecialchars($student_name) ?>" readonly>
      </div>

      <div class="form-group">
        <label for="problem-desc">Problem Description</label>
        <input type="text" id="problem-desc" value="<?= htmlspecialchars($problem_desc) ?>" readonly>
      </div>

      <div class="form-group">
        <label for="reply">Your Reply</label>
        <textarea id="reply" name="reply_message" rows="5" required
          style="width: 100%; padding: 8px; border-radius: 5px; background-color: #374151; color: white; border: none;"><?= htmlspecialchars($problem_reply) ?></textarea>
      </div>

      <div class="form-group full-width">
        <button type="submit" class="submit-btn">Submit Reply</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
