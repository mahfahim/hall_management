<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: account_student.php");
    exit();
}

// Get student ID from session
$student_id = $_SESSION['student_id']; // must be set at login

// Edit mode logic
$editMode = false;
$editPayment = [];

if (isset($_GET['edit'])) {
    $editMode = true;
    $editId = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM payments WHERE id = '$editId' AND student_id = '$student_id'");
    $editPayment = mysqli_fetch_assoc($result);
}

// Save or Update logic
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment-method'];
    $transaction_id = $_POST['transaction-id'];
    $edit_id = $_POST['edit-id'] ?? null;

    if ($edit_id) {
        $sql = "UPDATE payments SET 
                amount = '$amount',
                payment_method = '$payment_method',
                transaction_id = '$transaction_id'
                WHERE id = '$edit_id' AND student_id = '$student_id'";
    } else {
        $sql = "INSERT INTO payments (student_id, amount, payment_method, transaction_id)
                VALUES ('$student_id', '$amount', '$payment_method', '$transaction_id')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: bar_std_payment.php");
        exit();
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Payment Form</title>
  <link rel="stylesheet" href="style4.css">
</head>
<body>

<div class="sidebar">
    <h2 class="logo">BIJOY 24 HALL</h2>
    <ul class="nav-links">
      <?php if ($_SESSION['role'] === 'student') { ?>
          <li><a href="bar_student.php"><i>🎓</i> Student Dashboard</a></li>
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
    <div class="form-section">
      <h2>Payment Form</h2>
      <form action="" method="post">
        
        <label for="amount">Amount</label>
        <input type="number" id="amount" name="amount" required
          value="<?= $editMode ? htmlspecialchars($editPayment['amount']) : '' ?>">

        <label for="payment-method">Payment Method</label>
        <select name="payment-method" id="payment-method" required>
          <option value="Bkash" <?= $editMode && $editPayment['payment_method'] === 'Bkash' ? 'selected' : '' ?>>Bkash</option>
          <option value="Nagad" <?= $editMode && $editPayment['payment_method'] === 'Nagad' ? 'selected' : '' ?>>Nagad</option>
          <option value="Rocket" <?= $editMode && $editPayment['payment_method'] === 'Rocket' ? 'selected' : '' ?>>Rocket</option>
        </select>

        <label for="transaction-id">Transaction ID</label>
        <input type="text" id="transaction-id" name="transaction-id" required
          value="<?= $editMode ? htmlspecialchars($editPayment['transaction_id']) : '' ?>">

        <?php if ($editMode): ?>
          <input type="hidden" name="edit-id" value="<?= htmlspecialchars($editPayment['id']) ?>">
        <?php endif; ?>

        <button type="submit">
          <?= $editMode ? 'Update Payment' : 'Submit Payment' ?>
        </button>
      </form>
    </div>
</div>

</body>
</html>
