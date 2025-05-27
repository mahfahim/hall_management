<?php
include 'db_connect.php';
session_start();

// Ensure only super_admin can access this
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header("Location: account_student.php");
    exit();
}

// Validate GET id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid application ID.");
}

$application_id = (int)$_GET['id'];

// Fetch application data
$query = "SELECT * FROM room_applications WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $application_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$application = mysqli_fetch_assoc($result);

if (!$application) {
    die("Application not found.");
}

// Process the form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $status = $_POST['status'];
    $room_id = !empty($_POST['room_id']) ? (int)$_POST['room_id'] : null;
    $admin_id = $_SESSION['admin_id']; // ensure session contains this

    // Update the application
    $sql = "UPDATE room_applications 
            SET status = ?, room_id = ?, processed_by = ?, processed_at = NOW() 
            WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "siii", $status, $room_id, $admin_id, $application_id);
    mysqli_stmt_execute($stmt);

    // Optionally update the student's assigned room
    if ($status === 'approved' && $room_id) {
        $update_student = "UPDATE students SET room_id = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $update_student);
        mysqli_stmt_bind_param($stmt, "ii", $room_id, $application['student_id']);
        mysqli_stmt_execute($stmt);
    }

    header("Location: bar_ad_room_appli.php?success=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Process Room Application</title>
          <!-- reset  -->
  <link rel="stylesheet" href="z_reset.css">
    
     <link rel="stylesheet" href="style9.css">
    

       <!-- sidebar style -->
  <link rel="stylesheet" href="z_side.css" />

</head>
<body>

  <!-- sidebar -->
   <?php include 'z_side.php'; ?>



<div class="main-content">
    <div class="form-section">
        <h2>Process Room Application</h2>
        <p style="color: black;">Student ID: <?= $application['student_id'] ?></p>
        <p style="color: black;">Preferred Block: <?= htmlspecialchars($application['preferred_block']) ?></p>
        <p style="color: black;">Preferred Room Type: <?= htmlspecialchars($application['preferred_room_type']) ?></p>
        <p style="color: black;">Reason: <?= htmlspecialchars($application['reason']) ?></p>

        <form method="POST">
            <label for="status">Update Status:</label>
            <select name="status" id="status" required>
                <option value="approved" <?= $application['status'] == 'approved' ? 'selected' : '' ?>>Approve</option>
                <option value="rejected" <?= $application['status'] == 'rejected' ? 'selected' : '' ?>>Reject</option>
                <option value="waitlisted" <?= $application['status'] == 'waitlisted' ? 'selected' : '' ?>>Waitlist</option>
            </select>

            <label for="room_id">Assign Room (optional):</label>
            <select name="room_id" id="room_id">
                <option value="">-- Select Room --</option>
                <?php
                $rooms = mysqli_query($conn, "SELECT id, room_number, block_name FROM rooms WHERE status = 'available'");
                while ($room = mysqli_fetch_assoc($rooms)) {
                    $selected = $application['room_id'] == $room['id'] ? 'selected' : '';
                    echo "<option value='{$room['id']}' $selected>{$room['room_number']} - {$room['block_name']}</option>";
                }
                ?>
            </select>

            <button type="submit">Submit</button>
        </form>
    </div>
</div>

</body>
</html>
