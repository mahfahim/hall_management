<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: account_student.php");
    exit();
}

$student_id = $_SESSION['student_id'] ?? null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Room Applications</title>
  <link rel="stylesheet" href="style3.css">
</head>
<body>

  <!-- SIDEBAR -->
  <div class="sidebar">
    <h2 class="logo">BIJOY 24 HALL</h2>
    <ul class="nav-links">
      <?php if ($_SESSION['role'] === 'student') { ?>
          <li><a href="bar_student.php">🎓 Student Dashboard</a></li>
          <li><a href="bar_std_payment.php">💳 My Payment</a></li>
          <li><a href="bar_ad_room.php">🛏️ All Room</a></li>
          <li><a href="bar_std_room_appli.php">🛏️ Room Application</a></li>
          <li><a href="bar_std_problem.php">🛠️ Problem Assign</a></li>
      <?php } elseif ($_SESSION['role'] === 'super_admin') { ?>
          <li><a href="bar_admin.php">👨‍💼 Admin Dashboard</a></li>
          <li><a href="bar_ad_student.php">👨‍💼 All Student</a></li>
          <li><a href="bar_ad_payment.php">💳 Payment</a></li>
          <li><a href="bar_ad_room.php">🛏️ Room</a></li>
          <li><a href="bar_ad_problem.php">🛠️ Problem</a></li>
          <li><a href="bar_ad_room_appli.php">🛠️ Room Application</a></li>
          <li><a href="bar_ad_notice.php">📢 Notice Manage</a></li>
      <?php } ?>
      <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
    <div class="user-profile">
      <span style="font-size: 40px;">👤</span>
      <span>
        <?= htmlspecialchars(
          $_SESSION['student_name'] ?? ($_SESSION['admin_name'] ?? 'User')
        ); ?>
      </span>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <div class="table-section">
      <h2 style="text-align:center;"><a href="bar_std_room_appli_form.php" class="add-button">Apply for Room</a></h2>
      <h2 style="text-align:center;">Your Room Applications</h2>
      <table class="student-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Preferred Block</th>
            <th>Room Type</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Assigned Room</th>
            <th>Processed By</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Pagination setup
          $limit = 5;
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          $offset = ($page - 1) * $limit;

          $countQuery = "SELECT COUNT(*) AS total FROM room_applications WHERE student_id = '$student_id'";
          $countResult = mysqli_query($conn, $countQuery);
          $totalApplications = mysqli_fetch_assoc($countResult)['total'];
          $totalPages = ceil($totalApplications / $limit);

          $sql = "SELECT ra.*, s.name AS student_name, r.room_number, a.full_name AS admin_name 
                  FROM room_applications ra 
                  JOIN students s ON ra.student_id = s.id 
                  LEFT JOIN rooms r ON ra.room_id = r.id 
                  LEFT JOIN admins a ON ra.processed_by = a.id 
                  WHERE ra.student_id = '$student_id'
                  ORDER BY ra.created_at DESC
                  LIMIT $limit OFFSET $offset";

          $result = mysqli_query($conn, $sql);

          if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>{$row['id']}</td>";
                  echo "<td>" . htmlspecialchars($row['student_name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['preferred_block']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['preferred_room_type']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['reason']) . "</td>";
                  echo "<td>" . ucfirst($row['status']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['room_number'] ?? 'N/A') . "</td>";
                  echo "<td>" . htmlspecialchars($row['admin_name'] ?? 'Pending') . "</td>";
                  echo "<td>
                          <a href='bar_std_room_appli_form.php?edit={$row['id']}' class='edit-btn'>Edit</a>
                          <a href='bar_std_room_appli_form.php?delete={$row['id']}' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this application?');\">Delete</a>
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='9'>No room applications found.</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <!-- Pagination links -->
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
