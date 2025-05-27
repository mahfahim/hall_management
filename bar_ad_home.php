<?php
session_start();


if (!isset($_SESSION['role'])) {
    header("Location: .php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>NexusFlow Sidebar</title>
      <!-- reset  -->
  <link rel="stylesheet" href="z_reset.css">
    
  <link rel="stylesheet" href="style5.css" />

    <!-- sidebar style -->
  <link rel="stylesheet" href="z_side.css" />

</head>
<body>

  <!-- sidebar -->
   <?php include 'z_side.php'; ?>


  <div class="main-content">
    <div class="dashboard">
      <div class="card">
        <h3>Total Students</h3>
        <p>7</p>
      </div>
      <div class="card">
        <h3>Total Rooms</h3>
        <p>8</p>
      </div>
    </div>
  </div>
</body>
</html>
