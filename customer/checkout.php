<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] != 'customer') {
    header("Location: ../login.php");
    exit;
}

$customer_id = $_SESSION['userid'];

// Fetch Cart Items with food and discount
$cart_query = mysqli_query($conn, "SELECT c.*, f.name, f.price, f.discount 
    FROM tbl_cart c 
    JOIN tbl_foods f ON c.food_id = f.id 
    WHERE c.customer_id = '$customer_id'");

$items = [];
$total = 0;

while ($row = mysqli_fetch_assoc($cart_query)) {
    $original_price = $row['price'];
    $discount_percent = $row['discount'];
    $discounted_price = $original_price - ($original_price * $discount_percent / 100);
    $row['discounted_price'] = round($discounted_price);
    $items[] = $row;
    $total += $row['discounted_price'];
}

$delivery_charges = 300;
$grand_total = $total + $delivery_charges;

// Place order
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_method = $_POST['payment_method'];

    // Upload Payment Proof
    $proof_image = '';
    if (!empty($_FILES['proof']['name'])) {
        $proof_image = time() . '_' . $_FILES['proof']['name'];
        move_uploaded_file($_FILES['proof']['tmp_name'], "../uploads/" . $proof_image);
    }

    foreach ($items as $item) {
        $food_id = $item['food_id'];
        $price = $item['discounted_price'];

        mysqli_query($conn, "INSERT INTO tbl_orders 
            (customer_id, food_id, quantity, total_price, delivery_charges, payment_method, full_name, city, address, payment_proof) 
            VALUES 
            ('$customer_id', '$food_id', 1, '$price', '$delivery_charges', '$payment_method', '$fullname', '$city', '$address', '$proof_image')");
    }

    mysqli_query($conn, "DELETE FROM tbl_cart WHERE customer_id = '$customer_id'");

    echo "<script>alert('Order placed successfully!'); window.location.href='my_orders.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Checkout</title>
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

    /* Form border styling */
    .checkout-form {
      background-color: #fff;
      border: 2px solid #007bff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .order-summary-box {
      background-color: #fff;
      border-left: 4px solid #007bff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .order-summary-box h5 {
      color: #007bff;
      font-weight: 600;
      margin-bottom: 1rem;
    }

    .list-group-item {
      border: none;
      padding: 12px 20px;
      font-size: 16px;
    }

    .list-group-item del {
      color: #dc3545;
      margin-right: 5px;
    }

    .form-control, .form-select, textarea {
      border-radius: 6px;
      box-shadow: none;
    }

    .btn-order {
      background: linear-gradient(90deg, #007bff, #0056b3);
      color: #fff;
      font-weight: 500;
      padding: 10px 20px;
      border-radius: 6px;
      border: none;
      width: 100%;
      transition: all 0.3s ease;
    }
    .btn-order:hover {
      background: linear-gradient(90deg, #0056b3, #003f7f);
      transform: translateY(-2px);
      color: #fff;
      text-decoration: none;
    }

    .col-md-6 {
      margin-bottom: 20px;
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
      <h4>Checkout</h4>

      <?php if (count($items) > 0): ?>
      <div class="row">

        <!-- Form -->
        <div class="col-md-6">
          <div class="checkout-form">
            <form method="POST" enctype="multipart/form-data">
              <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>City</label>
                <input type="text" name="city" class="form-control" required>
              </div>
              <div class="mb-3">
                <label>Delivery Address</label>
                <textarea name="address" class="form-control" rows="3" required></textarea>
              </div>
              <div class="mb-3">
                <label>Payment Method</label>
                <select name="payment_method" class="form-select" required>
                  <option value="">-- Select Payment Method --</option>
                  <option value="Cash on Delivery">Cash on Delivery</option>
                  <option value="Credit Card">Credit Card</option>
                  <option value="Online Transfer">Online Transfer</option>
                </select>
              </div>
              <div class="mb-3">
                <label>Upload Payment Proof (Optional)</label>
                <input type="file" name="proof" class="form-control">
              </div>
              <button type="submit" class="btn btn-order">Order Now</button>
            </form>
          </div>
        </div>

        <!-- Summary -->
        <div class="col-md-6">
          <div class="order-summary-box">
            <h5>Order Summary</h5>
            <ul class="list-group mb-3">
              <?php foreach ($items as $item): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                  <?php echo $item['name']; ?>
                  <span>
                    <?php if ($item['discount'] > 0): ?>
                      <del>Rs. <?php echo $item['price']; ?></del>
                    <?php endif; ?>
                    Rs. <?php echo $item['discounted_price']; ?>
                  </span>
                </li>
              <?php endforeach; ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>Delivery Charges</strong>
                <strong>Rs. <?php echo $delivery_charges; ?></strong>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <strong>Total</strong>
                <strong>Rs. <?php echo $grand_total; ?></strong>
              </li>
            </ul>
          </div>
        </div>

      </div>
      <?php else: ?>
        <div class="alert alert-warning">Your cart is empty.</div>
      <?php endif; ?>

    </div>
  </div>
</div>

</body>
</html>
