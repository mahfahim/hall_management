<?php
session_start();
include 'db_connect.php'; // Make sure this file connects to your database and sets $conn

// Redirect to login if role is not set
if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];

// Prepare SQL query based on user role
if ($role === 'super_admin') {
    $sql = "SELECT problems.*, students.name AS student_name 
            FROM problems 
            JOIN students ON problems.student_id = students.id 
            ORDER BY problems.created_at DESC";
    $result = mysqli_query($conn, $sql);
} elseif ($role === 'student') {
    $student_id = $_SESSION['student_id'];
    $stmt = mysqli_prepare($conn, "SELECT problems.*, students.name AS student_name 
                                   FROM problems 
                                   JOIN students ON problems.student_id = students.id 
                                   WHERE problems.student_id = ? 
                                   ORDER BY problems.created_at DESC");
    mysqli_stmt_bind_param($stmt, "i", $student_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    // If role is neither super_admin nor student, deny access or redirect
    echo "Access denied.";
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Problem List</title>
    <link rel="stylesheet" href="style3.css"> <!-- Your CSS file -->
</head>
<body>

<div class="sidebar">
    <h2 class="logo">BIJOY 24 HALL</h2>
    <ul class="nav-links">
      <?php if ($role === 'student') { ?>
          <li><a href="#"><i>🎓</i> Student Dashboard</a></li>
          <li><a href="bar_std_payment.php"><i>💳</i> My Payment</a></li>
          <li><a href="bar_ad_room.php"><i>🛏️</i> All Room</a></li>
          <li><a href="bar_std_room_appli.php"><i>🛏️</i> Room Application</a></li>
          <li><a href="bar_std_problem.php"><i>🛠️</i> Problem Assign</a></li>
      <?php } elseif ($role === 'super_admin') { ?>
          <li><a href="bar_admin.php"><i>👨‍💼</i> Admin Dashboard</a></li>
          <li><a href="bar_ad_student.php"><i>👨‍💼</i> All Student</a></li>
          <li><a href="bar_ad_payment.php"><i>💳</i> Payment</a></li>
          <li><a href="bar_ad_room.php"><i>🛏️</i> Room</a></li>
          <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem</a></li>
          <li><a href="bar_ad_room_appli.php"><i>🛠️</i> Room Application</a></li>
          <li><a href="bar_ad_notice.php"><i>📢</i> Notice Manage</a></li>
          <li><a href="bar_ad_settings.php"><i>⚙️</i> Settings</a></li>
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
        <h2 style="text-align:center; margin-bottom: 20px;"><a href="bar_std_problem_form.php" class="add-button">Add Problem</a></h2>
        <h2 style="text-align:center; margin-bottom: 20px;">Reported Problems</h2>

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
    </div>
</div>

</body>
</html>
