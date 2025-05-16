<?php
session_start();
$username = isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIJOY-24 Hall</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../style.css">
</head>
<body>

<div class="nav_top">
    <div class="container">
        <header class="header">
            <a href="home.php"><h1>BIJOY-24 Hall</h1></a>            
        </header>
        <nav class="navbar">
            <ul style="display: flex; align-items: center;">
                <li>
                    <a href="#" style="margin-right: 10px;">👤 <?php echo htmlspecialchars($username); ?></a>
                </li>
                <li>
                    <!-- Three-dot toggle button -->
                    <button id="toggleSidebarBtn" style="font-size: 22px; background: none; border: none; cursor: pointer;">☰</button>
                </li>
            </ul>
        </nav>
    </div>
</div>
