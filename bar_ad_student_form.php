<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role'])) {
    header("Location: account_student.php");
    exit();
}

// Delete
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM students WHERE id = '$idToDelete'");
    header("Location: bar_ad_student.php");
    exit();
}

// Edit
$editMode = false;
$editStudent = [];

if (isset($_GET['edit'])) {
    $editMode = true;
    $editId = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM students WHERE id = '$editId'");
    $editStudent = mysqli_fetch_assoc($result);
    
}

// Save or Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student-id'];
    $student_name = $_POST['student-name'];
    $email = $_POST['email'];
    $reg_id = $_POST['reg-id'];
    $faculty = $_POST['faculty'];
    $semester = $_POST['semester'];
    $session_val = $_POST['session'];
    $room_no = !empty($_POST['room-no']) ? $_POST['room-no'] : 'NULL';
    $edit_id = $_POST['edit-id'] ?? null;

    if ($edit_id) {
        $sql = "UPDATE students SET 
                name = '$student_name',
                email = '$email',
                reg_id = '$reg_id',
                faculty = '$faculty',
                semester = '$semester',
                session = '$session_val',
                room_id = " . ($room_no === 'NULL' ? 'NULL' : "'$room_no'") . "
                WHERE id = '$edit_id'";

    } else {
        $sql = "INSERT INTO students (id, name, reg_id, faculty, semester, session, room_id, email)
                VALUES ('$student_id', '$student_name', '$reg_id', '$faculty', '$semester', '$session_val', " . 
                ($room_no === 'NULL' ? 'NULL' : "'$room_no'") . ", '$email')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: bar_ad_student_form.php");
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
  <meta charset="UTF-8">
  <title>Student Form</title>
        <!-- reset  -->
  <link rel="stylesheet" href="z_reset.css">
    
  <link rel="stylesheet" href="style4.css">

    <!-- sidebar style -->
  <link rel="stylesheet" href="z_side.css" />

</head>
<body>

  <!-- sidebar -->
   <?php include 'z_side.php'; ?>


  <div class="main-content">
    <div class="form-container">
      <h2>Student Form</h2>
      <form action="" method="post">
        <div class="form-group">
          <label for="student-id">ID</label>
          <input type="number" id="student-id" name="student-id" required
            value="<?= $editMode ? htmlspecialchars($editStudent['id']) : '' ?>"
            <?= $editMode ? 'readonly' : '' ?>>
        </div>

        <div class="form-group">
          <label for="student-name">Name</label>
          <input type="text" id="student-name" name="student-name" required
            value="<?= $editMode ? htmlspecialchars($editStudent['name']) : '' ?>">
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required
            value="<?= $editMode ? htmlspecialchars($editStudent['email']) : '' ?>">
        </div>

        <div class="form-group">
          <label for="reg-id">Reg ID</label>
          <input type="text" id="reg-id" name="reg-id" required
            value="<?= $editMode ? htmlspecialchars($editStudent['reg_id']) : '' ?>">
        </div>

        <div class="form-group">
          <label for="faculty">Faculty</label>
          <input type="text" id="faculty" name="faculty" required
            value="<?= $editMode ? htmlspecialchars($editStudent['faculty']) : '' ?>">
        </div>

        <div class="form-group">
          <label for="semester">Semester</label>
          <input type="text" id="semester" name="semester" required
            value="<?= $editMode ? htmlspecialchars($editStudent['semester']) : '' ?>">
        </div>

        <div class="form-group">
          <label for="session">Session</label>
          <input type="text" id="session" name="session" required
            value="<?= $editMode ? htmlspecialchars($editStudent['session']) : '' ?>">
        </div>

        <div class="form-group">
          <label for="room-no">Room No</label>
          <select id="room-no" name="room-no">
            <option value="">--Select Room--</option>
            <?php
            $roomResult = mysqli_query($conn, "SELECT id FROM rooms");
            while ($room = mysqli_fetch_assoc($roomResult)) {
                $selected = ($editMode && $editStudent['room_id'] == $room['id']) ? 'selected' : '';
                echo "<option value='{$room['id']}' $selected>{$room['id']}</option>";
            }
            ?>
          </select>
        </div>

        <?php if ($editMode): ?>
          <input type="hidden" name="edit-id" value="<?= htmlspecialchars($editStudent['id']) ?>">
        <?php endif; ?>

        <div class="form-group full-width">
          <button type="submit" class="submit-btn">
            <?= $editMode ? 'Update Student' : 'Save Student' ?>
          </button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
