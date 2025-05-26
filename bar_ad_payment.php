<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: account_student.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Payments</title>
  <link rel="stylesheet" href="style3.css">
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
    <div class="table-section">
      <h2><a href="bar_ad_payment_form.php" class="add-button">Add Payment</a></h2>
      <h2>Payment List</h2>
      <table class="student-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Reg ID</th>
            <th>Faculty</th>
            <th>Semester</th>
            <th>Session</th>
            <th>Amount</th>
            <th>Method</th>
            <th>Transaction ID</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $limit = 5;
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          $offset = ($page - 1) * $limit;

          $countQuery = "SELECT COUNT(*) AS total FROM payments";
          $countResult = mysqli_query($conn, $countQuery);
          $totalPayments = mysqli_fetch_assoc($countResult)['total'];
          $totalPages = ceil($totalPayments / $limit);

          $sql = "SELECT payments.*, students.name, students.reg_id, students.faculty, students.semester, students.session 
                  FROM payments 
                  LEFT JOIN students ON payments.student_id = students.id 
                  LIMIT $limit OFFSET $offset";
          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>{$row['id']}</td>";
                  echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['reg_id']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['faculty']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['semester']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['session']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['amount']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['payment_method']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['transaction_id']) . "</td>";
                  echo "<td>
                          <a href='bar_ad_payment_form.php?edit={$row['id']}' class='edit-btn'>Edit</a>
                          <a href='bar_ad_payment_form.php?delete={$row['id']}' class='delete-btn' onclick=\"return confirm('Are you sure?')\">Delete</a>
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='10'>No payment records found.</td></tr>";
          }
          ?>
        </tbody>
      </table>

     
      <div class="pagination">
        <?php if ($page > 1): ?>
          <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <a href="?page=<?= $i ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
          <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
        <?php endif; ?>
      </div>

    </div>
  </div>

</body>
</html>
