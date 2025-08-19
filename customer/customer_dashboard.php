<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] != 'customer') {
    header("Location: ../login.php");
    exit;
}

$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM tblrestaurants_delivery WHERE type = 'restaurant'";
if (!empty($search)) {
    $query .= " AND name LIKE '%$search%'";
}
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Restaurants</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .header {
      background-color: #007bff;
      color: white;
      padding: 20px 15px;
      font-size: 1.5rem;
      font-weight: 600;
      text-align: center;
      border-radius: 0 0 10px 10px;
      margin-bottom: 20px;
    }
    .search-bar input {
      border-radius: 0.375rem 0 0 0.375rem;
    }
    .search-bar button {
      border-radius: 0 0.375rem 0.375rem 0;
    }
    .card {
      border-radius: 10px;
      transition: transform 0.2s;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .card-title {
      font-weight: 600;
    }
    .badge-status {
      font-size: 0.9rem;
      padding: 0.4em 0.7em;
    }
    .table th, .table td {
      vertical-align: middle;
    }
    .card-footer a {
      transition: all 0.2s;
    }
    .card-footer a:hover {
      background-color: #007bff;
      color: white;
      text-decoration: none;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0 bg-dark text-white" style="min-height: 100vh; overflow-y: auto;">
      <?php include 'sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4">

      <!-- Header -->
      <div class="header">All Restaurants</div>

      <!-- Search Bar -->
      <form method="GET" class="mb-4 search-bar">
        <div class="input-group">
          <input type="text" name="search" class="form-control" placeholder="Search restaurant by name..." value="<?php echo htmlspecialchars($search); ?>">
          <button type="submit" class="btn btn-primary">Search</button>
        </div>
      </form>

      <!-- Restaurant List -->
      <?php
      if (mysqli_num_rows($result) > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
              $rid = $row['id'];
              echo "
              <div class='card mb-4 shadow-sm'>
                <div class='card-body'>
                  <h4 class='card-title text-primary'>{$row['name']}</h4>
                  <p class='mb-1'><strong>Address:</strong> {$row['address']}</p>
                  <p class='mb-1'><strong>Contact:</strong> {$row['contact']}</p>
                  <span class='badge badge-status bg-" . (($row['status'] == 'active' || $row['status'] == 'open') ? "success" : "danger") . "'>
                    " . ucfirst($row['status']) . "
                  </span>
                </div>
              ";

              // Fetch Menus
              $menu_res = mysqli_query($conn, "SELECT * FROM tbl_menus WHERE restaurant_id = $rid");
              if (mysqli_num_rows($menu_res) > 0) {
                  echo "
                  <div class='card-footer p-0'>
                    <table class='table table-hover mb-0'>
                      <thead class='table-light'>
                        <tr>
                          <th>#</th>
                          <th>Menu Name</th>
                          <th>Type</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>";
                  $i = 1;
                  while ($menu = mysqli_fetch_assoc($menu_res)) {
                      echo "
                        <tr>
                          <td>{$i}</td>
                          <td>{$menu['name']}</td>
                          <td class='badge bg-warning'>{$menu['type']}</td>
                          <td><a href='view_dishes.php?menu_id={$menu['id']}&rid={$rid}' class='btn btn-lg btn-outline-primary'>View Available Dishes</a></td>
                        </tr>";
                      $i++;
                  }
                  echo "</tbody></table></div>";
              } else {
                  echo "<div class='card-footer text-danger'>No menus available.</div>";
              }

              echo "</div>";
          }
      } else {
          echo "<div class='alert alert-warning'>No restaurants found.</div>";
      }
      ?>

    </div>
  </div>
</div>

</body>
</html>
