<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "hall_management";
$conn = mysqli_connect($host, $user, $pass, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Student Problems - Admin Dashboard</title>
  <link rel="stylesheet" href="style3.css" />
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
          <li><a href="bar_ad_room_appli.php"><i>🛠️</i> Room Application</a></li>
          <li><a href="bar_ad_notice.php"><i>📢</i> Notice Manage</a></li>
        
      <?php } ?>
          <li><a href="logout.php"><i>🚪</i> Logout</a></li>
    </ul>

    <div class="user-profile">
      <span style="font-size: 40px;">👤</span>
      <span>
        <?= htmlspecialchars($_SESSION['student_name'] ?? ($_SESSION['admin_name'] ?? 'User')); ?>
      </span>
    </div>
  </div>

  <div class="main-content">
    <div class="table-section">
      <h2 style="text-align:center; margin-bottom: 20px;">Student Problem Section</h2>

      <table class="student-table">
        <thead>
          <tr>
            <th>Student ID</th>
            <th>Name</th>
            <th>Problem</th>
            <th>Admin Reply</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $limit = 5;
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          $offset = ($page - 1) * $limit;

          $countQuery = "SELECT COUNT(*) AS total FROM problems";
          $countResult = mysqli_query($conn, $countQuery);
          $totalProblems = mysqli_fetch_assoc($countResult)['total'];
          $totalPages = ceil($totalProblems / $limit);

          $sql = "SELECT problems.id, students.reg_id, students.name, problems.description, problems.admin_reply
                  FROM problems
                  JOIN students ON problems.student_id = students.id
                  ORDER BY problems.created_at DESC
                  LIMIT $limit OFFSET $offset";

          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['reg_id']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                  echo "<td>" . (!empty($row['admin_reply']) ? htmlspecialchars($row['admin_reply']) : "<em>No reply yet</em>") . "</td>";
                  $btnText = empty($row['admin_reply']) ? 'Reply' : 'Edit Reply';
                  echo "<td><a class='edit-btn' href='bar_ad_problem_form.php?problem_id=" . urlencode($row['id']) . "'>$btnText</a></td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='5'>No problems found.</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <!-- Pagination -->
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
