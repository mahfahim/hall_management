<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notice Board</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
   
    <header class="navbar" >
        <div class="container">
            <div class="logo">BIJOY 24 HALL</div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="administration.php">Administration</a></li>
                    <li><a href="#">Notice</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="log_button.php">Login</a></li>
                </ul>
            </nav>
        </div>
    </header>
   <hr>
  <h1 class="notice-title">Notice Board</h1>

  <div class="notice-section" id="Notice">
    <table class="notice-table">
      <thead>
        <tr>
          <th>Date</th>
          <th>Title</th>
          <th>Details</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>2025-04-28</td>
          <td>Room Allotment Notice</td>
          <td>Room allotment for new students has been updated. Check the board.</td>
        </tr>
        <tr>
          <td>2025-04-20</td>
          <td>Maintenance Schedule</td>
          <td>Hall maintenance will occur from May 1 to May 3.</td>
        </tr>
        <!-- More rows as needed -->
      </tbody>
    </table>
  </div>

</body>
</html>
