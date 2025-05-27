<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: account_student.php");
    exit();
}

$student_id = $_SESSION['student_id']; // Student ID must be stored in session
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Payments</title>
        <!-- reset  -->
  <link rel="stylesheet" href="z_reset.css">
    
  <link rel="stylesheet" href="style3.css">

    <!-- sidebar style -->
  <link rel="stylesheet" href="z_side.css" />

   <!-- pagination styles -->
  <link rel="stylesheet" href="z_page.css">

</head>
<body>

  <!-- sidebar -->
   <?php include 'z_side.php'; ?>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    
    <div class="table-section">
      <h2 style="text-align:center; margin-bottom: 20px;"><a href="bar_std_payment_form.php" class="add-button">Add Problem</a></h2>
      <h2 style="text-align: center;">My Payment History</h2>
      <table class="student-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Amount</th>
            <th>Payment Method</th>
            <th>Transaction ID</th>
            <th>Paid At</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $sql = "SELECT * FROM payments WHERE student_id = ?";
          $stmt = mysqli_prepare($conn, $sql);
          mysqli_stmt_bind_param($stmt, "i", $student_id);
          mysqli_stmt_execute($stmt);
          $result = mysqli_stmt_get_result($stmt);

          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>{$row['id']}</td>";
                  echo "<td>" . htmlspecialchars($row['amount']) . "</td>";

                  echo "<td>
                          <select disabled>
                            <option value='Bkash' " . ($row['payment_method'] === 'Bkash' ? 'selected' : '') . ">Bkash</option>
                            <option value='Nagad' " . ($row['payment_method'] === 'Nagad' ? 'selected' : '') . ">Nagad</option>
                            <option value='Rocket' " . ($row['payment_method'] === 'Rocket' ? 'selected' : '') . ">Rocket</option>
                          </select>
                        </td>";

                  echo "<td><input type='text' value='" . htmlspecialchars($row['transaction_id']) . "' readonly></td>";
                  echo "<td>" . htmlspecialchars($row['created_at'] ?? 'N/A') . "</td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='5'>No payment records found.</td></tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>

</body>
</html>
