<?php
session_start();

// Prevent access if not logged in
if (!isset($_SESSION['role'])) {
    header("Location: .php"); // Redirect to login page
    exit();
}
?>

<?php
include 'db_connect.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $category = $_POST['category'];
    $created_by = $_POST['created_by'];
    $is_published = isset($_POST['is_published']) ? 1 : 0;
    $publish_date = $_POST['publish_date'];
    $expiry_date = $_POST['expiry_date'];

    $sql = "INSERT INTO notices (title, content, category, created_by, is_published, publish_date, expiry_date)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssisss", $title, $content, $category, $created_by, $is_published, $publish_date, $expiry_date);

    if (mysqli_stmt_execute($stmt)) {
        $message = "Notice added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Add Notice</title>
    <link rel="stylesheet" href="style4.css" />
</head>
<body>

<div class="main-content">
    <div class="form-container">
        <h2>Add New Notice</h2>
        <?php if ($message): ?>
            <p style="color: #22c55e; text-align: center; margin-bottom: 15px;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" id="title" name="title" required />
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea id="content" name="content" rows="4" style="width:100%; padding: 8px; border-radius: 4px; border:none; background-color: #374151; color: white;" required></textarea>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <select id="category" name="category" required style="width:100%; padding:8px; border-radius:4px; border:none; background-color:#374151; color:white;">
                    <option value="general">General</option>
                    <option value="payment">Payment</option>
                    <option value="room">Room</option>
                    <option value="event">Event</option>
                    <option value="emergency">Emergency</option>
                </select>
            </div>

            <div class="form-group">
                <label for="created_by">Created By (Admin ID)</label>
                <input type="number" id="created_by" name="created_by" required />
            </div>

            <div class="form-group" style="display: flex; align-items: center; gap: 10px;">
                <input type="checkbox" id="is_published" name="is_published" value="1" />
                <label for="is_published" style="margin:0;">Is Published</label>
            </div>

            <div class="form-group">
                <label for="publish_date">Publish Date</label>
                <input type="datetime-local" id="publish_date" name="publish_date" required />
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="datetime-local" id="expiry_date" name="expiry_date" required />
            </div>

            <div class="form-group full-width">
                <button type="submit" class="submit-btn">Add Notice</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
