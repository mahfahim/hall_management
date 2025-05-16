<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

// Delete
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM students WHERE id = '$idToDelete'");
    header("Location: bar_ad_student_form.php");
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
    $room_no = $_POST['room-no'];
    $edit_id = $_POST['edit-id'];

    if ($edit_id) {
        $sql = "UPDATE students SET 
                name = '$student_name',
                email = '$email',
                reg_id = '$reg_id',
                faculty = '$faculty',
                semester = '$semester',
                session = '$session_val',
                room_id = '$room_no'
                WHERE id = '$edit_id'";
    } else {
        $sql = "INSERT INTO students (id, name, reg_id, faculty, semester, session, room_id, email)
                VALUES ('$student_id', '$student_name', '$reg_id', '$faculty', '$semester', '$session_val', '$room_no', '$email')";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: bar_ad_student_form.php");
        exit();
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student Form</title>
  <link rel="stylesheet" href="style4.css">
</head>
<body>

  <div class="sidebar">
    <h2 class="logo">BIJOY 24 HALL</h2>
    <ul class="nav-links">
      <li><a href="bar_admin.php"><i>🏠</i> Home</a></li>

      <?php if ($_SESSION['role'] === 'student') { ?>
          <li><a href="#"><i>🎓</i> Student Dashboard</a></li>
          <li><a href="bar_ad_payment.php"><i>💳</i> My Payment</a></li>
          <li><a href="bar_ad_room.php"><i>🛏️</i> All Room</a></li>
          <li><a href="room_application.php"><i>🛏️</i> Room Application</a></li>
          <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem Assign</a></li>
      <?php } elseif ($_SESSION['role'] === 'super_admin') { ?>
          <li><a href="#"><i>👨‍💼</i> Admin Dashboard</a></li>
          <li><a href="bar_ad_student.php"><i>👨‍💼</i> All Student</a></li>
          <li><a href="bar_ad_payment.php"><i>💳</i> Payment</a></li>
          <li><a href="bar_ad_room.php"><i>🛏️</i> Room</a></li>
          <li><a href="bar_ad_problem.php"><i>🛠️</i> Problem</a></li>
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
    <div class="form-container">
      <h2>Student Form</h2>
      <form action="" method="post">
        <div class="form-group">
          <label for="student-id">ID</label>
          <input type="number" id="student-id" name="student-id" required>
        </div>

        <div class="form-group">
          <label for="student-name">Name</label>
          <input type="text" id="student-name" name="student-name" required>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" required>
        </div>


        <div class="form-group">
          <label for="reg-id">Reg ID</label>
          <input type="text" id="reg-id" name="reg-id" required>
        </div>

        <div class="form-group">
          <label for="faculty">Faculty</label>
          <input type="text" id="faculty" name="faculty" required>
        </div>

        <div class="form-group">
          <label for="semester">Semester</label>
          <input type="text" id="semester" name="semester" required>
        </div>

        <div class="form-group">
          <label for="session">Session</label>
          <input type="text" id="session" name="session" required>
        </div>

        <div class="form-group">
          <label for="room-no">Room No</label>
          <input type="text" id="room-no" name="room-no" required>
        </div>

        <div class="form-group full-width">
          <button type="submit" class="submit-btn">Save Student</button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
