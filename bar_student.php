<?php
require_once 'db_connect.php'; 
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php"); // Redirect to login if not student
    exit();
}

$student_id = $_SESSION['student_id']; // Assume student_id is stored in session on login

// Get the room number for the logged-in student
$room_query = "
    SELECT rooms.room_number 
    FROM students 
    LEFT JOIN rooms ON students.room_id = rooms.id
    WHERE students.id = ?
";
$stmt = $conn->prepare($room_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$room_number = null;
if ($row = $result->fetch_assoc()) {
    $room_number = $row['room_number'] ?? 'No room assigned';
}
$stmt->close();

// Get count of payments made by this student with status 'completed'
$payments_query = "SELECT COUNT(*) AS payment_count FROM payments WHERE student_id = ? AND status = 'completed'";
$stmt = $conn->prepare($payments_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$payment_count = 0;
if ($row = $result->fetch_assoc()) {
    $payment_count = $row['payment_count'];
}
$stmt->close();

// Get count of student's problems that are not resolved or have no admin reply
$problems_query = "
    SELECT COUNT(*) AS unreplied_problems 
    FROM problems 
    WHERE student_id = ? AND (admin_reply IS NULL OR status != 'resolved')
";
$stmt = $conn->prepare($problems_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$unreplied_problems = 0;
if ($row = $result->fetch_assoc()) {
    $unreplied_problems = $row['unreplied_problems'];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Dashboard</title>
  <link rel="stylesheet" href="style6.css" />

  <!-- sidebar style -->
  <link rel="stylesheet" href="z_side.css" />

</head>
<body>

  <!-- sidebar -->
   <?php include 'z_side.php'; ?>



<div class="main-content">
  <h1 class="dashboard-title">Student Dashboard</h1>
  <div class="dashboard-summary">
    <div class="card rooms">
      <h3>🛏️ Your Room Number</h3>
      <p><?= htmlspecialchars($room_number); ?></p>
    </div>
    <div class="card unreplied">
      <h3>🛠️ Your Problems</h3>
      <p><?= $unreplied_problems ?> issues</p>
    </div>
    <div class="card paid">
      <h3>💳 Your Payments</h3>
      <p><?= $payment_count ?> completed payments</p>
    </div>
  </div>
</div>

</body>
</html>
