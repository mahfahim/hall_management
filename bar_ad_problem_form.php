<?php
session_start();


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

  <!-- sidebar style -->
  <link rel="stylesheet" href="z_side.css" />

</head>
<body>

  <!-- sidebar -->
   <?php include 'z_side.php'; ?>



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
          style="width: 100%; padding: 8px; border-radius: 5px; background-color: #F9FAFB; color: black; border:1px solid #cbd5e1;"><?= htmlspecialchars($problem_reply) ?></textarea>
      </div>

      <div class="form-group full-width">
        <button type="submit" class="submit-btn">Submit Reply</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
