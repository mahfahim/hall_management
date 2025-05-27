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
        <!-- reset  -->
  <link rel="stylesheet" href="z_reset.css">
    
  <link rel="stylesheet" href="style3.css" />

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
