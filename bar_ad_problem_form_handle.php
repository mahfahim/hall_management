<?php
session_start();

// Check login and role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'super_admin')) {
    header("Location: login.php");
    exit();
}

// DB connection
$conn = mysqli_connect("localhost", "root", "", "hall_management");
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Validate inputs
$problem_id = isset($_POST['problem_id']) ? intval($_POST['problem_id']) : 0;
$reply_message = isset($_POST['reply_message']) ? trim($_POST['reply_message']) : '';

if ($problem_id <= 0 || empty($reply_message)) {
    die("Invalid input.");
}

$admin_id = $_SESSION['admin_id']; // Must be set on login

// Update problem with reply
$sql = "UPDATE problems 
        SET admin_reply = ?, status = 'resolved', resolved_by = ?, resolved_at = NOW() 
        WHERE id = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sii", $reply_message, $admin_id, $problem_id);

if (mysqli_stmt_execute($stmt)) {
    // Activity Log
    $desc = "Replied to problem ID $problem_id";
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    $agent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';

    $log_sql = "INSERT INTO activity_logs (user_type, user_id, action, description, ip_address, user_agent)
                VALUES ('admin', ?, 'Replied to Problem', ?, ?, ?)";
    $log_stmt = mysqli_prepare($conn, $log_sql);
    mysqli_stmt_bind_param($log_stmt, "isss", $admin_id, $desc, $ip, $agent);
    mysqli_stmt_execute($log_stmt);

    header("Location: bar_ad_problem.php?status=reply_success");
    exit();
} else {
    echo "Failed to submit reply. Error: " . mysqli_error($conn);
}
?>
