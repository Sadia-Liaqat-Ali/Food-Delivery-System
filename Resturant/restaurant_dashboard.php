<?php 
session_start();
include '../dbconnection.php';

$rid = $_SESSION['restaurant_id'];
$msg = "";

// Add menu
if (isset($_POST['add_menu'])) {
    $menu_name = $_POST['menu_name'];
    $menu_type = $_POST['menu_type'];
    mysqli_query($conn, "INSERT INTO tbl_menus (restaurant_id, name, type) VALUES ('$rid', '$menu_name', '$menu_type')");
    $msg = "Menu added successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Menus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/auth_style.css"> <!-- keep style consistent -->
</head>
<body class="bg-light">

<div class="container-fluid">
  <div class="row">

    <!-- Sidebar -->
    <div class="col-md-3 col-lg-2 p-0 bg-dark min-vh-100">
      <?php include("sidebar.php"); ?>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 col-lg-10 p-4">

      <!-- Page Header -->
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-primary">🍽 Manage Menus</h3>
        <?php if ($msg): ?>
          <div class="alert alert-success py-2 px-3 shadow-sm mb-0"><?php echo $msg; ?></div>
        <?php endif; ?>
      </div>

      <!-- Add Menu Form -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-semibold">➕ Add New Menu</div>
        <div class="card-body">
          <form method="POST" class="row g-3 align-items-end">
              <div class="col-md-5">
                  <label class="form-label">Menu Name</label>
                  <input type="text" name="menu_name" class="form-control" placeholder="Enter menu name" required>
              </div>
              <div class="col-md-4">
                  <label class="form-label">Menu Type</label>
                  <select name="menu_type" class="form-select" required>
                      <option value="daily">Daily</option>
                      <option value="weekly">Weekly</option>
                      <option value="monthly">Monthly</option>
                  </select>
              </div>
              <div class="col-md-3">
                  <button class="btn btn-success w-100" name="add_menu">Add Menu</button>
              </div>
          </form>
        </div>
      </div>

      <!-- Show Menus with Items -->
      <h4 class="fw-semibold text-secondary mb-3">📋 All Menus with Items</h4>

      <?php
      $menus = mysqli_query($conn, "SELECT * FROM tbl_menus WHERE restaurant_id = '$rid'");
      $count = 1;
      while ($menu = mysqli_fetch_assoc($menus)) {
          $menu_id = $menu['id'];
          $items = mysqli_query($conn, "SELECT * FROM tbl_foods WHERE menu_id = '$menu_id' AND restaurant_id = '$rid'");
      ?>
          <div class="card shadow-sm mb-4">
              <div class="card-header bg-light d-flex justify-content-between align-items-center">
                  <div>
                      <strong class="text-dark">Menu <?php echo $count++; ?>:</strong> 
                      <?php echo htmlspecialchars($menu['name']); ?> 
                      <span class="badge bg-info text-dark ms-2"><?php echo ucfirst($menu['type']); ?></span>
                  </div>
                  <a href="add_items.php?menu_id=<?php echo $menu_id; ?>" class="btn btn-sm btn-outline-primary">
                      ➕ Add Item
                  </a>
              </div>
              <div class="card-body">
                  <?php if (mysqli_num_rows($items) > 0): ?>
                      <ul class="list-group list-group-flush">
                          <?php while ($item = mysqli_fetch_assoc($items)) { ?>
                              <li class="list-group-item d-flex justify-content-between align-items-center">
                                  <span><?php echo htmlspecialchars($item['name']); ?></span>
                                  <span class="badge bg-success">Rs. <?php echo $item['price']; ?></span>
                              </li>
                          <?php } ?>
                      </ul>
                  <?php else: ?>
                      <p class="text-muted fst-italic">No items linked to this menu yet.</p>
                  <?php endif; ?>
              </div>
          </div>
      <?php } ?>
    </div>

  </div>
</div>

</body>
</html>
