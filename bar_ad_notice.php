<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header("Location: account_student.php");
    exit();
}

// Pagination logic
$limit = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Total notice count
$totalResult = mysqli_query($conn, "SELECT COUNT(*) AS total FROM notices");
$totalRow = mysqli_fetch_assoc($totalResult);
$totalPages = ceil($totalRow['total'] / $limit);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Notices</title>
  <link rel="stylesheet" href="style3.css">
</head>
<body>

<!-- Sidebar -->
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
      <li><a href="bar_ad_student.php"><i>👨‍🎓</i> All Student</a></li>
      <li><a href="bar_ad_payment.php"><i>💳</i> Payment</a></li>
      <li><a href="bar_ad_room.php"><i>🛏️</i> Room</a></li>
      <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem</a></li>
      <li><a href="bar_ad_room_appli.php"><i>📝</i> Room Application</a></li>
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

<!-- Main Content -->
<div class="main-content">
  <div class="table-section">
    <h2><a href="bar_ad_notice_form.php" class="add-button">➕ Add Notice</a></h2>
    <h2>Notice List</h2>
    <table class="student-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Category</th>
          <th>Status</th>
          <th>Publish Date</th>
          <th>Expiry Date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT notices.*, admins.full_name 
                FROM notices 
                JOIN admins ON notices.created_by = admins.id 
                ORDER BY publish_date DESC 
                LIMIT $limit OFFSET $offset";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>{$row['id']}</td>";
                echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                echo "<td>" . ucfirst($row['category']) . "</td>";
                echo "<td>" . ($row['is_published'] ? '✅ Published' : '⏳ Unpublished') . "</td>";
                echo "<td>" . htmlspecialchars($row['publish_date']) . "</td>";
                echo "<td>" . ($row['expiry_date'] ?? '—') . "</td>";
                echo "<td>
                        <a href='bar_ad_notice_form.php?edit={$row['id']}' class='edit-btn'>Edit</a>
                        <a href='delete_notice.php?id={$row['id']}' class='delete-btn' onclick=\"return confirm('Are you sure to delete this notice?')\">Delete</a>
                      </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No notices found.</td></tr>";
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
        <a href="?page=<?= $i ?>" class="<?= ($page == $i) ? 'active' : '' ?>"><?= $i ?></a>
      <?php endfor; ?>
      <?php if ($page < $totalPages): ?>
        <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
      <?php endif; ?>
    </div>

  </div>
</div>

</body>
</html>
