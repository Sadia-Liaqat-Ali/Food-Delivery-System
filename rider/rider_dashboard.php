<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] !== 'rider') {
    header("Location: ../login.php");
    exit;
}

$rider_id = $_SESSION['userid'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Rider Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    .restaurant-card {
      transition: transform 0.2s;
    }
    .restaurant-card:hover {
      transform: scale(1.02);
    }
    .restaurant-card .status-badge {
      font-size: 0.9rem;
    }
    .apply-btn {
      min-width: 80px;
    }
    .card-header {
      font-weight: bold;
      font-size: 1.1rem;
    }
  </style>
</head>
<body class="bg-light">

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0">
      <?php include 'sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h2 class="mb-4 text-primary">Available Restaurants</h2>
      <div class="row g-3">
        <?php
        $res = mysqli_query($conn, "SELECT * FROM tblrestaurants_delivery WHERE type = 'restaurant'");
        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                $rest_id = $row['id'];

                // Check if rider already applied
                $check = mysqli_query($conn, "SELECT status FROM tbl_rider_applications WHERE rider_id = '$rider_id' AND restaurant_id = '$rest_id'");
                if (mysqli_num_rows($check) > 0) {
                    $data = mysqli_fetch_assoc($check);
                    $status = ucfirst($data['status']);
                    $action_btn = "<span class='badge bg-success status-badge'>$status</span>";
                } else {
                    $action_btn = "<a href='apply_registration.php?rest_id=$rest_id' class='btn btn-sm btn-primary apply-btn'>Apply</a>";
                }

                echo '<div class="col-md-6 col-lg-4">
                        <div class="card restaurant-card shadow-sm">
                          <div class="card-body">
                            <h5 class="card-title">'.$row['name'].'</h5>
                            <p class="card-text mb-1"><i class="bi bi-telephone"></i> '.$row['contact'].'</p>
                            <p class="card-text mb-1"><i class="bi bi-geo-alt"></i> '.$row['address'].'</p>
                            <p class="card-text text-muted" style="font-size:0.9rem;">'.($row['instructions'] ?? 'No additional instructions').'</p>
                          </div>
                          <div class="card-footer text-end bg-white border-top-0">
                            '.$action_btn.'
                          </div>
                        </div>
                      </div>';
            }
        } else {
            echo '<div class="col-12"><div class="alert alert-info">No restaurants available at the moment.</div></div>';
        }
        ?>
      </div>
    </div>

  </div>
</div>

</body>
</html>
