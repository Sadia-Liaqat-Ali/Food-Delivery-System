<?php
session_start();
include '../dbconnection.php';

$rid = $_SESSION['restaurant_id']; 
$msg = "";

// Update open/close status
if (isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    $update = mysqli_query($conn, "UPDATE tblrestaurants_delivery SET status = '$new_status' WHERE id = '$rid'");

    if ($update) {
        $msg = "Status updated to $new_status.";
    } else {
        $msg = "Error updating status.";
    }
}

// Fetch current status
$current_status = "Not Set";
$res = mysqli_query($conn, "SELECT status FROM tblrestaurants_delivery WHERE id = '$rid'");
if ($res && mysqli_num_rows($res) > 0) {
    $data = mysqli_fetch_assoc($res);
    $current_status = $data['status'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Restaurant Status</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css"> <!-- custom style file -->
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
      <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Restaurant Status</h4>
        </div>
        <div class="card-body">

          <?php if ($msg): ?>
            <div class="alert alert-info"><?php echo $msg; ?></div>
          <?php endif; ?>

          <form method="POST" class="p-3">
              <div class="mb-3">
                <label class="form-label fw-bold">Current Status:</label>
                <span class="badge 
                    <?php echo ($current_status == 'open') ? 'bg-success' : 'bg-danger'; ?> fs-6">
                    <?php echo strtoupper($current_status); ?>
                </span>
              </div>

              <div class="mb-3">
                <label class="form-label">Change Status</label>
                <select name="status" class="form-select" required>
                    <option value="open" <?php if ($current_status == 'open') echo 'selected'; ?>>Open</option>
                    <option value="closed" <?php if ($current_status == 'closed') echo 'selected'; ?>>Closed</option>
                </select>
              </div>

              <button class="btn btn-primary px-4" name="update_status">
                <i class="bi bi-check-circle"></i> Update Status
              </button>
          </form>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>
</html>
