<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login Options</title>
  <link rel="stylesheet" href="style.css" />
  <!-- Navbar styles -->
    <link rel="stylesheet" href="z_nav.css">
</head>
<body>
  
    <!-- navber -->
    <?php include 'z_nav.php'; ?>

    <hr>

  <section class="login-section">
    <h1 class="login-title">Login</h1>
    <div class="login-cards">
      <!-- Admin Login Card -->
      <a href="account_admin.php" class="login-card">
        <h2>Admin Login</h2>
      </a>

      <!-- Student Login Card -->
      <a href="account_student.php" class="login-card">
        <h2>Student Login</h2>
      </a>
    </div>
  </section>

</body>
</html>
