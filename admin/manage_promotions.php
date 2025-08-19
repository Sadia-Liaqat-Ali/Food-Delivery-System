<?php
session_start();
include '../dbconnection.php';

if (!isset($_SESSION['userid']) || $_SESSION['user_type'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

$msg = "";

// Add promotion
if (isset($_POST['add_promo'])) {
    $restaurant_id = $_POST['restaurant_id'];
    $message = $_POST['message'];
    mysqli_query($conn, "INSERT INTO tbl_promotions (restaurant_id, message) VALUES ('$restaurant_id', '$message')");
    $msg = "Promotion added successfully.";
}

// Update promotion
if (isset($_POST['update_promo'])) {
    $promo_id = $_POST['promo_id'];
    $message = $_POST['message'];
    mysqli_query($conn, "UPDATE tbl_promotions SET message = '$message' WHERE id = '$promo_id'");
    $msg = "Promotion updated.";
}

// Delete promotion
if (isset($_GET['delete_id'])) {
    $promo_id = $_GET['delete_id'];
    mysqli_query($conn, "DELETE FROM tbl_promotions WHERE id = '$promo_id'");
    $msg = "Promotion deleted.";
}

// Fetch all promotions
$promotions = mysqli_query($conn, "
  SELECT p.*, r.name AS restaurant_name 
  FROM tbl_promotions p 
  LEFT JOIN tblrestaurants_delivery r ON p.restaurant_id = r.id 
  ORDER BY p.created_at DESC
");

// Fetch restaurants for dropdown
$restaurants = mysqli_query($conn, "SELECT id, name FROM tblrestaurants_delivery");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Manage Promotions - Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-primary">📢 Manage Restaurant Promotions</h4>
      </div>

      <?php if ($msg): ?>
        <div class="alert alert-info shadow-sm"><?php echo $msg; ?></div>
      <?php endif; ?>

      <!-- Add Promotion Form -->
      <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white fw-bold">➕ Add New Promotion</div>
        <div class="card-body">
          <form method="POST">
            <div class="row g-3">
              <div class="col-md-5">
                <label class="form-label fw-semibold">Restaurant</label>
                <select name="restaurant_id" class="form-select" required>
                  <option value="">Select Restaurant</option>
                  <?php while ($r = mysqli_fetch_assoc($restaurants)): ?>
                    <option value="<?php echo $r['id']; ?>"><?php echo $r['name']; ?></option>
                  <?php endwhile; ?>
                </select>
              </div>
              <div class="col-md-5">
                <label class="form-label fw-semibold">Promotion Message</label>
                <input type="text" name="message" class="form-control" placeholder="Enter promotion message" required>
              </div>
              <div class="col-md-2 d-flex align-items-end">
                <button type="submit" name="add_promo" class="btn btn-success w-100">Add</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Promotions Table -->
      <div class="card shadow-sm">
        <div class="card-header bg-primary text-white fw-bold">📋 All Promotions</div>
        <div class="card-body table-responsive">
          <table class="table table-bordered align-middle">
            <thead class="table-primary">
              <tr>
                <th>#</th>
                <th>Restaurant</th>
                <th>Message</th>
                <th>Created</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1; while ($promo = mysqli_fetch_assoc($promotions)) { ?>
                <tr>
                  <td><?php echo $i++; ?></td>
                  <td class="fw-semibold"><?php echo $promo['restaurant_name']; ?></td>
                  <td>
                    <form method="POST" class="d-flex">
                      <input type="hidden" name="promo_id" value="<?php echo $promo['id']; ?>">
                      <input type="text" name="message" class="form-control me-2" value="<?php echo htmlspecialchars($promo['message']); ?>">
                      <button type="submit" name="update_promo" class="btn btn-warning btn-sm">Update</button>
                    </form>
                  </td>
                  <td><?php echo $promo['created_at']; ?></td>
                  <td>
                    <a href="?delete_id=<?php echo $promo['id']; ?>" 
                       class="btn btn-danger btn-sm" 
                       onclick="return confirm('Delete this promotion?')">
                       Delete
                    </a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>
</body>
</html>
