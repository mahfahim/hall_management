<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Options</title>
  <!-- reset -->
  <link rel="stylesheet" href="z_reset.css">
  <link rel="stylesheet" href="log_button.css" />
  <link rel="stylesheet" href="z_nav.css">
</head>
<body>

  <!-- Navbar -->
  <?php include 'z_nav.php'; ?>

  <!-- Login Section -->
  <section class="login-section">
    <h1 class="login-title">Login</h1>
    <div class="login-cards">
      <a href="account_admin.php" class="login-card">
        <h2>Admin Login</h2>
      </a>

      <a href="account_student.php" class="login-card">
        <h2>Student Login</h2>
      </a>
    </div>
  </section>

</body>
</html>
