<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: account_student.php");
    exit();
}

$student_id = $_SESSION['student_id']; // Logged-in student's ID

// Delete (only if admin, but you can remove delete for student or allow if needed)
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    // For security, make sure this application belongs to this student
    $check = mysqli_query($conn, "SELECT * FROM room_applications WHERE id = '$idToDelete' AND student_id = '$student_id'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "DELETE FROM room_applications WHERE id = '$idToDelete'");
    }
    header("Location: bar_std_room_appli.php");
    exit();
}

// Edit
$editMode = false;
$editApplication = [];

if (isset($_GET['edit'])) {
    $editMode = true;
    $editId = $_GET['edit'];

    // Only allow edit if this application belongs to logged-in student
    $result = mysqli_query($conn, "SELECT * FROM room_applications WHERE id = '$editId' AND student_id = '$student_id'");
    if ($result && mysqli_num_rows($result) > 0) {
        $editApplication = mysqli_fetch_assoc($result);
    } else {
        // Unauthorized access or no record found
        header("Location: bar_std_room_appli.php");
        exit();
    }
}

// Save or Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Use logged-in student's id instead of posted student id to avoid tampering
    $preferred_block = $_POST['preferred-block'];
    $preferred_room_type = $_POST['preferred-room-type'];
    $reason = $_POST['reason'];
    $status = $_POST['status'];
    $edit_id = $_POST['edit-id'] ?? null;

    if ($edit_id) {
        $sql = "UPDATE room_applications SET 
                preferred_block = '$preferred_block',
                preferred_room_type = '$preferred_room_type',
                reason = '$reason',
                status = '$status',
                processed_by = NULL,
                room_id = NULL,
                processed_at = " . ($status !== 'pending' ? "NOW()" : "NULL") . "
                WHERE id = '$edit_id' AND student_id = '$student_id'";
    } else {
        $sql = "INSERT INTO room_applications 
                (student_id, preferred_block, preferred_room_type, reason, status, processed_by, room_id, created_at, updated_at)
                VALUES (
                    '$student_id',
                    '$preferred_block',
                    '$preferred_room_type',
                    '$reason',
                    '$status',
                    NULL,
                    NULL,
                    NOW(),
                    NOW()
                )";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: bar_std_room_appli.php");
        exit();
    } else {
        error_log("MySQL Error: " . mysqli_error($conn));
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Room Application Form</title>
  <link rel="stylesheet" href="style8.css" />
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
    <div class="form-section">
      <h2><?= $editMode ? 'Edit Room Application' : 'New Room Application' ?></h2>
      <form action="" method="POST" novalidate>

        <input type="hidden" name="edit-id" value="<?= htmlspecialchars($editApplication['id'] ?? '') ?>" />

        <label for="preferred-block">Preferred Block</label>
        <input
          type="text"
          id="preferred-block"
          name="preferred-block"
          required
          value="<?= htmlspecialchars($editApplication['preferred_block'] ?? '') ?>"
        />

        <label for="preferred-room-type">Preferred Room Type</label>
        <input
          type="text"
          id="preferred-room-type"
          name="preferred-room-type"
          required
          value="<?= htmlspecialchars($editApplication['preferred_room_type'] ?? '') ?>"
        />

        <label for="reason">Reason</label>
        <textarea
          id="reason"
          name="reason"
          required
        ><?= htmlspecialchars($editApplication['reason'] ?? '') ?></textarea>

        <label for="status">Status</label>
        <select id="status" name="status" required>
          <?php
          $statuses = ['pending', 'approved', 'rejected'];
          $current_status = $editApplication['status'] ?? 'pending';
          foreach ($statuses as $status) {
              $selected = ($status === $current_status) ? 'selected' : '';
              echo "<option value='$status' $selected>" . ucfirst($status) . "</option>";
          }
          ?>
        </select>

        <button type="submit"><?= $editMode ? 'Update' : 'Submit' ?></button>
      </form>
    </div>
  </div>

</body>
</html>
