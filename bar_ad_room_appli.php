<?php
include 'db_connect.php';
session_start();

$valid_roles = ['student', 'super_admin'];
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], $valid_roles)) {
    header("Location: account_student.php");
    exit();
}

$currentPage = basename($_SERVER['PHP_SELF']);
$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

// Count total applications
$countQuery = "SELECT COUNT(*) AS total FROM room_applications";
$countResult = mysqli_query($conn, $countQuery);
$totalApplications = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalApplications / $limit);

// Redirect if page exceeds total pages
if ($page > $totalPages && $totalPages > 0) {
    header("Location: ?page=$totalPages");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Room Applications</title>
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



  <div class="main-content">
    <div class="table-section">
      <h2 style="color:black;">Room Applications</h2>

      <!-- Optional Success Message -->
      <?php if (isset($_GET['success'])): ?>
        <div class="success-message"><?= htmlspecialchars($_GET['success']) ?></div>
      <?php endif; ?>

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
          $sql = "SELECT ra.*, s.name AS student_name, r.room_number, a.full_name AS admin_name 
                  FROM room_applications ra 
                  JOIN students s ON ra.student_id = s.id 
                  LEFT JOIN rooms r ON ra.room_id = r.id 
                  LEFT JOIN admins a ON ra.processed_by = a.id 
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
                          <a href='bar_ad_room_appli_form.php?id={$row['id']}' class='edit-btn'>Process</a>
                        </td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='9'>No room applications found.</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <!-- Pagination Links -->
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
