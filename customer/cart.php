<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] != 'customer') {
    header("Location: ../login.php");
    exit;
}

$customer_id = $_SESSION['userid'];

// Remove from cart
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM tbl_cart WHERE customer_id = '$customer_id' AND food_id = '$remove_id'");
}

// Handle add to cart
if (isset($_POST['add_to_cart'])) {
    $food_id = $_POST['food_id'];

    $check = mysqli_query($conn, "SELECT * FROM tbl_cart WHERE customer_id = '$customer_id' AND food_id = '$food_id'");
    if (mysqli_num_rows($check) == 0) {
        mysqli_query($conn, "INSERT INTO tbl_cart (customer_id, food_id) VALUES ('$customer_id', '$food_id')");
    }

    header("Location: cart.php");
    exit;
}

// Fetch cart items
$cart_sql = "SELECT c.*, f.name, f.price 
             FROM tbl_cart c 
             JOIN tbl_foods f ON c.food_id = f.id 
             WHERE c.customer_id = '$customer_id'";

$cart_items = mysqli_query($conn, $cart_sql);

if (!$cart_items) {
    die("Query Failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>My Cart</title>
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
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .table th, .table td {
      vertical-align: middle;
    }

    .btn-remove {
      background: #dc3545;
      color: #fff;
      border: none;
      transition: all 0.3s ease;
    }
    .btn-remove:hover {
      background: #b02a37;
      transform: translateY(-2px);
    }

    .btn-checkout {
      background: linear-gradient(90deg, #007bff, #0056b3);
      color: #fff;
      font-weight: 500;
      padding: 10px 25px;
      border-radius: 5px;
      transition: all 0.3s ease;
      margin-top: 15px;
    }
    .btn-checkout:hover {
      background: linear-gradient(90deg, #0056b3, #003f7f);
      transform: translateY(-2px);
      text-decoration: none;
      color: #fff;
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

      <h4>My Cart</h4>

      <?php if (mysqli_num_rows($cart_items) > 0): ?>
        <div class="table-container">
          <table class="table table-bordered mb-0">
            <thead class="table-light">
              <tr>
                <th>#</th>
                <th>Item</th>
                <th>Price (Rs)</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $total = 0;
              $i = 1;
              while ($item = mysqli_fetch_assoc($cart_items)) {
                  $total += $item['price'];
                  echo "<tr>
                          <td>{$i}</td>
                          <td>{$item['name']}</td>
                          <td>{$item['price']}</td>
                          <td><a href='cart.php?remove={$item['food_id']}' class='btn btn-sm btn-remove'>Remove</a></td>
                        </tr>";
                  $i++;
              }
              ?>
              <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td colspan="2"><strong>Rs. <?php echo $total; ?></strong></td>
              </tr>
            </tbody>
          </table>

          <a href="checkout.php" class="btn btn-checkout">Proceed to Checkout</a>
        </div>

      <?php else: ?>
        <div class="alert alert-warning">Your cart is empty.</div>
      <?php endif; ?>

    </div>

  </div>
</div>

</body>
</html>
