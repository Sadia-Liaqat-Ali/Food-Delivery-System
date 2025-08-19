<?php
session_start();
include '../dbconnection.php';

// Get restaurant ID from session
$rid = $_SESSION['restaurant_id'];
$msg = "";

// Get menu_id from URL
$menu_id = isset($_GET['menu_id']) ? $_GET['menu_id'] : null;

// Redirect if menu_id is missing
if (!$menu_id) {
    header("Location: manage_menus.php");
    exit;
}

// Add item to the given menu
if (isset($_POST['add_item'])) {
    $name = $_POST['item_name'];
    $price = $_POST['item_price'];

    // Image upload
    $image = $_FILES['item_image']['name'];
    $tmp = $_FILES['item_image']['tmp_name'];
    $path = "../img/" . $image;
    move_uploaded_file($tmp, $path);

    // Save to database with menu_id
    mysqli_query($conn, "INSERT INTO tbl_foods (restaurant_id, menu_id, name, price, image) 
                         VALUES ('$rid', '$menu_id', '$name', '$price', '$path')");
    $msg = "Item added successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Item</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../style.css"> <!-- common style -->
</head>
<body class="bg-light">

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0">
      <?php include("sidebar.php"); ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4">
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h4 class="mb-4 text-success fw-bold">🍽️ Add New Item to Menu</h4>

          <?php if ($msg): ?>
            <div class="alert alert-success"><?php echo $msg; ?></div>
          <?php endif; ?>

          <form method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Item Name</label>
              <input type="text" name="item_name" class="form-control" placeholder="e.g. Chicken Burger" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Item Price</label>
              <input type="number" name="item_price" class="form-control" placeholder="e.g. 250" required>
            </div>
            <div class="col-12">
              <label class="form-label">Item Image</label>
              <input type="file" name="item_image" class="form-control" required>
            </div>
            <div class="col-12 text-end">
              <button class="btn btn-success px-4" name="add_item">+ Add Item</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>

</body>
</html>
