<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'super_admin') {
    header("Location: account_student.php");
    exit();
}

$editMode = false;
$editNotice = [];

if (isset($_GET['edit'])) {
    $editMode = true;
    $editId = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM notices WHERE id = '$editId'");
    $editNotice = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $created_by = $_POST['created_by'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $publish_date = $_POST['publish_date'];
    $expiry_date = $_POST['expiry_date'];
    $edit_id = $_POST['edit-id'] ?? null;

    if ($edit_id) {
        $sql = "UPDATE notices SET title=?, content=?, category=?, created_by=?, is_published=?, publish_date=?, expiry_date=? WHERE id=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssisssi", $title, $content, $category, $created_by, $is_published, $publish_date, $expiry_date, $edit_id);
    } else {
        $sql = "INSERT INTO notices (title, content, category, created_by, is_published, publish_date, expiry_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssisss", $title, $content, $category, $created_by, $is_published, $publish_date, $expiry_date);
    }

    if (mysqli_stmt_execute($stmt)) {
        header("Location: bar_ad_notice.php");
        exit();
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $editMode ? 'Edit Notice' : 'Add Notice' ?></title>
  <link rel="stylesheet" href="style4.css">

    <!-- sidebar style -->
  <link rel="stylesheet" href="z_side.css" />

</head>
<body>

  <!-- sidebar -->
   <?php include 'z_side.php'; ?>

  <div class="main-content">
    <div class="form-container">
      <h2><?= $editMode ? 'Edit Notice' : 'Add New Notice' ?></h2>
      <form method="POST" action="">
        <?php if ($editMode): ?>
          <input type="hidden" name="edit-id" value="<?= $editNotice['id'] ?>">
        <?php endif; ?>

        <div class="form-group">
          <label for="title">Title</label>
          <input type="text" id="title" name="title" required value="<?= $editMode ? htmlspecialchars($editNotice['title']) : '' ?>">
        </div>

        <div class="form-group">
          <label for="content">Content</label>
          <textarea id="content" name="content" rows="4" required><?= $editMode ? htmlspecialchars($editNotice['content']) : '' ?></textarea>
        </div>

        <div class="form-group">
          <label for="category">Category</label>
          <select id="category" name="category" required>
            <option value="general" <?= $editMode && $editNotice['category'] === 'general' ? 'selected' : '' ?>>General</option>
            <option value="payment" <?= $editMode && $editNotice['category'] === 'payment' ? 'selected' : '' ?>>Payment</option>
            <option value="room" <?= $editMode && $editNotice['category'] === 'room' ? 'selected' : '' ?>>Room</option>
            <option value="event" <?= $editMode && $editNotice['category'] === 'event' ? 'selected' : '' ?>>Event</option>
            <option value="emergency" <?= $editMode && $editNotice['category'] === 'emergency' ? 'selected' : '' ?>>Emergency</option>
          </select>
        </div>

        <div class="form-group">
          <label for="created_by">Created By (Admin ID)</label>
          <input type="number" id="created_by" name="created_by" required value="<?= $editMode ? htmlspecialchars($editNotice['created_by']) : '' ?>">
        </div>

        <div class="form-group">
          <label for="publish_date">Publish Date</label>
          <input type="datetime-local" id="publish_date" name="publish_date" required value="<?= $editMode ? date('Y-m-d\TH:i', strtotime($editNotice['publish_date'])) : '' ?>">
        </div>

        <div class="form-group">
          <label for="expiry_date">Expiry Date</label>
          <input type="datetime-local" id="expiry_date" name="expiry_date" value="<?= $editMode && $editNotice['expiry_date'] ? date('Y-m-d\TH:i', strtotime($editNotice['expiry_date'])) : '' ?>">
        </div>

        <div class="form-group">
          <label><input type="checkbox" name="is_published" <?= $editMode && $editNotice['is_published'] ? 'checked' : '' ?>> Publish Now</label>
        </div>

        <div class="form-group">
          <button type="submit" class="submit-btn"><?= $editMode ? 'Update Notice' : 'Create Notice' ?></button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
