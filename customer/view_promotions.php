<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] != 'customer') {
    header("Location: ../login.php");
    exit;
}

// Fetch all promotions
$promotions = mysqli_query($conn, "
    SELECT p.*, r.name AS restaurant_name 
    FROM tbl_promotions p 
    JOIN tblrestaurants_delivery r ON p.restaurant_id = r.id
    ORDER BY p.created_at DESC
");
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Promotions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0 bg-dark text-white" style="min-height: 100vh; overflow-y: auto;">
      <?php include 'sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h4 class="mb-4">Available Promotions</h4>

      <?php if (mysqli_num_rows($promotions) > 0): ?>
        <div class="row">
          <?php while ($promo = mysqli_fetch_assoc($promotions)) { ?>
            <div class="col-md-6 mb-3">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5 class="card-title text-primary"><?php echo $promo['restaurant_name']; ?></h5>
                  <p class="card-text"><?php echo $promo['message']; ?></p>
                  <small class="text-muted">Posted on: <?php echo date("d-M-Y h:i A", strtotime($promo['created_at'])); ?></small>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php else: ?>
        <div class="alert alert-info">No promotions available at this time.</div>
      <?php endif; ?>
    </div>

  </div>
</div>
</body>
</html>
