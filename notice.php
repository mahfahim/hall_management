<?php include 'db_connect.php'; ?>
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
                <?php
                $sql = "SELECT title, content, publish_date FROM notices WHERE is_published = 1 ORDER BY publish_date DESC";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars(date("Y-m-d", strtotime($row['publish_date']))) . "</td>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['content']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No notices available.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
