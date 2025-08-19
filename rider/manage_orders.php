<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] != 'rider') {
    header("Location: ../login.php");
    exit;
}

$rider_id = $_SESSION['userid'];

// Get approved restaurant IDs
$rest_ids = [];
$res_result = mysqli_query($conn, "SELECT restaurant_id FROM tbl_rider_applications WHERE rider_id = '$rider_id' AND status = 'approved'");
while ($res = mysqli_fetch_assoc($res_result)) {
    $rest_ids[] = $res['restaurant_id'];
}

if (empty($rest_ids)) {
    echo "<script>alert('You are not assigned to any restaurant yet.'); window.location.href='rider_dashboard.php';</script>";
    exit;
}

$rest_ids_str = implode(",", $rest_ids);

// Fetch orders from assigned restaurants
$order_sql = "
    SELECT o.*, f.name AS food_name, r.name AS restaurant_name
    FROM tbl_orders o
    JOIN tbl_foods f ON o.food_id = f.id
    JOIN tblrestaurants_delivery r ON f.restaurant_id = r.id
    WHERE f.restaurant_id IN ($rest_ids_str)
    ORDER BY o.order_date DESC
";
$orders = mysqli_query($conn, $order_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Manage Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .table thead { background-color: #007bff; color: white; }
    .table tbody tr:hover { background-color: #e9f7fe; }
    .badge-status {
        padding: 0.5em 0.75em;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        color: #fff;
    }
    .badge-pending { background-color: #ffc107; }
    .badge-inprogress { background-color: #17a2b8; }
    .badge-delivered { background-color: #28a745; }
    .btn-action { font-size: 0.85rem; }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0">
      <?php include 'sidebar.php'; ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4">
      <h4 class="mb-4 text-primary">Orders Assigned to You</h4>

      <?php if (mysqli_num_rows($orders) > 0): ?>
        <div class="table-responsive">
          <table class="table table-bordered bg-white align-middle text-center">
            <thead>
              <tr>
                <th>#</th>
                <th>Restaurant</th>
                <th>Food</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Delivery</th>
                <th>Total</th>
                <th>Customer Info</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $i = 1;
              while ($order = mysqli_fetch_assoc($orders)) {
                  $total = $order['total_price'] + $order['delivery_charges'];

                  // Badge color for status
                  $status_lower = strtolower($order['status']);
                  $badge_class = '';
                  switch ($status_lower) {
                      case 'pending': $badge_class = 'badge-pending'; break;
                      case 'in progress': $badge_class = 'badge-inprogress'; break;
                      case 'delivered': $badge_class = 'badge-delivered'; break;
                      default: $badge_class = 'badge-secondary';
                  }

                  echo "<tr>
                      <td>{$i}</td>
                      <td>{$order['restaurant_name']}</td>
                      <td>{$order['food_name']}</td>
                      <td>{$order['quantity']}</td>
                      <td>Rs. {$order['total_price']}</td>
                      <td>Rs. {$order['delivery_charges']}</td>
                      <td><strong>Rs. $total</strong></td>
                      <td>
                          <strong>{$order['full_name']}</strong><br>
                          {$order['city']}<br>
                          {$order['address']}
                      </td>
                      <td><span class='badge badge-status $badge_class'>{$order['status']}</span></td>
                      <td>";
                  
                  if ($status_lower == 'pending') {
                      echo '<a href="mark_order_delivered.php?order_id=' . $order['id'] . '" class="btn btn-primary btn-sm btn-action">Mark Delivered</a>';
                  } else {
                      echo "<span class='text-danger'>Completed</span>";
                  }

                  echo "</td></tr>";
                  $i++;
              }
              ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-warning">No orders available for your assigned restaurants.</div>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
