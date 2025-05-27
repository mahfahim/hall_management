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
  <title>All Room</title>
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
      <?php if ($_SESSION['role'] === 'super_admin') { ?>
        <h2><a href="bar_ad_room_form.php" class="add-button">Add Room</a></h2>
      <?php } ?>
      <h2>Room List</h2>
      <table class="student-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Room Number</th>
            <th>Block Name</th>
            <th>Capacity</th>
            <th>Current Occupancy</th>
            <th>Status</th>
            <?php if ($_SESSION['role'] === 'super_admin') { ?>
              <th>Action</th>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php
          $limit = 5;
          $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
          $offset = ($page - 1) * $limit;

          $countQuery = "SELECT COUNT(*) AS total FROM rooms";
          $countResult = mysqli_query($conn, $countQuery);
          $totalRooms = mysqli_fetch_assoc($countResult)['total'];
          $totalPages = ceil($totalRooms / $limit);

          $sql = "SELECT * FROM rooms LIMIT $limit OFFSET $offset";
          $result = mysqli_query($conn, $sql);

          if ($result && mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['room_number']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['block_name']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['capacity']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['current_occupancy']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                  if ($_SESSION['role'] === 'super_admin') {
                      echo "<td>
                              <a href='bar_ad_room_form.php?edit={$row['id']}' class='edit-btn'>Edit</a>
                              <a href='bar_ad_room_form.php?delete={$row['id']}' class='delete-btn' onclick=\"return confirm('Are you sure?')\">Delete</a>
                            </td>";
                  }
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='7'>No rooms found.</td></tr>";
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
