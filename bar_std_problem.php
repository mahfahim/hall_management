<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
$limit = 5; // records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Count total rows for pagination
if ($role === 'super_admin') {
    $countQuery = "SELECT COUNT(*) AS total FROM problems";
} elseif ($role === 'student') {
    $student_id = $_SESSION['student_id'];
    $countQuery = "SELECT COUNT(*) AS total FROM problems WHERE student_id = $student_id";
}
$countResult = mysqli_query($conn, $countQuery);
$totalProblems = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalProblems / $limit);

// Get paginated results
if ($role === 'super_admin') {
    $sql = "SELECT problems.*, students.name AS student_name 
            FROM problems 
            JOIN students ON problems.student_id = students.id 
            ORDER BY problems.created_at DESC 
            LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $sql);
} elseif ($role === 'student') {
    $stmt = mysqli_prepare($conn, "SELECT problems.*, students.name AS student_name 
                                   FROM problems 
                                   JOIN students ON problems.student_id = students.id 
                                   WHERE problems.student_id = ? 
                                   ORDER BY problems.created_at DESC 
                                   LIMIT $limit OFFSET $offset");
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    echo "Access denied.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Problem List</title>
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
        <?php if ($role === 'student'): ?>
            <h2 style="text-align:center;"><a href="bar_std_problem_form.php" class="add-button">Add Problem</a></h2>
        <?php endif; ?>
        
        <h2 style="text-align:center; margin-bottom: 20px; color: #000;">Reported Problems</h2>

        <table class="student-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Student</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Admin Reply</th>
                    <th>Resolved By</th>
                    <th>Resolved At</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['student_name']) ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><?= ucfirst(htmlspecialchars($row['category'])) ?></td>
                            <td><?= ucfirst(htmlspecialchars($row['status'])) ?></td>
                            <td><?= htmlspecialchars($row['admin_reply']) ?></td>
                            <td><?= $row['resolved_by'] ? htmlspecialchars($row['resolved_by']) : '-' ?></td>
                            <td><?= $row['resolved_at'] ? htmlspecialchars($row['resolved_at']) : '-' ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="10">No problems reported.</td></tr>
                <?php endif; ?>
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
