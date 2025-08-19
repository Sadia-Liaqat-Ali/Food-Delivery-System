<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['restaurant_id'])) {
    header("Location: ../login.php");
    exit;
}

$rid = $_SESSION['restaurant_id'];

// Fetch payment-related promotions for this restaurant
$payments = mysqli_query($conn, "
    SELECT * FROM tbl_promotions 
    WHERE restaurant_id = '$rid' 
      AND message LIKE '%Payment%' 
    ORDER BY created_at DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Payment Notifications</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background: #f8f9fa;
    }
    .card-custom {
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.05);
      overflow: hidden;
    }
    .card-header-custom {
      background-color: #0d6efd; /* Bootstrap primary */
      color: white;
      font-size: 1.2rem;
      font-weight: 500;
      padding: 15px 20px;
    }
    .table thead {
      background-color: #e9ecef;
    }
    .table tbody tr td i {
      color: #28a745;
      font-size: 1.2rem;
      margin-right: 6px;
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0">
      <?php include("sidebar.php"); ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4">
      <div class="card card-custom">
        
        <!-- Primary Header -->
        <div class="card-header-custom">
          <i class="bi bi-credit-card me-2"></i> Payment Notifications
        </div>

        <div class="card-body">
          <?php if (mysqli_num_rows($payments) > 0): ?>
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead>
                  <tr>
                    <th scope="col">Message</th>
                    <th scope="col" class="text-end">Date</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_assoc($payments)): ?>
                    <tr>
                      <td>
                        <i class="bi bi-cash-coin"></i>
                        <?php echo htmlspecialchars($row['message']); ?>
                      </td>
                      <td class="text-end">
                        <small class="text-muted">
                          <?php echo date('d M, Y h:i A', strtotime($row['created_at'])); ?>
                        </small>
                      </td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <div class="alert alert-info mb-0">No payment notifications yet.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

</body>
</html>
