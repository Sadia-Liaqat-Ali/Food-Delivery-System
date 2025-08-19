<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] != 'customer') {
    header("Location: ../login.php");
    exit;
}

$customer_id = $_SESSION['userid'];

// Fetch orders
$orders = mysqli_query($conn, "SELECT o.*, f.name AS food_name 
    FROM tbl_orders o 
    JOIN tbl_foods f ON o.food_id = f.id 
    WHERE o.customer_id = '$customer_id' 
    ORDER BY o.order_date DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Orders</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    h4 {
      color: #007bff;
      font-weight: 700;
      margin-bottom: 1.5rem;
    }
    .table-container {
      background-color: #fff;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    table th {
      background-color: #007bff !important;
      color: #fff;
      font-weight: 600;
    }
    table td, table th {
      vertical-align: middle;
    }
    .badge-status {
      padding: 5px 10px;
      border-radius: 10px;
      color: #fff;
      font-weight: 500;
      text-transform: capitalize;
    }
    .status-pending { background-color: #ffc107; }
    .status-processing { background-color: blue; }
    .status-completed { background-color: #198754; }
    .status-cancelled { background-color: #dc3545; }
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
      <h4>My Orders</h4>

      <?php if (mysqli_num_rows($orders) > 0): ?>
      <div class="table-container table-responsive">
        <table class="table table-bordered mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Food</th>
              <th>Qty</th>
              <th>Price (Rs)</th>
              <th>Delivery (Rs)</th>
              <th>Total (Rs)</th>
              <th>Status</th>
              <th>Order Time</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 1;
            while ($order = mysqli_fetch_assoc($orders)) {
              $total_amount = $order['total_price'] + $order['delivery_charges'];
             $status_text = $order['status'];
$status_class = 'badge-status';
switch (strtolower($order['status'])) {
    case 'pending': $status_class .= ' status-pending'; break;
    case 'processing': $status_class .= ' status-processing'; break;
    case 'completed': $status_class .= ' status-completed'; break;
    case 'cancelled': $status_class .= ' status-cancelled'; break;
    default: $status_class .= ' status-pending'; // fallback for unknown statuses
}

              echo "<tr>
                <td>{$i}</td>
                <td>{$order['food_name']}</td>
                <td>{$order['quantity']}</td>
                <td>{$order['total_price']}</td>
                <td>{$order['delivery_charges']}</td>
                <td>{$total_amount}</td>
                <td><span class='badge-status {$status_class}'>{$order['status']}</span></td>


                
                <td>{$order['order_date']}</td>
              </tr>";
              $i++;
            }
            ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
        <div class="alert alert-warning">You have not placed any orders yet.</div>
      <?php endif; ?>

    </div>
  </div>
</div>
</body>
</html>
