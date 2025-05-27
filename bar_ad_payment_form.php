<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role'])) {
    header("Location: account_student.php");
    exit();
}

// Delete
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM payments WHERE id = '$idToDelete'");
    header("Location: bar_ad_payment.php");
    exit();
}

// Edit
$editMode = false;
$editPayment = [];

if (isset($_GET['edit'])) {
    $editMode = true;
    $editId = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM payments WHERE id = '$editId'");
    $editPayment = mysqli_fetch_assoc($result);
}

// Save or Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student-id'];
    $amount = $_POST['amount'];
    $payment_method = $_POST['payment-method'];
    $transaction_id = $_POST['transaction-id'];
    $edit_id = $_POST['edit-id'] ?? null;

    //  Validate kora student_id ache kina
    $checkStudent = mysqli_query($conn, "SELECT id FROM students WHERE id = '$student_id'");
    if (mysqli_num_rows($checkStudent) === 0) {
        echo "<script>alert('Error: Student ID does not exist.');</script>";
    } else {
        if ($edit_id) {
            $sql = "UPDATE payments SET 
                    student_id = '$student_id',
                    amount = '$amount',
                    payment_method = '$payment_method',
                    transaction_id = '$transaction_id'
                    WHERE id = '$edit_id'";
        } else {
            $sql = "INSERT INTO payments (student_id, amount, payment_method, transaction_id)
                    VALUES ('$student_id', '$amount', '$payment_method', '$transaction_id')";
        }

        if (mysqli_query($conn, $sql)) {
            header("Location: bar_ad_payment.php");
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Form</title>
        <!-- reset  -->
  <link rel="stylesheet" href="z_reset.css">
    
  <link rel="stylesheet" href="style4.css">

    <!-- sidebar style -->
  <link rel="stylesheet" href="z_side.css" />

</head>
<body>

  <!-- sidebar -->
   <?php include 'z_side.php'; ?>



  <div class="main-content">
    <div class="form-container">
      <h2>Payment Form</h2>
      <form action="" method="post">

        <div class="form-group">
          <label for="student-id">Student</label>
          <select name="student-id" id="student-id" required>
            <option value="">Select Student</option>
            <?php
              $students = mysqli_query($conn, "SELECT id, name FROM students");
              while ($student = mysqli_fetch_assoc($students)) {
                  $selected = $editMode && $editPayment['student_id'] == $student['id'] ? 'selected' : '';
                  echo "<option value='{$student['id']}' $selected>{$student['id']} - {$student['name']}</option>";
              }
            ?>
          </select>
        </div>

        <div class="form-group">
          <label for="amount">Amount</label>
          <input type="number" id="amount" name="amount" required
            value="<?= $editMode ? htmlspecialchars($editPayment['amount']) : '' ?>">
        </div>

        <div class="form-group">
          <label for="payment-method">Payment Method</label>
          <select name="payment-method" id="payment-method" required>
            <option value="Bkash" <?= $editMode && $editPayment['payment_method'] === 'Bkash' ? 'selected' : '' ?>>Bkash</option>
            <option value="Nagad" <?= $editMode && $editPayment['payment_method'] === 'Nagad' ? 'selected' : '' ?>>Nagad</option>
            <option value="Rocket" <?= $editMode && $editPayment['payment_method'] === 'Rocket' ? 'selected' : '' ?>>Rocket</option>
          </select>
        </div>

        <div class="form-group">
          <label for="transaction-id">Transaction ID</label>
          <input type="text" id="transaction-id" name="transaction-id" required
            value="<?= $editMode ? htmlspecialchars($editPayment['transaction_id']) : '' ?>">
        </div>

        <?php if ($editMode): ?>
          <input type="hidden" name="edit-id" value="<?= htmlspecialchars($editPayment['id']) ?>">
        <?php endif; ?>

        <div class="form-group full-width">
          <button type="submit" class="submit-btn">
            <?= $editMode ? 'Update Payment' : 'Save Payment' ?>
          </button>
        </div>

      </form>
    </div>
  </div>

</body>
</html>
