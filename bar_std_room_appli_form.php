<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'student') {
    header("Location: account_student.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// delete
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $check = mysqli_query($conn, "SELECT * FROM room_applications WHERE id = '$idToDelete' AND student_id = '$student_id'");
    if (mysqli_num_rows($check) > 0) {
        mysqli_query($conn, "DELETE FROM room_applications WHERE id = '$idToDelete'");
    }
    header("Location: bar_std_room_appli.php");
    exit();
}

$editMode = false;
$editApplication = [];

if (isset($_GET['edit'])) {
    $editMode = true;
    $editId = $_GET['edit'];

    $result = mysqli_query($conn, "SELECT * FROM room_applications WHERE id = '$editId' AND student_id = '$student_id'");
    if ($result && mysqli_num_rows($result) > 0) {
        $editApplication = mysqli_fetch_assoc($result);
    } else {
        header("Location: bar_std_room_appli.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $preferred_block = $_POST['preferred-block'];
    $preferred_room_type = $_POST['preferred-room-type'];
    $reason = $_POST['reason'];
    $status = 'pending';
    $edit_id = $_POST['edit-id'] ?? null;

    if ($edit_id) {
        $sql = "UPDATE room_applications SET 
                preferred_block = '$preferred_block',
                preferred_room_type = '$preferred_room_type',
                reason = '$reason',
                status = '$status',
                processed_by = NULL,
                room_id = NULL,
                processed_at = NULL
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
      <li><a href="bar_student.php">🎓 Student Dashboard</a></li>
      <li><a href="bar_std_payment.php">💳 My Payment</a></li>
      <li><a href="bar_ad_room.php">🛏️ All Room</a></li>
      <li><a href="bar_std_room_appli.php">🛏️ Room Application</a></li>
      <li><a href="bar_std_problem.php">🛠️ Problem Assign</a></li>
      <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
    <div class="user-profile">
      <span style="font-size: 40px;">👤</span>
      <span>
        <?= htmlspecialchars($_SESSION['student_name'] ?? 'User'); ?>
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
        <select id="preferred-room-type" name="preferred-room-type" required>
          <?php
            $roomTypes = ['single', 'double', 'triple', 'dormitory'];
            $selectedType = $editApplication['preferred_room_type'] ?? '';
            foreach ($roomTypes as $type) {
                $selected = ($selectedType === $type) ? 'selected' : '';
                echo "<option value='$type' $selected>" . ucfirst($type) . "</option>";
            }
          ?>
        </select>

        <label for="reason">Reason</label>
        <textarea
          id="reason"
          name="reason"
          required
        ><?= htmlspecialchars($editApplication['reason'] ?? '') ?></textarea>

        <button type="submit"><?= $editMode ? 'Update Application' : 'Submit Application' ?></button>
      </form>
    </div>
  </div>

</body>
</html>
