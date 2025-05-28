<?php
require_once 'db_connect.php'; 
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php"); 
    exit();
}

$student_id = $_SESSION['student_id']; 

// 1. Room Number
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
$room_number = 'No room assigned';
if ($row = $result->fetch_assoc()) {
    $room_number = $row['room_number'] ?? 'No room assigned';
}
$stmt->close();

// 2. Total Payments Count and Sum (all statuses)
$payments_query = "
    SELECT COUNT(*) AS payment_count, COALESCE(SUM(amount), 0) AS total_paid 
    FROM payments 
    WHERE student_id = ?
";
$stmt = $conn->prepare($payments_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$payment_count = 0;
$total_paid = 0.00;
if ($row = $result->fetch_assoc()) {
    $payment_count = $row['payment_count'];
    $total_paid = $row['total_paid'];
}
$stmt->close();

// 3. Unreplied Problems Count
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

// 4. Total Room Applications Count
$applications_query = "
    SELECT COUNT(*) AS application_count 
    FROM room_applications 
    WHERE student_id = ?
";
$stmt = $conn->prepare($applications_query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$application_count = 0;
if ($row = $result->fetch_assoc()) {
    $application_count = $row['application_count'];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Student Dashboard</title>
  <!-- reset  -->
  <link rel="stylesheet" href="z_reset.css">
  <link rel="stylesheet" href="bar_admin.css" />
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
        <p><?= $unreplied_problems ?> unresolved issues</p>
      </div>

      <div class="card paid">
        <h3>💳 Your Payments</h3>
        <p><?= $payment_count ?> payments made</p>
        <p>Total Paid: ৳<?= number_format($total_paid, 2); ?></p>
      </div>

      <div class="card applications">
        <h3>📝 Room Applications</h3>
        <p><?= $application_count ?> total applications</p>
      </div>
    </div>
  </div>

</body>
</html>
