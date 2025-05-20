<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header("Location: account_student.php");
    exit();
}

// Delete Room
if (isset($_GET['delete'])) {
    $idToDelete = intval($_GET['delete']);
    $stmt = mysqli_prepare($conn, "DELETE FROM rooms WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $idToDelete);
    mysqli_stmt_execute($stmt);
    header("Location: bar_ad_room.php");
    exit();
}

// Edit Room
$editMode = false;
$editRoom = [];

if (isset($_GET['edit'])) {
    $editMode = true;
    $editId = intval($_GET['edit']);
    $stmt = mysqli_prepare($conn, "SELECT * FROM rooms WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $editId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $editRoom = mysqli_fetch_assoc($result);
}

// Save or Update Room
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = $_POST['room-number'];
    $block_name = $_POST['block-name'];
    $capacity = intval($_POST['capacity']);
    $current_occupancy = intval($_POST['current-occupancy']);
    $status = $_POST['status'];
    $edit_id = isset($_POST['edit-id']) ? intval($_POST['edit-id']) : null;

    if ($edit_id) {
        $stmt = mysqli_prepare($conn, "UPDATE rooms SET room_number = ?, block_name = ?, capacity = ?, current_occupancy = ?, status = ? WHERE id = ?");
        mysqli_stmt_bind_param($stmt, "ssiisi", $room_number, $block_name, $capacity, $current_occupancy, $status, $edit_id);
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO rooms (room_number, block_name, capacity, current_occupancy, status) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssiis", $room_number, $block_name, $capacity, $current_occupancy, $status);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: bar_ad_room.php");
        exit();
    } else {
        echo "<script>alert('Database error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Room Management</title>
  <link rel="stylesheet" href="style4.css">
</head>
<body>

   <div class="sidebar">
    <h2 class="logo">BIJOY 24 HALL</h2>
    <ul class="nav-links">
      

      <?php if ($_SESSION['role'] === 'student') { ?>
          <li><a href="#"><i>🎓</i> Student Dashboard</a></li>
          <li><a href="bar_std_payment.php"><i>💳</i> My Payment</a></li>
          <li><a href="bar_ad_room.php"><i>🛏️</i> All Room</a></li>
          <li><a href="bar_std_room_appli_form.php"><i>🛏️</i> Room Application</a></li>
          <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem Assign</a></li>
      <?php } elseif ($_SESSION['role'] === 'super_admin') { ?>
          <li><a href="bar_admin.php"><i>👨‍💼</i> Admin Dashboard</a></li>
          <li><a href="bar_ad_student.php"><i>👨‍💼</i> All Student</a></li>
          <li><a href="bar_ad_payment.php"><i>💳</i> Payment</a></li>
          <li><a href="bar_ad_room.php"><i>🛏️</i> Room</a></li>
          <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem</a></li>
          <li><a href="bar_std_room_appli.php"><i>🛠️</i>Room Application</a></li>
          <li><a href="bar_ad_notice.php"><i>📢</i> Notice Manage</a></li>
          <li><a href="bar_ad_settings.php"><i>⚙️</i> Settings</a></li>
      <?php } ?>

          <!-- ✅ Add this logout option -->
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
  <div class="form-container">
    <h2><?= $editMode ? 'Edit Room' : 'Add Room' ?></h2>
    <form action="" method="post">
      <input type="hidden" name="edit-id" value="<?= $editMode ? htmlspecialchars($editRoom['id']) : '' ?>">

      <div class="form-group">
        <label for="room-number">Room Number</label>
        <input type="text" id="room-number" name="room-number" required value="<?= $editMode ? htmlspecialchars($editRoom['room_number']) : '' ?>">
      </div>

      <div class="form-group">
        <label for="block-name">Block Name</label>
        <input type="text" id="block-name" name="block-name" required value="<?= $editMode ? htmlspecialchars($editRoom['block_name']) : '' ?>">
      </div>

      <div class="form-group">
        <label for="capacity">Seat Quantity</label>
        <input type="number" id="capacity" name="capacity" required value="<?= $editMode ? htmlspecialchars($editRoom['capacity']) : '' ?>">
      </div>

      <div class="form-group">
        <label for="current-occupancy">Availability</label>
        <input type="number" id="current-occupancy" name="current-occupancy" required value="<?= $editMode ? htmlspecialchars($editRoom['current_occupancy']) : '' ?>">
      </div>

      <div class="form-group">
        <label for="status">Room Status</label>
        <select id="status" name="status" required>
          <option value="available" <?= $editMode && $editRoom['status'] == 'available' ? 'selected' : '' ?>>Available</option>
          <option value="occupied" <?= $editMode && $editRoom['status'] == 'occupied' ? 'selected' : '' ?>>Occupied</option>
          <option value="under_maintenance" <?= $editMode && $editRoom['status'] == 'under_maintenance' ? 'selected' : '' ?>>Under Maintenance</option>
        </select>
      </div>

      <div class="form-group full-width">
        <button type="submit" class="submit-btn"><?= $editMode ? 'Update Room' : 'Save Room' ?></button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
