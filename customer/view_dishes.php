<?php
session_start();
include("../dbconnection.php");

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] != 'customer') {
    header("Location: ../login.php");
    exit;
}

$rid = $_GET['rid'] ?? null;
$menu_id = $_GET['menu_id'] ?? null;

if (!$rid || !$menu_id) {
    echo "<script>alert('Restaurant or Menu not found!'); window.location.href='customer_dashboard.php';</script>";
    exit;
}

$restaurant = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tblrestaurants_delivery WHERE id = '$rid' AND status IN ('active', 'open')"));
if (!$restaurant) {
    echo "<script>alert('This restaurant is not available now.'); window.location.href='customer_dashboard.php';</script>";
    exit;
}

$menu = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tbl_menus WHERE id = '$menu_id' AND restaurant_id = '$rid'"));
if (!$menu) {
    echo "<script>alert('Menu not found!'); window.location.href='customer_dashboard.php';</script>";
    exit;
}

$search = $_GET['search'] ?? '';
$dishes = mysqli_query($conn, "SELECT * FROM tbl_foods WHERE restaurant_id = '$rid' AND menu_id = '$menu_id' AND name LIKE '%$search%'");
?>

<!DOCTYPE html>
<html>
<head>
  <title>View Dishes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f6f9;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Headings */
    .restaurant-title {
      font-size: 1.8rem;
      font-weight: 700;
      color: #007bff;
      margin-bottom: 0.5rem;
    }
    .menu-title {
      font-size: 1.2rem;
      color: #555;
      margin-bottom: 1.5rem;
    }

    /* Discount badge */
    .discount-badge {
      position: absolute;
      top: 10px;
      right: 10px;
      background-color: #dc3545;
      color: white;
      font-size: 14px;
      font-weight: bold;
      padding: 5px 10px;
      border-radius: 50%;
    }

    /* Card image wrapper */
    .image-wrapper {
      position: relative;
      height: 200px;
      overflow: hidden;
      border-top-left-radius: 0.5rem;
      border-top-right-radius: 0.5rem;
    }
    .image-wrapper img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.3s ease;
    }
    .image-wrapper img:hover {
      transform: scale(1.05);
    }

    /* Buttons */
    .btn-add {
      background: linear-gradient(90deg, #007bff, #0056b3);
      border: none;
      color: #fff;
      font-weight: 500;
      transition: all 0.3s ease;
    }
    .btn-add:hover {
      background: linear-gradient(90deg, #0056b3, #003f7f);
      transform: translateY(-2px);
    }

    .btn-feedback {
      background: #6c757d;
      color: white;
      transition: all 0.3s ease;
    }
    .btn-feedback:hover {
      background: #495057;
      transform: translateY(-2px);
    }

    /* Search bar */
    .search-bar input {
      border-radius: 0.375rem 0 0 0.375rem;
    }
    .search-bar button {
      border-radius: 0 0.375rem 0.375rem 0;
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
      <h4 class="restaurant-title">Dishes for: <?php echo $restaurant['name']; ?></h4>
      <h6 class="menu-title">Menu: <?php echo $menu['name']; ?></h6>

      <!-- Search Form -->
      <form method="GET" class="mb-4 d-flex search-bar" action="">
        <input type="hidden" name="rid" value="<?php echo $rid; ?>">
        <input type="hidden" name="menu_id" value="<?php echo $menu_id; ?>">
        <input type="text" name="search" class="form-control me-2" placeholder="Search dish by name..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-primary">Search</button>
      </form>

      <?php if (mysqli_num_rows($dishes) > 0): ?>
        <div class="row">
          <?php while ($dish = mysqli_fetch_assoc($dishes)) { ?>
            <div class="col-md-4 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="image-wrapper">
                  <img src="../uploads/<?php echo $dish['image'] ?? 'noimage.png'; ?>" class="card-img-top">
                  <?php if ($dish['discount'] > 0): ?>
                    <div class="discount-badge"><?php echo $dish['discount']; ?>% Off</div>
                  <?php endif; ?>
                </div>
                <div class="card-body">
                  <h5 class="card-title"><?php echo $dish['name']; ?></h5>
                  <p class="card-text">
                    <strong>Price:</strong>
                    <?php if ($dish['discount'] > 0): ?>
                      <del>Rs. <?php echo $dish['price']; ?></del>
                      <span class="text-success">
                        Rs. <?php echo $dish['price'] - ($dish['price'] * $dish['discount'] / 100); ?>
                      </span>
                    <?php else: ?>
                      Rs. <?php echo $dish['price']; ?>
                    <?php endif; ?>
                  </p>
                  <div class="d-flex justify-content-between">
                    <form action="cart.php" method="POST">
                      <input type="hidden" name="food_id" value="<?php echo $dish['id']; ?>">
                      <input type="hidden" name="restaurant_id" value="<?php echo $dish['restaurant_id']; ?>">
                      <input type="hidden" name="name" value="<?php echo $dish['name']; ?>">
                      <input type="hidden" name="price" value="<?php echo $dish['price']; ?>">
                      <button type="submit" name="add_to_cart" class="btn btn-lg btn-add">Add to Cart</button>
                    </form>
                    <a href="view_feedback.php?food_id=<?php echo $dish['id']; ?>" class="btn btn-lg btn-feedback">Give Feedback</a>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
      <?php else: ?>
        <div class="alert alert-warning">No dishes found in this menu.</div>
      <?php endif; ?>
    </div>
  </div>
</div>

</body>
</html>
