<!-- done -->
<?php include 'db_connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Notice Board</title>
  <link rel="stylesheet" href="style.css" />
  <!-- Navbar styles -->
    <link rel="stylesheet" href="z_nav.css">

  <!-- footer styles -->
    <link rel="stylesheet" href="z_foot.css">

  <!-- pagination styles -->
    <link rel="stylesheet" href="z_page.css">


</head>
<body>
   
<!-- navber -->
    <?php include 'z_nav.php'; ?>

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

    <?php
    $limit = 3;
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    // Total notices count
    $count_sql = "SELECT COUNT(*) AS total FROM notices WHERE is_published = 1";
    $count_result = mysqli_query($conn, $count_sql);
    $total_notices = mysqli_fetch_assoc($count_result)['total'];
    $total_pages = ceil($total_notices / $limit);

    // Fetch paginated notices
    $sql = "SELECT title, content, publish_date FROM notices WHERE is_published = 1 ORDER BY publish_date DESC LIMIT $limit OFFSET $offset";
    $result = mysqli_query($conn, $sql);
    ?>

    <tbody>
      <?php
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

<!-- Pagination Links -->
<div class="pagination">
  <?php
  for ($i = 1; $i <= $total_pages; $i++) {
    $active = ($i == $page) ? "active" : "";
    echo "<a class='$active' href='?page=$i'>$i</a>";
  }
  ?>
</div>

    <!-- footer -->
    <?php include 'z_foot.php'; ?>

</body>
</html>
