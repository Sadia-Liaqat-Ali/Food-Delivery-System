<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Get all customers
$customers = mysqli_query($conn, "SELECT * FROM tblusers WHERE user_type = 'customer'");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Customer Profiles - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .feedback-box {
      background: #f8f9fa;
      padding: 12px 15px;
      border-radius: 10px;
      border-left: 4px solid #0d6efd;
      margin-bottom: 12px;
    }
    .card {
      border: none;
      box-shadow: 0px 4px 10px rgba(0,0,0,0.08);
    }
    .card-header {
      background-color: #0d6efd !important;
      color: white;
      font-weight: 500;
    }
    ul {
      padding-left: 18px;
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
      <h4 class="mb-4 text-primary fw-bold">Customer Profiles, Orders & Feedback</h4>

      <?php if (mysqli_num_rows($customers) > 0): ?>
        <?php while ($cust = mysqli_fetch_assoc($customers)): ?>
          <div class="card mb-4">
            <div class="card-header">
              <?php echo $cust['name']; ?> 
              <span class="small">(<?php echo $cust['email']; ?>)</span>
            </div>
            <div class="card-body">
              <div class="row">
                
                <!-- Orders and Profile -->
                <div class="col-md-7">
                  <p class="mb-1"><strong>📞 Phone:</strong> <?php echo $cust['mobile']; ?></p>
                  <p class="mb-1"><strong>🏠 Address:</strong> <?php echo $cust['address']; ?></p>
                  <p class="mb-3"><strong>🗓 Joined:</strong> <?php echo date("d M, Y", strtotime($cust['created_at'])); ?></p>

                  <h5 class="mt-3 text-primary">📦 Orders</h5>
                  <?php
                  $cid = $cust['id'];
                  $orders = mysqli_query($conn, "SELECT o.*, f.name AS food_name FROM tbl_orders o LEFT JOIN tbl_foods f ON o.food_id = f.id WHERE o.customer_id = '$cid'");
                  if (mysqli_num_rows($orders) > 0): ?>
                    <ul class="list-unstyled">
                      <?php while ($ord = mysqli_fetch_assoc($orders)): ?>
                        <li class="mb-2">
                          <strong><?php echo $ord['food_name']; ?></strong> - 
                          Qty: <?php echo $ord['quantity']; ?> | 
                          Rs.<?php echo $ord['total_price']; ?> 
                          <span class="badge bg-warning text-dark">Status: <?php echo $ord['status']; ?></span> 
                          <br><small class="text-muted">Ordered on: <?php echo date("d M, Y h:i A", strtotime($ord['order_date'])); ?></small>
                        </li>
                      <?php endwhile; ?>
                    </ul>
                  <?php else: ?>
                    <p class="text-muted">No orders found.</p>
                  <?php endif; ?>
                </div>

                <!-- Feedbacks -->
                <div class="col-md-5">
                  <h5 class="text-danger">💬 Feedback</h5>
                  <?php
                  $feedback = mysqli_query($conn, "SELECT f.*, fd.name AS food_name 
                                                  FROM tbl_feedback f 
                                                  LEFT JOIN tbl_foods fd ON f.food_id = fd.id 
                                                  WHERE f.customer_id = '$cid'");
                  if (mysqli_num_rows($feedback) > 0): ?>
                    <?php while ($fb = mysqli_fetch_assoc($feedback)): ?>
                      <div class="feedback-box">
                        <strong><?php echo $fb['food_name']; ?></strong><br>
                        <small class="text-muted"><?php echo date("d M, Y h:i A", strtotime($fb['created_at'])); ?></small><br>
                        ⭐ <strong><?php echo $fb['rating']; ?>/5</strong><br>
                        <span><?php echo $fb['comment']; ?></span>
                      </div>
                    <?php endwhile; ?>
                  <?php else: ?>
                    <p class="text-muted">No feedback submitted.</p>
                  <?php endif; ?>
                </div>

              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="alert alert-warning">⚠ No customers found.</div>
      <?php endif; ?>
    </div>

  </div>
</div>
</body>
</html>
